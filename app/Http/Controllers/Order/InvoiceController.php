<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDF;

class InvoiceController extends Controller
{
    /**
     * Display a listing of invoices (admin)
     */
    public function index(Request $request)
    {
        $query = Invoice::with(['order.user'])
            ->latest();

        // Filter by order
        if ($request->has('order_id') && $request->order_id !== '') {
            $query->where('order_id', $request->order_id);
        }

        // Search by invoice number
        if ($request->has('search') && $request->search !== '') {
            $query->where('invoice_no', 'like', '%' . $request->search . '%');
        }

        $invoices = $query->paginate(15);
        $orders = Order::where('status', 'paid')->get();

        // Stats
        $stats = [
            'total_invoices' => Invoice::count(),
            'total_invoiced_amount' => Invoice::with('order')->get()->sum(function($invoice) {
                return $invoice->order->total_cents / 100;
            }),
            'invoices_this_month' => Invoice::whereMonth('issued_at', now()->month)->count(),
            'invoices_this_year' => Invoice::whereYear('issued_at', now()->year)->count(),
        ];

        return view('order.invoices.index', compact('invoices', 'orders', 'stats'));
    }

    /**
     * Show the form for creating a new invoice (Admin-initiated)
     */
    public function create(Request $request)
    {
        $orderId = $request->get('order_id');
        $orders = Order::where('status', 'paid')
            ->whereDoesntHave('invoice')
            ->with(['user', 'items.course'])
            ->get();

        $selectedOrder = $orderId ? Order::with(['user', 'items.course'])->find($orderId) : null;

        return view('order.invoices.create', compact('orders', 'selectedOrder'));
    }

    /**
     * Store a newly created invoice (Admin-initiated)
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id|unique:invoices,order_id',
            'billing_name' => 'required|string|max:255',
            'billing_address' => 'required|string',
            'billing_city' => 'required|string|max:100',
            'billing_state' => 'required|string|max:100',
            'billing_country' => 'required|string|max:100',
            'billing_zip' => 'required|string|max:20',
        ]);

        $order = Order::with(['user', 'items.course'])->findOrFail($request->order_id);

        // Check if order is paid
        if ($order->status !== 'paid') {
            return back()->withErrors(['error' => 'Only paid orders can have invoices.']);
        }

        // Check if invoice already exists
        if ($order->invoice) {
            return back()->withErrors(['error' => 'Invoice already exists for this order.']);
        }

        try {
            DB::beginTransaction();

            // Prepare address data
            $addressData = [
                'name' => $request->billing_name,
                'address' => $request->billing_address,
                'city' => $request->billing_city,
                'state' => $request->billing_state,
                'country' => $request->billing_country,
                'zip' => $request->billing_zip,
            ];

            // Prepare line items data
            $lineItems = [];
            foreach ($order->items as $item) {
                $lineItems[] = [
                    'course_title' => $item->course->title,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price_cents / 100,
                    'line_total' => $item->unit_price_cents / 100,
                ];
            }

            // Prepare totals data
            $totalsData = [
                'subtotal' => $order->amount_cents / 100,
                'discount' => $order->discount_cents / 100,
                'tax' => $order->tax_cents / 100,
                'total' => $order->total_cents / 100,
                'currency' => $order->currency,
            ];

            // Create invoice
            $invoice = Invoice::create([
                'order_id' => $request->order_id,
                'invoice_no' => Invoice::generateInvoiceNumber(),
                'issued_at' => now(),
                'billing_name' => $request->billing_name,
                'address_json' => $addressData,
                'line_items_json' => $lineItems,
                'totals_json' => $totalsData,
            ]);

            // Generate PDF
            $pdfPath = $this->generateInvoicePDF($invoice);

            // Update invoice with PDF path
            $invoice->update(['pdf_path' => $pdfPath]);

            DB::commit();

            return redirect()->route('invoices.show', $invoice)
                ->with('success', 'Invoice created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create invoice: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified invoice
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['order.user', 'order.items.course']);
        
        return view('order.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified invoice
     */
    public function edit(Invoice $invoice)
    {
        $orders = Order::where('status', 'paid')->get();
        
        return view('order.invoices.edit', compact('invoice', 'orders'));
    }

    /**
     * Update the specified invoice
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'billing_name' => 'required|string|max:255',
            'billing_address' => 'required|string',
            'billing_city' => 'required|string|max:100',
            'billing_state' => 'required|string|max:100',
            'billing_country' => 'required|string|max:100',
            'billing_zip' => 'required|string|max:20',
        ]);

        // Prepare address data
        $addressData = [
            'name' => $request->billing_name,
            'address' => $request->billing_address,
            'city' => $request->billing_city,
            'state' => $request->billing_state,
            'country' => $request->billing_country,
            'zip' => $request->billing_zip,
        ];

        $invoice->update([
            'billing_name' => $request->billing_name,
            'address_json' => $addressData,
        ]);

        // Regenerate PDF with updated data
        $pdfPath = $this->generateInvoicePDF($invoice);
        $invoice->update(['pdf_path' => $pdfPath]);

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice updated successfully!');
    }

    /**
     * Remove the specified invoice
     */
    public function destroy(Invoice $invoice)
    {
        // Delete PDF file if exists
        if ($invoice->pdf_path && Storage::disk('public')->exists($invoice->pdf_path)) {
            Storage::disk('public')->delete($invoice->pdf_path);
        }

        $invoice->delete();

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice deleted successfully!');
    }

    /**
     * Download invoice PDF
     */
    public function download(Invoice $invoice)
    {
        if (!$invoice->pdf_path || !Storage::disk('public')->exists($invoice->pdf_path)) {
            // Regenerate PDF if it doesn't exist
            $pdfPath = $this->generateInvoicePDF($invoice);
            $invoice->update(['pdf_path' => $pdfPath]);
        }

        return Storage::disk('public')->download($invoice->pdf_path, $invoice->invoice_no . '.pdf');
    }

    /**
     * Generate invoice PDF
     */
    private function generateInvoicePDF(Invoice $invoice)
    {
        $invoice->load(['order.user', 'order.items.course']);

        $pdf = PDF::loadView('order.invoices.pdf', compact('invoice'));
        
        $filename = 'invoices/' . $invoice->invoice_no . '.pdf';
        Storage::disk('public')->put($filename, $pdf->output());

        return $filename;
    }

    /**
     * Regenerate invoice PDF
     */
    public function regeneratePDF(Invoice $invoice)
    {
        try {
            $pdfPath = $this->generateInvoicePDF($invoice);
            $invoice->update(['pdf_path' => $pdfPath]);

            return redirect()->route('invoices.show', $invoice)
                ->with('success', 'Invoice PDF regenerated successfully!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to regenerate PDF: ' . $e->getMessage()]);
        }
    }
}
