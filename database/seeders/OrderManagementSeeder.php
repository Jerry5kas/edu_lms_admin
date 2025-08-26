<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Refund;
use App\Models\Invoice;
use App\Models\WebhookEvent;
use App\Models\User;
use App\Models\Course;

class OrderManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some users and courses for sample data
        $users = User::take(5)->get();
        $courses = Course::where('is_published', true)->take(10)->get();

        if ($users->isEmpty() || $courses->isEmpty()) {
            $this->command->info('No users or courses found. Please run UserSeeder and CourseSeeder first.');
            return;
        }

        // Create sample orders
        foreach ($users as $user) {
            $this->createSampleOrders($user, $courses);
        }

        $this->command->info('Order management sample data created successfully!');
    }

    private function createSampleOrders(User $user, $courses)
    {
        // Create 2-4 orders per user
        $numOrders = rand(2, 4);

        for ($i = 0; $i < $numOrders; $i++) {
            $order = $this->createOrder($user, $courses);
            
            // Create payment for some orders
            if (rand(1, 3) > 1) {
                $payment = $this->createPayment($order);
                
                // Create refund for some payments
                if (rand(1, 5) === 1) {
                    $this->createRefund($payment);
                }

                // Create invoice for paid orders
                if ($order->status === 'paid') {
                    $this->createInvoice($order);
                }
            }
        }
    }

    private function createOrder(User $user, $courses)
    {
        $statuses = ['pending', 'paid', 'failed', 'cancelled', 'refunded'];
        $status = $statuses[array_rand($statuses)];
        
        // Select 1-3 random courses
        $selectedCourses = $courses->random(rand(1, 3));
        
        $amountCents = 0;
        $orderItems = [];

        foreach ($selectedCourses as $course) {
            $quantity = rand(1, 2);
            $unitPrice = $course->price * 100; // Convert to cents
            $lineTotal = $unitPrice * $quantity;
            $amountCents += $lineTotal;

            $orderItems[] = [
                'course_id' => $course->id,
                'unit_price_cents' => $unitPrice,
                'quantity' => $quantity,
                'line_total_cents' => $lineTotal,
            ];
        }

        $discountCents = rand(0, $amountCents * 0.1); // 0-10% discount
        $taxCents = rand(0, $amountCents * 0.05); // 0-5% tax
        $totalCents = $amountCents - $discountCents + $taxCents;

        $order = Order::create([
            'user_id' => $user->id,
            'currency' => 'INR',
            'amount_cents' => $amountCents,
            'discount_cents' => $discountCents,
            'tax_cents' => $taxCents,
            'total_cents' => $totalCents,
            'status' => $status,
            'gateway' => 'razorpay',
            'gateway_order_id' => 'ORD_' . time() . '_' . rand(1000, 9999),
            'notes' => ['admin_notes' => 'Sample order for testing'],
            'placed_at' => now()->subDays(rand(1, 30)),
        ]);

        // Create order items
        foreach ($orderItems as $item) {
            $order->items()->create($item);
        }

        // Set appropriate timestamps based on status
        switch ($status) {
            case 'paid':
                $order->update(['paid_at' => $order->placed_at->addMinutes(rand(5, 60))]);
                break;
            case 'failed':
                $order->update(['failed_at' => $order->placed_at->addMinutes(rand(5, 30))]);
                break;
            case 'cancelled':
                $order->update(['cancelled_at' => $order->placed_at->addHours(rand(1, 24))]);
                break;
            case 'refunded':
                $order->update([
                    'paid_at' => $order->placed_at->addMinutes(rand(5, 60)),
                    'refunded_at' => $order->placed_at->addDays(rand(1, 7))
                ]);
                break;
        }

        return $order;
    }

    private function createPayment(Order $order)
    {
        $statuses = ['created', 'authorized', 'captured', 'failed', 'refunded'];
        $status = $statuses[array_rand($statuses)];
        
        $methods = ['card', 'upi', 'netbanking'];
        $method = $methods[array_rand($methods)];

        $payment = Payment::create([
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'amount_cents' => $order->total_cents,
            'currency' => $order->currency,
            'gateway' => 'razorpay',
            'gateway_payment_id' => 'pay_' . time() . '_' . rand(1000, 9999),
            'gateway_signature' => 'sample_signature_' . rand(1000, 9999),
            'method' => $method,
            'status' => $status,
            'raw_payload' => [
                'payment_id' => 'pay_' . time() . '_' . rand(1000, 9999),
                'amount' => $order->total_cents,
                'currency' => $order->currency,
                'method' => $method,
                'status' => $status,
            ],
        ]);

        // Set appropriate timestamps
        if ($status === 'captured') {
            $payment->update(['captured_at' => $payment->created_at->addMinutes(rand(1, 10))]);
        } elseif ($status === 'refunded') {
            $payment->update(['refunded_at' => $payment->created_at->addDays(rand(1, 7))]);
        }

        return $payment;
    }

    private function createRefund(Payment $payment)
    {
        $refund = Refund::create([
            'payment_id' => $payment->id,
            'amount_cents' => $payment->amount_cents,
            'reason' => 'Customer request',
            'gateway_refund_id' => 'ref_' . time() . '_' . rand(1000, 9999),
            'status' => 'processed',
            'raw_payload' => [
                'refund_id' => 'ref_' . time() . '_' . rand(1000, 9999),
                'amount' => $payment->amount_cents,
                'reason' => 'Customer request',
                'status' => 'processed',
            ],
        ]);

        return $refund;
    }

    private function createInvoice(Order $order)
    {
        $addressData = [
            'name' => $order->user->name,
            'address' => '123 Sample Street',
            'city' => 'Sample City',
            'state' => 'Sample State',
            'country' => 'India',
            'zip' => '123456',
        ];

        $lineItems = [];
        foreach ($order->items as $item) {
            $lineItems[] = [
                'course_title' => $item->course->title,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price_cents / 100,
                'line_total' => $item->line_total_cents / 100,
            ];
        }

        $totalsData = [
            'subtotal' => $order->amount_cents / 100,
            'discount' => $order->discount_cents / 100,
            'tax' => $order->tax_cents / 100,
            'total' => $order->total_cents / 100,
            'currency' => $order->currency,
        ];

        Invoice::create([
            'order_id' => $order->id,
            'invoice_no' => Invoice::generateInvoiceNumber(),
            'issued_at' => $order->paid_at,
            'billing_name' => $order->user->name,
            'address_json' => $addressData,
            'line_items_json' => $lineItems,
            'totals_json' => $totalsData,
        ]);
    }

    private function createSampleWebhooks()
    {
        $eventTypes = [
            'payment.captured',
            'payment.failed',
            'refund.processed',
            'order.paid',
        ];

        for ($i = 0; $i < 20; $i++) {
            $eventType = $eventTypes[array_rand($eventTypes)];
            $statuses = ['pending', 'processed', 'failed'];
            $status = $statuses[array_rand($statuses)];

            WebhookEvent::create([
                'provider' => 'razorpay',
                'event_type' => $eventType,
                'event_id' => 'evt_' . time() . '_' . rand(1000, 9999),
                'payload' => [
                    'event' => $eventType,
                    'id' => 'evt_' . time() . '_' . rand(1000, 9999),
                    'payload' => [
                        'payment' => [
                            'entity' => [
                                'id' => 'pay_' . time() . '_' . rand(1000, 9999),
                                'amount' => rand(1000, 10000),
                                'currency' => 'INR',
                                'status' => 'captured',
                            ]
                        ]
                    ]
                ],
                'processing_status' => $status,
                'received_at' => now()->subDays(rand(1, 30)),
                'processed_at' => $status === 'pending' ? null : now()->subDays(rand(1, 30)),
            ]);
        }
    }
}
