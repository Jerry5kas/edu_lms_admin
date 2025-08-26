<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Course;
use App\Services\PaymentGatewayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderApiController extends Controller
{
    protected $paymentGatewayService;

    public function __construct(PaymentGatewayService $paymentGatewayService)
    {
        $this->paymentGatewayService = $paymentGatewayService;
    }

    /**
     * Get user's orders
     */
    public function myOrders(Request $request)
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['items.course', 'payments'])
            ->withCount('items')
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }

    /**
     * Get order details
     */
    public function show(Order $order)
    {
        // Ensure user can only view their own orders
        if ($order->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access',
            ], 403);
        }

        $order->load(['items.course', 'payments', 'invoice']);

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    /**
     * Create a new order
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'courses' => 'required|array|min:1',
            'courses.*.course_id' => 'required|exists:courses,id',
            'courses.*.quantity' => 'required|integer|min:1',
            'currency' => 'required|string|size:3',
            'discount_cents' => 'nullable|integer|min:0',
            'tax_cents' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Calculate totals
            $amountCents = 0;
            $orderItems = [];

            foreach ($request->courses as $item) {
                $course = Course::find($item['course_id']);
                
                // Check if course is published
                if (!$course->is_published) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Course is not available for purchase',
                    ], 400);
                }

                $unitPrice = $course->price * 100; // Convert to cents
                $lineTotal = $unitPrice * $item['quantity'];
                $amountCents += $lineTotal;

                $orderItems[] = [
                    'course_id' => $item['course_id'],
                    'unit_price_cents' => $unitPrice,
                    'quantity' => $item['quantity'],
                    'line_total_cents' => $lineTotal,
                ];
            }

            $discountCents = $request->discount_cents ?? 0;
            $taxCents = $request->tax_cents ?? 0;
            $totalCents = $amountCents - $discountCents + $taxCents;

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'currency' => $request->currency,
                'amount_cents' => $amountCents,
                'discount_cents' => $discountCents,
                'tax_cents' => $taxCents,
                'total_cents' => $totalCents,
                'status' => 'pending',
                'gateway' => 'razorpay',
                'gateway_order_id' => 'ORD_' . time() . '_' . rand(1000, 9999),
                'placed_at' => now(),
            ]);

            // Create order items
            foreach ($orderItems as $item) {
                $order->items()->create($item);
            }

            // Create Razorpay order
            $razorpayOrder = $this->paymentGatewayService->createOrder($order);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => [
                    'order' => $order->load(['items.course']),
                    'razorpay_order_id' => $razorpayOrder->id,
                ],
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Cancel order
     */
    public function cancel(Order $order)
    {
        // Ensure user can only cancel their own orders
        if ($order->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access',
            ], 403);
        }

        // Only allow cancellation of pending orders
        if ($order->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Only pending orders can be cancelled',
            ], 400);
        }

        $order->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order cancelled successfully',
            'data' => $order,
        ]);
    }

    /**
     * Get payment link for order
     */
    public function getPaymentLink(Order $order)
    {
        // Ensure user can only get payment link for their own orders
        if ($order->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access',
            ], 403);
        }

        // Only allow payment links for pending orders
        if ($order->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Payment link is only available for pending orders',
            ], 400);
        }

        try {
            $paymentLink = $this->paymentGatewayService->createPaymentLink($order);

            return response()->json([
                'success' => true,
                'data' => [
                    'payment_link' => $paymentLink->short_url,
                    'payment_link_id' => $paymentLink->id,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create payment link: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Verify payment
     */
    public function verifyPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Verify signature
            $isValid = $this->paymentGatewayService->verifyPaymentSignature(
                $request->razorpay_payment_id,
                $request->razorpay_order_id,
                $request->razorpay_signature
            );

            if (!$isValid) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid payment signature',
                ], 400);
            }

            // Find order
            $order = Order::where('gateway_order_id', $request->razorpay_order_id)
                ->where('user_id', Auth::id())
                ->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found',
                ], 404);
            }

            // Get payment details from Razorpay
            $razorpayPayment = $this->paymentGatewayService->getPaymentDetails($request->razorpay_payment_id);

            // Create or update payment record
            $payment = Payment::updateOrCreate(
                ['gateway_payment_id' => $request->razorpay_payment_id],
                [
                    'order_id' => $order->id,
                    'user_id' => Auth::id(),
                    'amount_cents' => $razorpayPayment->amount,
                    'currency' => $razorpayPayment->currency,
                    'gateway' => 'razorpay',
                    'gateway_signature' => $request->razorpay_signature,
                    'method' => $razorpayPayment->method,
                    'status' => $razorpayPayment->status,
                    'raw_payload' => $razorpayPayment->toArray(),
                ]
            );

            // Update order status if payment is captured
            if ($razorpayPayment->status === 'captured') {
                $order->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Payment verified successfully',
                'data' => [
                    'order' => $order->load(['items.course']),
                    'payment' => $payment,
                    'payment_status' => $razorpayPayment->status,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to verify payment: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get order statistics
     */
    public function statistics()
    {
        $userId = Auth::id();

        $stats = [
            'total_orders' => Order::where('user_id', $userId)->count(),
            'total_spent' => Order::where('user_id', $userId)
                ->where('status', 'paid')
                ->sum('total_cents') / 100,
            'pending_orders' => Order::where('user_id', $userId)
                ->where('status', 'pending')
                ->count(),
            'completed_orders' => Order::where('user_id', $userId)
                ->where('status', 'paid')
                ->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }

    /**
     * Get available courses for purchase
     */
    public function availableCourses()
    {
        $courses = Course::where('is_published', true)
            ->select('id', 'title', 'description', 'price', 'currency', 'thumbnail')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $courses,
        ]);
    }
}
