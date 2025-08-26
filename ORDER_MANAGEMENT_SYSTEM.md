# Order Management System - Backend Documentation

## Overview

The Order Management System is a comprehensive backend solution for managing course purchases, payments, refunds, invoices, and webhook processing in the LMS admin panel. It integrates with Razorpay payment gateway and provides both web and API interfaces.

**Note**: This is an **Admin Panel** system. Users create orders and payments through the frontend/mobile app, and admins manage them through this admin panel.

## System Architecture

### Core Tables & Their Purpose

1. **Orders** → Tracks a user's purchase attempt
2. **Order Items** → Stores which courses were in that order
3. **Payments** → Stores payment gateway transactions
4. **Refunds** → Handles refunds against payments
5. **Invoices** → Stores billing documents for completed orders
6. **Webhook Events** → Stores incoming Razorpay events for auditing & syncing

## Models

### Order Model
- **Purpose**: Main order entity
- **Key Fields**: user_id, currency, amount_cents, status, gateway_order_id
- **Relationships**: User, OrderItems, Payments, Invoice
- **Statuses**: pending, paid, failed, cancelled, refunded

### OrderItem Model
- **Purpose**: Individual course items in an order
- **Key Fields**: order_id, course_id, unit_price_cents, quantity, line_total_cents
- **Relationships**: Order, Course

### Payment Model
- **Purpose**: Payment gateway transactions
- **Key Fields**: order_id, user_id, amount_cents, gateway_payment_id, status
- **Statuses**: created, authorized, captured, failed, refunded
- **Relationships**: Order, User, Refunds

### Refund Model
- **Purpose**: Refund transactions
- **Key Fields**: payment_id, amount_cents, reason, gateway_refund_id, status
- **Statuses**: pending, processed, failed
- **Relationships**: Payment

### Invoice Model
- **Purpose**: Billing documents
- **Key Fields**: order_id, invoice_no, billing_name, address_json, line_items_json
- **Relationships**: Order

### WebhookEvent Model
- **Purpose**: Payment gateway webhook events
- **Key Fields**: provider, event_type, event_id, payload, processing_status
- **Statuses**: pending, processed, failed
- **Relationships**: None (standalone)

## Controllers

### Web Controllers (Admin Panel)

#### OrderController
- **index()**: List all orders with filtering and stats
- **show()**: Display order details
- **edit()**: Show order edit form
- **update()**: Update order status
- **destroy()**: Delete pending orders
- **cancel()**: Cancel order (admin action)

#### PaymentController
- **index()**: List all payments with filtering
- **show()**: Display payment details
- **edit()**: Show payment edit form
- **update()**: Update payment status
- **destroy()**: Delete failed payments

#### RefundController
- **index()**: List all refunds with filtering
- **create()**: Show refund creation form (Admin-initiated)
- **store()**: Create new refund (Admin-initiated)
- **show()**: Display refund details
- **edit()**: Show refund edit form
- **update()**: Update refund status
- **destroy()**: Delete pending refunds
- **process()**: Process refund manually

#### InvoiceController
- **index()**: List all invoices with filtering
- **create()**: Show invoice creation form (Admin-initiated)
- **store()**: Create new invoice with PDF generation (Admin-initiated)
- **show()**: Display invoice details
- **edit()**: Show invoice edit form
- **update()**: Update invoice details
- **destroy()**: Delete invoice
- **download()**: Download invoice PDF
- **regeneratePDF()**: Regenerate invoice PDF

#### WebhookController
- **index()**: List all webhook events
- **show()**: Display webhook event details
- **process()**: Process webhook manually
- **retry()**: Retry failed webhook
- **destroy()**: Delete webhook event
- **handleRazorpayWebhook()**: Handle incoming Razorpay webhooks

### API Controllers

