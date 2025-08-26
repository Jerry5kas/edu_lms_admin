<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;

class PaymentGatewayService
{
    protected $api;
    protected $keyId;
    protected $keySecret;

    public function __construct()
    {
        $this->keyId = config('services.razorpay.key_id');
        $this->keySecret = config('services.razorpay.key_secret');
        
        if ($this->keyId && $this->keySecret) {
            $this->api = new Api($this->keyId, $this->keySecret);
        }
    }

    /**
     * Create a new order in Razorpay
     */
    public function createOrder(Order $order)
    {
        try {
            if (!$this->api) {
                throw new \Exception('Razorpay API not configured');
            }

            $razorpayOrder = $this->api->order->create([
                'amount' => $order->total_cents,
                'currency' => $order->currency,
                'receipt' => 'order_' . $order->id,
                'notes' => [
                    'order_id' => $order->id,
                    'user_id' => $order->user_id,
                ],
            ]);

            // Update order with Razorpay order ID
            $order->update([
                'gateway_order_id' => $razorpayOrder->id,
            ]);

            return $razorpayOrder;

        } catch (\Exception $e) {
            Log::error('Failed to create Razorpay order: ' . $e->getMessage(), [
                'order_id' => $order->id,
            ]);
            throw $e;
        }
    }

    /**
     * Create a payment link for an order
     */
    public function createPaymentLink(Order $order)
    {
        try {
            if (!$this->api) {
                throw new \Exception('Razorpay API not configured');
            }

            $paymentLink = $this->api->paymentLink->create([
                'amount' => $order->total_cents,
                'currency' => $order->currency,
                'accept_partial' => false,
                'reference_id' => 'order_' . $order->id,
                'description' => 'Payment for Order #' . $order->id,
                'callback_url' => route('webhooks.razorpay'),
                'callback_method' => 'get',
                'notes' => [
                    'order_id' => $order->id,
                    'user_id' => $order->user_id,
                ],
            ]);

            return $paymentLink;

        } catch (\Exception $e) {
            Log::error('Failed to create payment link: ' . $e->getMessage(), [
                'order_id' => $order->id,
            ]);
            throw $e;
        }
    }

    /**
     * Verify payment signature
     */
    public function verifyPaymentSignature($paymentId, $orderId, $signature)
    {
        try {
            if (!$this->api) {
                throw new \Exception('Razorpay API not configured');
            }

            $attributes = [
                'razorpay_payment_id' => $paymentId,
                'razorpay_order_id' => $orderId,
                'razorpay_signature' => $signature,
            ];

            $this->api->utility->verifyPaymentSignature($attributes);
            return true;

        } catch (\Exception $e) {
            Log::error('Payment signature verification failed: ' . $e->getMessage(), [
                'payment_id' => $paymentId,
                'order_id' => $orderId,
            ]);
            return false;
        }
    }

    /**
     * Capture payment
     */
    public function capturePayment(Payment $payment, $amount = null)
    {
        try {
            if (!$this->api) {
                throw new \Exception('Razorpay API not configured');
            }

            $captureAmount = $amount ?: $payment->amount_cents;

            $capturedPayment = $this->api->payment->fetch($payment->gateway_payment_id)->capture([
                'amount' => $captureAmount,
                'currency' => $payment->currency,
            ]);

            // Update payment status
            $payment->update([
                'status' => 'captured',
                'captured_at' => now(),
                'raw_payload' => $capturedPayment->toArray(),
            ]);

            // Update order status
            $payment->order->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            return $capturedPayment;

        } catch (\Exception $e) {
            Log::error('Failed to capture payment: ' . $e->getMessage(), [
                'payment_id' => $payment->id,
                'gateway_payment_id' => $payment->gateway_payment_id,
            ]);
            throw $e;
        }
    }

    /**
     * Process refund
     */
    public function processRefund(Payment $payment, $amount, $reason = null)
    {
        try {
            if (!$this->api) {
                throw new \Exception('Razorpay API not configured');
            }

            $refundData = [
                'amount' => $amount,
            ];

            if ($reason) {
                $refundData['notes'] = ['reason' => $reason];
            }

            $refund = $this->api->payment->fetch($payment->gateway_payment_id)->refund($refundData);

            return $refund;

        } catch (\Exception $e) {
            Log::error('Failed to process refund: ' . $e->getMessage(), [
                'payment_id' => $payment->id,
                'amount' => $amount,
            ]);
            throw $e;
        }
    }

    /**
     * Get payment details from Razorpay
     */
    public function getPaymentDetails($paymentId)
    {
        try {
            if (!$this->api) {
                throw new \Exception('Razorpay API not configured');
            }

            return $this->api->payment->fetch($paymentId);

        } catch (\Exception $e) {
            Log::error('Failed to get payment details: ' . $e->getMessage(), [
                'payment_id' => $paymentId,
            ]);
            throw $e;
        }
    }

    /**
     * Get order details from Razorpay
     */
    public function getOrderDetails($orderId)
    {
        try {
            if (!$this->api) {
                throw new \Exception('Razorpay API not configured');
            }

            return $this->api->order->fetch($orderId);

        } catch (\Exception $e) {
            Log::error('Failed to get order details: ' . $e->getMessage(), [
                'order_id' => $orderId,
            ]);
            throw $e;
        }
    }

    /**
     * Create a payment record from Razorpay payment
     */
    public function createPaymentFromRazorpay($razorpayPayment, Order $order)
    {
        try {
            $payment = Payment::create([
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'amount_cents' => $razorpayPayment->amount,
                'currency' => $razorpayPayment->currency,
                'gateway' => 'razorpay',
                'gateway_payment_id' => $razorpayPayment->id,
                'gateway_signature' => request('razorpay_signature'),
                'method' => $razorpayPayment->method,
                'status' => $razorpayPayment->status,
                'raw_payload' => $razorpayPayment->toArray(),
            ]);

            return $payment;

        } catch (\Exception $e) {
            Log::error('Failed to create payment record: ' . $e->getMessage(), [
                'razorpay_payment_id' => $razorpayPayment->id,
                'order_id' => $order->id,
            ]);
            throw $e;
        }
    }

    /**
     * Sync payment status from Razorpay
     */
    public function syncPaymentStatus(Payment $payment)
    {
        try {
            $razorpayPayment = $this->getPaymentDetails($payment->gateway_payment_id);
            
            $payment->update([
                'status' => $razorpayPayment->status,
                'raw_payload' => $razorpayPayment->toArray(),
            ]);

            // Update order status if payment is captured
            if ($razorpayPayment->status === 'captured') {
                $payment->order->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                ]);
            }

            return $razorpayPayment;

        } catch (\Exception $e) {
            Log::error('Failed to sync payment status: ' . $e->getMessage(), [
                'payment_id' => $payment->id,
            ]);
            throw $e;
        }
    }
}
