<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\WebhookEvent;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    /**
     * Display a listing of webhook events (admin)
     */
    public function index(Request $request)
    {
        $query = WebhookEvent::latest('received_at');

        // Filter by provider
        if ($request->has('provider') && $request->provider !== '') {
            $query->where('provider', $request->provider);
        }

        // Filter by event type
        if ($request->has('event_type') && $request->event_type !== '') {
            $query->where('event_type', $request->event_type);
        }

        // Filter by processing status
        if ($request->has('processing_status') && $request->processing_status !== '') {
            $query->where('processing_status', $request->processing_status);
        }

        // Search by event ID
        if ($request->has('search') && $request->search !== '') {
            $query->where('event_id', 'like', '%' . $request->search . '%');
        }

        $webhooks = $query->paginate(15);
        $providers = ['razorpay'];
        $eventTypes = WebhookEvent::distinct()->pluck('event_type')->toArray();
        $processingStatuses = ['pending', 'processed', 'failed'];

        // Stats
        $stats = [
            'total_webhooks' => WebhookEvent::count(),
            'processed_webhooks' => WebhookEvent::where('processing_status', 'processed')->count(),
            'failed_webhooks' => WebhookEvent::where('processing_status', 'failed')->count(),
            'pending_webhooks' => WebhookEvent::where('processing_status', 'pending')->count(),
        ];

        return view('order.webhooks.index', compact('webhooks', 'providers', 'eventTypes', 'processingStatuses', 'stats'));
    }

    /**
     * Display the specified webhook event
     */
    public function show(WebhookEvent $webhook)
    {
        return view('order.webhooks.show', compact('webhook'));
    }

    /**
     * Process webhook event manually
     */
    public function process(WebhookEvent $webhook)
    {
        if ($webhook->processing_status !== 'pending') {
            return back()->withErrors(['error' => 'Only pending webhooks can be processed.']);
        }

        try {
            DB::beginTransaction();

            $webhook->update([
                'processing_status' => 'pending',
                'processed_at' => null,
                'error_message' => null,
            ]);

            // Process the webhook based on event type
            $this->processWebhookEvent($webhook);

            $webhook->update([
                'processing_status' => 'processed',
                'processed_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('webhooks.show', $webhook)
                ->with('success', 'Webhook processed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            $webhook->update([
                'processing_status' => 'failed',
                'processed_at' => now(),
                'error_message' => $e->getMessage(),
            ]);

            Log::error('Webhook processing failed: ' . $e->getMessage(), [
                'webhook_id' => $webhook->id,
                'event_type' => $webhook->event_type,
                'event_id' => $webhook->event_id,
            ]);

            return back()->withErrors(['error' => 'Failed to process webhook: ' . $e->getMessage()]);
        }
    }

    /**
     * Retry failed webhook
     */
    public function retry(WebhookEvent $webhook)
    {
        if ($webhook->processing_status !== 'failed') {
            return back()->withErrors(['error' => 'Only failed webhooks can be retried.']);
        }

        return $this->process($webhook);
    }

    /**
     * Delete webhook event
     */
    public function destroy(WebhookEvent $webhook)
    {
        $webhook->delete();

        return redirect()->route('webhooks.index')
            ->with('success', 'Webhook event deleted successfully!');
    }

    /**
     * Handle incoming Razorpay webhook
     */
    public function handleRazorpayWebhook(Request $request)
    {
        try {
            // Verify webhook signature (you should implement this)
            // $this->verifyRazorpaySignature($request);

            $payload = $request->all();
            $eventType = $payload['event'] ?? 'unknown';
            $eventId = $payload['id'] ?? uniqid();

            // Store webhook event
            $webhook = WebhookEvent::create([
                'provider' => 'razorpay',
                'event_type' => $eventType,
                'event_id' => $eventId,
                'payload' => $payload,
                'processing_status' => 'pending',
                'received_at' => now(),
            ]);

            // Process webhook asynchronously or immediately
            $this->processWebhookEvent($webhook);

            $webhook->update([
                'processing_status' => 'processed',
                'processed_at' => now(),
            ]);

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Razorpay webhook processing failed: ' . $e->getMessage(), [
                'payload' => $request->all(),
            ]);

            if (isset($webhook)) {
                $webhook->update([
                    'processing_status' => 'failed',
                    'processed_at' => now(),
                    'error_message' => $e->getMessage(),
                ]);
            }

            return response()->json(['status' => 'error'], 500);
        }
    }

    /**
     * Process webhook event based on type
     */
    private function processWebhookEvent(WebhookEvent $webhook)
    {
        $payload = $webhook->payload;

        switch ($webhook->event_type) {
            case 'payment.captured':
                $this->handlePaymentCaptured($payload);
                break;
            case 'payment.failed':
                $this->handlePaymentFailed($payload);
                break;
            case 'refund.processed':
                $this->handleRefundProcessed($payload);
                break;
            case 'order.paid':
                $this->handleOrderPaid($payload);
                break;
            default:
                Log::info('Unhandled webhook event type: ' . $webhook->event_type);
        }
    }

    /**
     * Handle payment captured event
     */
    private function handlePaymentCaptured($payload)
    {
        $paymentId = $payload['payload']['payment']['entity']['id'] ?? null;
        
        if (!$paymentId) {
            throw new \Exception('Payment ID not found in webhook payload');
        }

        $payment = Payment::where('gateway_payment_id', $paymentId)->first();
        
        if (!$payment) {
            throw new \Exception('Payment not found: ' . $paymentId);
        }

        $payment->update([
            'status' => 'captured',
            'captured_at' => now(),
            'raw_payload' => $payload,
        ]);

        // Update order status
        $payment->order->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }

    /**
     * Handle payment failed event
     */
    private function handlePaymentFailed($payload)
    {
        $paymentId = $payload['payload']['payment']['entity']['id'] ?? null;
        
        if (!$paymentId) {
            throw new \Exception('Payment ID not found in webhook payload');
        }

        $payment = Payment::where('gateway_payment_id', $paymentId)->first();
        
        if (!$payment) {
            throw new \Exception('Payment not found: ' . $paymentId);
        }

        $paymentData = $payload['payload']['payment']['entity'];
        
        $payment->update([
            'status' => 'failed',
            'error_code' => $paymentData['error_code'] ?? null,
            'error_description' => $paymentData['error_description'] ?? null,
            'raw_payload' => $payload,
        ]);

        // Update order status
        $payment->order->update([
            'status' => 'failed',
            'failed_at' => now(),
        ]);
    }

    /**
     * Handle refund processed event
     */
    private function handleRefundProcessed($payload)
    {
        $refundId = $payload['payload']['refund']['entity']['id'] ?? null;
        
        if (!$refundId) {
            throw new \Exception('Refund ID not found in webhook payload');
        }

        // Find refund by gateway refund ID
        $refund = \App\Models\Refund::where('gateway_refund_id', $refundId)->first();
        
        if (!$refund) {
            throw new \Exception('Refund not found: ' . $refundId);
        }

        $refund->update([
            'status' => 'processed',
        ]);

        // Update payment and order status if needed
        $payment = $refund->payment;
        $totalRefunded = $payment->refunds()->where('status', 'processed')->sum('amount_cents');
        
        if ($totalRefunded >= $payment->amount_cents) {
            $payment->update([
                'status' => 'refunded',
                'refunded_at' => now(),
            ]);

            $payment->order->update([
                'status' => 'refunded',
                'refunded_at' => now(),
            ]);
        }
    }

    /**
     * Handle order paid event
     */
    private function handleOrderPaid($payload)
    {
        $orderId = $payload['payload']['order']['entity']['id'] ?? null;
        
        if (!$orderId) {
            throw new \Exception('Order ID not found in webhook payload');
        }

        $order = Order::where('gateway_order_id', $orderId)->first();
        
        if (!$order) {
            throw new \Exception('Order not found: ' . $orderId);
        }

        $order->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }

    /**
     * Verify Razorpay webhook signature
     */
    private function verifyRazorpaySignature(Request $request)
    {
        $signature = $request->header('X-Razorpay-Signature');
        $payload = $request->getContent();
        $webhookSecret = config('services.razorpay.webhook_secret');

        $expectedSignature = hash_hmac('sha256', $payload, $webhookSecret);

        if (!hash_equals($expectedSignature, $signature)) {
            throw new \Exception('Invalid webhook signature');
        }
    }
}