#### OrderApiController
- **myOrders()**: Get user's orders (paginated)
- **show()**: Get order details
- **store()**: Create new order
- **cancel()**: Cancel order
- **getPaymentLink()**: Get payment link for order
- **verifyPayment()**: Verify payment signature
- **statistics()**: Get order statistics
- **availableCourses()**: Get available courses for purchase

## Services

### PaymentGatewayService
- **createOrder()**: Create Razorpay order
- **createPaymentLink()**: Create payment link
- **verifyPaymentSignature()**: Verify payment signature
- **capturePayment()**: Capture payment
- **processRefund()**: Process refund
- **getPaymentDetails()**: Get payment details from Razorpay
- **getOrderDetails()**: Get order details from Razorpay
- **createPaymentFromRazorpay()**: Create payment record
- **syncPaymentStatus()**: Sync payment status

## Routes

### Web Routes (Admin Panel)
```php
// Orders Management (Admin Panel)
Route::resource('/orders', OrderController::class)->except(['create', 'store']);
Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel']);

// Payments Management (Admin Panel)
Route::resource('/payments', PaymentController::class)->except(['create', 'store']);

// Refunds Management
Route::resource('/refunds', RefundController::class);
Route::patch('/refunds/{refund}/process', [RefundController::class, 'process']);

// Invoices Management
Route::resource('/invoices', InvoiceController::class);
Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'download']);
Route::patch('/invoices/{invoice}/regenerate-pdf', [InvoiceController::class, 'regeneratePDF']);

// Webhooks Management
Route::resource('/webhooks', WebhookController::class)->only(['index', 'show', 'destroy']);
Route::patch('/webhooks/{webhook}/process', [WebhookController::class, 'process']);
Route::patch('/webhooks/{webhook}/retry', [WebhookController::class, 'retry']);

// Webhook endpoints (no auth required)
Route::post('/webhooks/razorpay', [WebhookController::class, 'handleRazorpayWebhook']);
```

### API Routes
```php
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('orders')->group(function () {
        Route::get('/my-orders', [OrderApiController::class, 'myOrders']);
        Route::get('/statistics', [OrderApiController::class, 'statistics']);
        Route::get('/available-courses', [OrderApiController::class, 'availableCourses']);
        Route::post('/', [OrderApiController::class, 'store']);
        Route::get('/{order}', [OrderApiController::class, 'show']);
        Route::patch('/{order}/cancel', [OrderApiController::class, 'cancel']);
        Route::get('/{order}/payment-link', [OrderApiController::class, 'getPaymentLink']);
        Route::post('/verify-payment', [OrderApiController::class, 'verifyPayment']);
    });
});
```

## Configuration

### Environment Variables
```env
# Razorpay Configuration
RAZORPAY_KEY_ID=your_razorpay_key_id
RAZORPAY_KEY_SECRET=your_razorpay_key_secret
RAZORPAY_WEBHOOK_SECRET=your_webhook_secret
```

### Services Configuration
```php
// config/services.php
'razorpay' => [
    'key_id' => env('RAZORPAY_KEY_ID'),
    'key_secret' => env('RAZORPAY_KEY_SECRET'),
    'webhook_secret' => env('RAZORPAY_WEBHOOK_SECRET'),
],
```

## Features

### Order Management
- ✅ View all orders with filtering and search
- ✅ Order status tracking and updates
- ✅ Order details with user info and items
- ✅ Order cancellation (admin action)
- ✅ Order history and analytics

### Payment Processing
- ✅ View all payments with filtering and search
- ✅ Payment status tracking and updates
- ✅ Payment details with gateway information
- ✅ Payment history and analytics
- ✅ Payment error tracking

### Refund Management
- ✅ Create refunds for captured payments (Admin-initiated)
- ✅ Partial and full refunds
- ✅ Refund status tracking and updates
- ✅ Manual refund processing
- ✅ Refund history and analytics

### Invoice Generation
- ✅ Create invoices for paid orders (Admin-initiated)
- ✅ PDF invoice generation
- ✅ Invoice customization and editing
- ✅ Invoice download and management
- ✅ Invoice history and analytics

