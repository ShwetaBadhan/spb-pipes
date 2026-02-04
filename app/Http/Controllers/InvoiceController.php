<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceTax;
use Barryvdh\DomPDF\Facade\Pdf; // ✅ Import PDF facade
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class InvoiceController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    // Show all invoices
    // Show all invoices
    // Show all invoices
    public function index(Request $request)
    {
        // ✅ Fetch dashboard statistics
        $totalInvoices = Invoice::count();
        $totalAmount = Invoice::sum('grand_total');

        $paidInvoices = Invoice::where('status', 'paid')->count();
        $paidAmount = Invoice::where('status', 'paid')->sum('grand_total');

        $pendingInvoices = Invoice::whereIn('status', ['unpaid', 'draft'])->count();
        $pendingAmount = Invoice::whereIn('status', ['unpaid', 'draft'])->sum('grand_total');

        // Overdue invoices (due_date passed and status is unpaid)
        $overdueInvoices = Invoice::where('status', 'unpaid')
            ->where('due_date', '<', now())
            ->count();
        $overdueAmount = Invoice::where('status', 'unpaid')
            ->where('due_date', '<', now())
            ->sum('grand_total');

        // ✅ Fetch invoices for each tab
        $allInvoices = Invoice::with(['customer', 'createdBy'])->latest()->paginate(15, ['*'], 'all_page');

        $paid = Invoice::with(['customer', 'createdBy'])
            ->where('status', 'paid')
            ->latest()
            ->paginate(15, ['*'], 'paid_page');

        $overdue = Invoice::with(['customer', 'createdBy'])
            ->where('status', 'unpaid')
            ->where('due_date', '<', now())
            ->latest()
            ->paginate(15, ['*'], 'overdue_page');

        $upcoming = Invoice::with(['customer', 'createdBy'])
            ->where('status', 'unpaid')
            ->where('due_date', '>=', now())
            ->latest()
            ->paginate(15, ['*'], 'upcoming_page');

        $cancelled = Invoice::with(['customer', 'createdBy'])
            ->where('status', 'cancelled')
            ->latest()
            ->paginate(15, ['*'], 'cancelled_page');

        $partiallyPaid = Invoice::with(['customer', 'createdBy'])
            ->where('status', 'partially_paid')
            ->latest()
            ->paginate(15, ['*'], 'partially_paid_page');

        $unpaid = Invoice::with(['customer', 'createdBy'])
            ->where('status', 'unpaid')
            ->latest()
            ->paginate(15, ['*'], 'unpaid_page');

        $refunded = Invoice::with(['customer', 'createdBy'])
            ->where('status', 'refunded')
            ->latest()
            ->paginate(15, ['*'], 'refunded_page');

        $draft = Invoice::with(['customer', 'createdBy'])
            ->where('status', 'draft')
            ->latest()
            ->paginate(15, ['*'], 'draft_page');

        $customers = Customer::all();

        // ✅ Pass all data to view
        return view('admin.pages.invoices.invoices-view', compact(
            'allInvoices',
            'paid',
            'overdue',
            'upcoming',
            'cancelled',
            'partiallyPaid',
            'unpaid',
            'refunded',
            'draft',
            'customers',
            'totalInvoices',
            'totalAmount',
            'paidInvoices',
            'paidAmount',
            'pendingInvoices',
            'pendingAmount',
            'overdueInvoices',
            'overdueAmount'
        ));
    }

    // Show create invoice form
    public function create()
    {
        $customers = Customer::all();
        $products = \App\Models\Product::with('variants')->get();

        return view('admin.pages.invoices.add-invoice', compact('customers', 'products'));
    }

    // Store new invoice
    public function store(Request $request)
    {
        

        try {
            $validated = $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'invoice_date' => 'required|date',
                'due_date' => 'required|date',
                'reference_number' => 'nullable|string|max:255',
                'items' => 'required|array|min:1',
                'items.*.item_name' => 'required|string|max:255',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.unit' => 'required|string',
                'items.*.rate' => 'required|numeric|min:0',
                'items.*.discount_percent' => 'nullable|numeric|min:0|max:100',
                'tax_type' => 'required|in:none,gst_5,gst_12,gst_18,gst_28,cgst_sgst,igst',
                'discount_amount' => 'nullable|numeric|min:0',
                'shipping_cost' => 'nullable|numeric|min:0',
                'notes' => 'nullable|string',
                'round_off' => 'nullable|boolean',
                'status' => 'nullable|string|in:draft,sent,paid,unpaid',
                'enable_tax' => 'nullable|boolean',
            ]);

            // ✅ Set boolean values
            $validated['round_off'] = $request->has('round_off') && $request->round_off == '1';
            $validated['enable_tax'] = $request->has('enable_tax') && $request->enable_tax == '1';

            // \Log::info('Validation passed successfully!');

            DB::beginTransaction();
            try {
                $invoiceDate = $validated['invoice_date'];
                $dueDate = $validated['due_date'];

                // // \Log::info(/'Parsed dates:', [
                //     'invoice_date' => $invoiceDate,
                //     'due_date' => $dueDate
                // ]);

                // Generate invoice number
                $invoiceNumber = 'INV-' . date('ymd') . '-' . str_pad(Invoice::count() + 1, 5, '0', STR_PAD_LEFT);

                // \Log::info('Generated invoice number:', ['number' => $invoiceNumber]);

                // Calculate subtotal from items
                $subtotal = 0;
                foreach ($validated['items'] as $item) {
                    $itemSubtotal = $item['quantity'] * $item['rate'];
                    $discountAmount = ($item['discount_percent'] ?? 0) > 0
                        ? ($itemSubtotal * ($item['discount_percent'] / 100))
                        : 0;
                    $itemAmount = $itemSubtotal - $discountAmount;
                    $subtotal += $itemAmount;
                }

                // \Log::info('Calculated subtotal:', ['subtotal' => $subtotal]);

                // Calculate tax
                $taxDetails = $this->calculateTax($subtotal, $validated['tax_type']);
                $totalTax = $taxDetails['total_tax'];

                // \Lo/g::info('Tax details:', ['total_tax' => $totalTax]);

                // Calculate discount & shipping
                $discountAmount = $validated['discount_amount'] ?? 0;
                $shippingCost = $validated['shipping_cost'] ?? 0;

                // Calculate grand total
                $grandTotal = $subtotal + $totalTax - $discountAmount + $shippingCost;
                $roundOff = $validated['round_off'];
                $roundOffAmount = 0;

                if ($roundOff) {
                    $roundedTotal = round($grandTotal);
                    $roundOffAmount = $roundedTotal - $grandTotal;
                    $grandTotal = $roundedTotal;
                }

                // \Log::info(/'Final calculations:', [
                //     'grand_total' => $grandTotal,
                //     'round_off' => $roundOffAmount
                // ]);

                // Create invoice
                // \Log::info(/'Creating invoice record...');

                $invoice = Invoice::create([
                    'invoice_number' => $invoiceNumber,
                    'reference_number' => $validated['reference_number'] ?? null,
                    'invoice_date' => $invoiceDate,
                    'due_date' => $dueDate,
                    'customer_id' => $validated['customer_id'],
                    'created_by' => Auth::id(),
                    'subtotal' => $subtotal,
                    'total_tax' => $totalTax,
                    'discount_amount' => $discountAmount,
                    'shipping_cost' => $shippingCost,
                    'grand_total' => $grandTotal,
                    'tax_type' => $validated['tax_type'],
                    'status' => $validated['status'] ?? 'draft',
                    'notes' => $validated['notes'] ?? null,
                    'round_off' => $roundOff,
                    'round_off_amount' => $roundOffAmount,
                ]);

                // \Log::info('Invoice created successfully!', [
                //     'id' => $invoice->id,
                //     'number' => $invoice->invoice_number
                // ]);

                // Save invoice items
                // \Log::info('Saving invoice items...');

                foreach ($validated['items'] as $item) {
                    $itemSubtotal = $item['quantity'] * $item['rate'];
                    $discountAmountItem = ($item['discount_percent'] ?? 0) > 0
                        ? ($itemSubtotal * ($item['discount_percent'] / 100))
                        : 0;
                    $itemAmount = $itemSubtotal - $discountAmountItem;

                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'item_name' => $item['item_name'],
                        'item_type' => 'product',
                        'quantity' => $item['quantity'],
                        'unit' => $item['unit'],
                        'rate' => $item['rate'],
                        'discount_percent' => $item['discount_percent'] ?? 0,
                        'discount_amount' => $discountAmountItem,
                        'amount' => $itemAmount,
                    ]);
                }

                // \Log::info('Invoice items saved!');

                // Save tax breakdown
                // \Log::info('Saving tax breakdown...');

                if (!empty($taxDetails['breakdown'])) {
                    foreach ($taxDetails['breakdown'] as $tax) {
                        InvoiceTax::create([
                            'invoice_id' => $invoice->id,
                            'tax_name' => $tax['name'],
                            'tax_type' => $tax['type'],
                            'tax_rate' => $tax['rate'],
                            'taxable_amount' => $subtotal,
                            'tax_amount' => $tax['amount'],
                        ]);
                    }
                }

                // \Log::info('Tax breakdown saved!');

                DB::commit();

                // \Log::info('=== INVOICE CREATION SUCCESSFUL ===', ['invoice_id' => $invoice->id]);

                // ✅ Redirect to index page with success message (safer option)
                return redirect()->route('admin.invoices.index')
                    ->with('success', 'Invoice created successfully! Invoice Number: ' . $invoice->invoice_number);
            } catch (\Illuminate\Database\QueryException $e) {
                DB::rollBack();
                // \Log::error('Database error:', [
                //     'message' => $e->getMessage(),
                //     'sql' => $e->getSql() ?? 'N/A',
                //     'bindings' => $e->getBindings() ?? [],
                // ]);
                return back()->withInput()->with('error', 'Database error: ' . $e->getMessage());
            } catch (\Exception $e) {
                DB::rollBack();
                // \Log::error('Invoice creation failed:', [
                //     'message' => $e->getMessage(),
                //     'file' => $e->getFile(),
                //     'line' => $e->getLine(),
                //     'trace' => $e->getTraceAsString()
                // ]);
                return back()->withInput()->with('error', 'Failed to create invoice: ' . $e->getMessage());
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // \Log::error('Validation failed!', $e->errors());
            return redirect()->route('admin.invoices.index')
                ->with('success', 'Invoice created successfully! ');
        }
    }
    // ✅ Helper method to parse dates safely
    private function parseDate($dateString)
    {
        if (!$dateString) return null;

        // Try common formats
        $formats = ['Y-m-d', 'd/m/Y', 'm/d/Y', 'Y/m/d', 'd-m-Y', 'm-d-Y'];

        foreach ($formats as $format) {
            try {
                $date = \DateTime::createFromFormat($format, $dateString);
                if ($date !== false) {
                    return $date->format('Y-m-d');
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        // Fallback to Carbon parse
        try {
            return \Carbon\Carbon::parse($dateString)->format('Y-m-d');
        } catch (\Exception $e) {
            throw new \Exception("Unable to parse date: {$dateString}");
        }
    }

    // Show invoice details
    // Show invoice details
public function show(Invoice $invoice)
{
    $invoice->load(['customer', 'createdBy', 'items', 'taxes']);
    
    return view('admin.pages.invoices.invoice-details', compact('invoice'));
}

    // Show edit form
    public function edit(Invoice $invoice)
    {
        $customers = Customer::all();
        $products = \App\Models\Product::all();

        $invoice->load(['items', 'taxes']);

        return view('admin.pages.invoices.edit-invoice', compact('invoice', 'customers', 'products'));
    }

    // Update invoice
// Update invoice
public function update(Request $request, Invoice $invoice)
{
    $validated = $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'invoice_date' => 'required|date',
        'due_date' => 'nullable|date|after_or_equal:invoice_date',
        'reference_number' => 'nullable|string|max:255',
        'items' => 'required|array|min:1',
        'items.*.item_name' => 'required|string|max:255',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.unit' => 'required|string',
        'items.*.rate' => 'required|numeric|min:0',
        'items.*.discount_percent' => 'nullable|numeric|min:0|max:100',
        'tax_type' => 'required|in:none,gst_5,gst_12,gst_18,gst_28,cgst_sgst,igst',
        'discount_amount' => 'nullable|numeric|min:0',
        'shipping_cost' => 'nullable|numeric|min:0',
        'notes' => 'nullable|string',
        'round_off' => 'nullable|boolean',
        'status' => 'nullable|string|in:draft,sent,paid,unpaid,cancelled,partially_paid,refunded',
        'enable_tax' => 'nullable|boolean',
    ]);

    DB::beginTransaction();
    try {
        // ✅ Set boolean values
        $validated['round_off'] = $request->has('round_off') && $request->round_off == '1';
        $validated['enable_tax'] = $request->has('enable_tax') && $request->enable_tax == '1';
        
        // Calculate subtotal from items
        $subtotal = 0;
        foreach ($validated['items'] as $item) {
            $itemSubtotal = $item['quantity'] * $item['rate'];
            $discountAmount = ($item['discount_percent'] ?? 0) > 0
                ? ($itemSubtotal * ($item['discount_percent'] / 100))
                : 0;
            $itemAmount = $itemSubtotal - $discountAmount;
            $subtotal += $itemAmount;
        }

        // Calculate tax
        $taxDetails = $this->calculateTax($subtotal, $validated['tax_type']);
        $totalTax = $taxDetails['total_tax'];

        // Calculate discount
        $discountAmount = $validated['discount_amount'] ?? 0;

        // Calculate shipping
        $shippingCost = $validated['shipping_cost'] ?? 0;

        // Calculate grand total
        $grandTotal = $subtotal + $totalTax - $discountAmount + $shippingCost;

        // Round off if needed
        $roundOff = $validated['round_off'];
        $roundOffAmount = 0;

        if ($roundOff) {
            $roundedTotal = round($grandTotal);
            $roundOffAmount = $roundedTotal - $grandTotal;
            $grandTotal = $roundedTotal;
        }

        // Update invoice
        $invoice->update([
            'reference_number' => $validated['reference_number'] ?? null,
            'invoice_date' => $validated['invoice_date'],
            'due_date' => $validated['due_date'] ?? null,
            'customer_id' => $validated['customer_id'],
            'status' => $validated['status'] ?? $invoice->status,
            'subtotal' => $subtotal,
            'total_tax' => $totalTax,
            'discount_amount' => $discountAmount,
            'shipping_cost' => $shippingCost,
            'grand_total' => $grandTotal,
            'tax_type' => $validated['tax_type'],
            'notes' => $validated['notes'] ?? null,
            'round_off' => $roundOff,
            'round_off_amount' => $roundOffAmount,
        ]);

        // Delete old items and taxes
        $invoice->items()->delete();
        $invoice->taxes()->delete();

        // Save new invoice items
        foreach ($validated['items'] as $item) {
            $itemSubtotal = $item['quantity'] * $item['rate'];
            $discountAmountItem = ($item['discount_percent'] ?? 0) > 0
                ? ($itemSubtotal * ($item['discount_percent'] / 100))
                : 0;
            $itemAmount = $itemSubtotal - $discountAmountItem;

            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_name' => $item['item_name'],
                'item_type' => 'product',
                'quantity' => $item['quantity'],
                'unit' => $item['unit'] ?? 'Pcs',
                'rate' => $item['rate'],
                'discount_percent' => $item['discount_percent'] ?? 0,
                'discount_amount' => $discountAmountItem,
                'amount' => $itemAmount,
            ]);
        }

        // Save tax breakdown
        if (!empty($taxDetails['breakdown'])) {
            foreach ($taxDetails['breakdown'] as $tax) {
                InvoiceTax::create([
                    'invoice_id' => $invoice->id,
                    'tax_name' => $tax['name'],
                    'tax_type' => $tax['type'],
                    'tax_rate' => $tax['rate'],
                    'taxable_amount' => $subtotal,
                    'tax_amount' => $tax['amount'],
                ]);
            }
        }

        DB::commit();

        // ✅ Redirect to index page after update
        return redirect()->route('admin.invoices.index')
            ->with('success', 'Invoice updated successfully!');
            
    } catch (\Exception $e) {
        DB::rollBack();
        // \Log::error('Invoice update failed:', [
        //     'message' => $e->getMessage(),
        //     'file' => $e->getFile(),
        //     'line' => $e->getLine(),
        // ]);
        return back()->withInput()->with('error', 'Failed to update invoice: ' . $e->getMessage());
    }
}
    // Delete invoice
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('admin.invoices.index')->with('success', 'Invoice deleted successfully!');
    }

    // Update invoice status
    public function updateStatus(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'status' => 'required|in:draft,sent,paid,unpaid,cancelled,partially_paid',
        ]);

        $invoice->update(['status' => $validated['status']]);

        return back()->with('success', 'Invoice status updated successfully!');
    }

    // Helper method to calculate tax
    private function calculateTax($subtotal, $taxType)
    {
        $breakdown = [];
        $totalTax = 0;

        switch ($taxType) {
            case 'gst_5':
                $taxAmount = ($subtotal * 5) / 100;
                $breakdown[] = [
                    'name' => 'GST 5%',
                    'type' => 'gst',
                    'rate' => 5,
                    'amount' => $taxAmount
                ];
                $totalTax = $taxAmount;
                break;

            case 'gst_12':
                $taxAmount = ($subtotal * 12) / 100;
                $breakdown[] = [
                    'name' => 'GST 12%',
                    'type' => 'gst',
                    'rate' => 12,
                    'amount' => $taxAmount
                ];
                $totalTax = $taxAmount;
                break;

            case 'gst_18':
                $taxAmount = ($subtotal * 18) / 100;
                $breakdown[] = [
                    'name' => 'GST 18%',
                    'type' => 'gst',
                    'rate' => 18,
                    'amount' => $taxAmount
                ];
                $totalTax = $taxAmount;
                break;

            case 'gst_28':
                $taxAmount = ($subtotal * 28) / 100;
                $breakdown[] = [
                    'name' => 'GST 28%',
                    'type' => 'gst',
                    'rate' => 28,
                    'amount' => $taxAmount
                ];
                $totalTax = $taxAmount;
                break;

            case 'cgst_sgst':
                $cgst = ($subtotal * 9) / 100;
                $sgst = ($subtotal * 9) / 100;
                $breakdown[] = [
                    'name' => 'CGST 9%',
                    'type' => 'cgst',
                    'rate' => 9,
                    'amount' => $cgst
                ];
                $breakdown[] = [
                    'name' => 'SGST 9%',
                    'type' => 'sgst',
                    'rate' => 9,
                    'amount' => $sgst
                ];
                $totalTax = $cgst + $sgst;
                break;

            case 'igst':
                $taxAmount = ($subtotal * 18) / 100;
                $breakdown[] = [
                    'name' => 'IGST 18%',
                    'type' => 'igst',
                    'rate' => 18,
                    'amount' => $taxAmount
                ];
                $totalTax = $taxAmount;
                break;

            case 'none':
            default:
                $totalTax = 0;
                $breakdown = [];
                break;
        }

        return [
            'total_tax' => $totalTax,
            'breakdown' => $breakdown
        ];
    }
public function pdf(Invoice $invoice)
{
    $invoice->load(['customer', 'createdBy', 'items', 'taxes']);
    
    $pdf = PDF::loadView('admin.pages.invoices.invoice-pdf', compact('invoice'));
    $pdf->setPaper('a4', 'portrait');
    
    return $pdf->download($invoice->invoice_number . '.pdf');
}
}