### Webhook Processing
- ✅ Razorpay webhook handling
- ✅ Webhook event storage
- ✅ Manual webhook processing
- ✅ Failed webhook retry
- ✅ Webhook signature verification

### API Integration
- ✅ RESTful API endpoints
- ✅ Authentication with Sanctum
- ✅ Order creation via API
- ✅ Payment verification via API
- ✅ Order statistics via API

## Security Features

1. **Payment Signature Verification**: All payments are verified using Razorpay's signature verification
2. **Webhook Signature Verification**: Incoming webhooks are verified for authenticity
3. **User Authorization**: Users can only access their own orders and payments
4. **Status Validation**: Only appropriate status transitions are allowed
5. **Input Validation**: All inputs are validated using Laravel's validation system

## Error Handling

1. **Database Transactions**: All critical operations use database transactions
2. **Exception Logging**: All exceptions are logged with context
3. **Graceful Degradation**: System continues to work even if payment gateway is down
4. **User-Friendly Messages**: Clear error messages for users

## Monitoring & Logging

1. **Payment Gateway Logs**: All Razorpay interactions are logged
2. **Webhook Processing Logs**: Webhook processing status and errors are logged
3. **Order Status Changes**: All order status changes are tracked
4. **Payment Failures**: Payment failures are logged with details

## Testing Considerations

1. **Unit Tests**: Test individual model methods and service methods
2. **Integration Tests**: Test payment gateway integration
3. **Webhook Tests**: Test webhook processing
4. **API Tests**: Test API endpoints
5. **Database Tests**: Test database transactions and rollbacks

## Deployment Considerations

1. **Environment Variables**: Ensure all Razorpay credentials are set
2. **Webhook URLs**: Configure webhook URLs in Razorpay dashboard
3. **SSL Certificate**: Required for webhook processing
4. **Queue Workers**: Consider using queues for webhook processing
5. **Database Backups**: Regular backups of order data

## Future Enhancements

1. **Multiple Payment Gateways**: Support for other payment gateways
2. **Subscription Management**: Recurring payment support
3. **Advanced Analytics**: Detailed sales and revenue analytics
4. **Email Notifications**: Order status email notifications
5. **Mobile App Support**: Enhanced mobile app integration
6. **Multi-currency Support**: Better multi-currency handling
7. **Tax Calculation**: Automated tax calculation
8. **Discount Codes**: Coupon and discount code system

## Dependencies

- Laravel 10+
- Razorpay PHP SDK
- DomPDF (for invoice generation)
- Laravel Sanctum (for API authentication)

## Installation

1. Install Razorpay PHP SDK:
```bash
composer require razorpay/razorpay
```

2. Install DomPDF for invoice generation:
```bash
composer require barryvdh/laravel-dompdf
```

3. Run migrations:
```bash
php artisan migrate
```

4. Configure environment variables
5. Set up webhook URLs in Razorpay dashboard

## Usage Examples

### Creating an Order
```php
$order = Order::create([
    'user_id' => $user->id,
    'currency' => 'INR',
    'amount_cents' => 5000,
    'total_cents' => 5000,
    'status' => 'pending',
    'gateway' => 'razorpay',
]);
```

### Processing Payment
```php
$paymentGateway = new PaymentGatewayService();
$razorpayOrder = $paymentGateway->createOrder($order);
```

### Verifying Payment
```php
$isValid = $paymentGateway->verifyPaymentSignature(
    $paymentId,
    $orderId,
    $signature
);
```

### Creating Refund
```php
$refund = Refund::create([
    'payment_id' => $payment->id,
    'amount_cents' => 5000,
    'reason' => 'Customer request',
    'status' => 'pending',
]);
```

This comprehensive order management system provides a robust foundation for handling all aspects of course purchases and payments in your LMS admin panel.
