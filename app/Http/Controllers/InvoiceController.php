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
// app/Http/Controllers/InvoiceController.php

public function store(Request $request)
{
    $validated = $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'invoice_date' => 'required|date',
        'due_date' => 'required|date|after_or_equal:invoice_date',
        'reference_number' => 'nullable|string|max:255',
        'items' => 'required|array|min:1',
        'items.*.item_name' => 'required|string|max:255',
        'items.*.quantity' => 'required|numeric|min:0.01',
        'items.*.unit' => 'required|string|max:50',
        'items.*.rate' => 'required|numeric|min:0',
        'items.*.discount_percent' => 'nullable|numeric|min:0|max:100',
        'tax_type' => 'required|in:none,gst_5,gst_12,gst_18,gst_28,cgst_sgst,igst',
        'enable_tax' => 'nullable|boolean',
        'discount_amount' => 'nullable|numeric|min:0',
        'shipping_cost' => 'nullable|numeric|min:0',
        'notes' => 'nullable|string',
        'round_off' => 'nullable|boolean',
        'status' => 'required|in:draft,sent,paid,unpaid,cancelled,partially_paid,refunded',
        'amount_paid' => 'nullable|numeric|min:0', // For partial payment
    ]);

    DB::beginTransaction();
    try {
        $enableTax = $request->boolean('enable_tax');
        $roundOff = $request->boolean('round_off');
        $status = $validated['status']; // Already underscore format

        // Generate invoice number
        $invoiceNumber = 'INV-' . date('ymd') . '-' . str_pad(
            Invoice::whereDate('created_at', today())->count() + 1,
            5,
            '0',
            STR_PAD_LEFT
        );

        // Calculate subtotal
        $subtotal = 0;
        foreach ($validated['items'] as $item) {
            $itemTotal = $item['quantity'] * $item['rate'];
            $discount = ($item['discount_percent'] ?? 0) > 0 
                ? ($itemTotal * ($item['discount_percent'] / 100)) 
                : 0;
            $subtotal += ($itemTotal - $discount);
        }

        // Calculate tax (only if enabled)
        $totalTax = 0;
        $taxBreakdown = [];
        
        if ($enableTax && $validated['tax_type'] !== 'none') {
            $taxDetails = $this->calculateTax($subtotal, $validated['tax_type']);
            $totalTax = $taxDetails['total_tax'];
            $taxBreakdown = $taxDetails['breakdown'];
        }

       // Calculate final totals
$shipping = $validated['shipping_cost'] ?? 0;

// ✅ Handle both percentage and amount discount
$discount = 0;
if ($request->has('discount_type')) {
    if ($request->discount_type === 'percent') {
        $discountPercent = $request->input('discount_percent', 0);
        $discount = ($subtotal * $discountPercent) / 100;
    } else {
        $discount = $request->input('discount_amount', 0);
    }
} else {
    // Fallback to old discount_amount field
    $discount = $validated['discount_amount'] ?? 0;
}

$grandTotal = $subtotal + $totalTax + $shipping - $discount;

       // ✅ CREATE INVOICE RECORD FIRST
$invoice = Invoice::create([
    'invoice_number' => $invoiceNumber,
    'reference_number' => $validated['reference_number'] ?? null,
    'invoice_date' => $validated['invoice_date'],
    'due_date' => $validated['due_date'],
    'customer_id' => $validated['customer_id'],
    'created_by' => Auth::id() ?? 1,
    'subtotal' => $subtotal,
    'total_tax' => $totalTax,
    'discount_amount' => $discount,
    'shipping_cost' => $shipping,
    'grand_total' => $grandTotal,
    'tax_type' => $validated['tax_type'],
    'status' => $status,
    'notes' => $validated['notes'] ?? null,
    'round_off' => $roundOff,
    'enable_tax' => $enableTax,
]);
// ✅ CRITICAL FIX: SAVE INVOICE ITEMS (THIS WAS MISSING!)
foreach ($validated['items'] as $item) {
    $itemSubtotal = $item['quantity'] * $item['rate'];
    $discountAmount = ($item['discount_percent'] ?? 0) > 0
        ? ($itemSubtotal * ($item['discount_percent'] / 100))
        : 0;
    $itemAmount = $itemSubtotal - $discountAmount;

    InvoiceItem::create([
        'invoice_id' => $invoice->id,
        'item_name' => $item['item_name'],
        'item_type' => 'product',
        'quantity' => $item['quantity'],
        'unit' => $item['unit'] ?? 'Pcs',
        'rate' => $item['rate'],
        'discount_percent' => $item['discount_percent'] ?? 0,
        'discount_amount' => $discountAmount,
        'amount' => $itemAmount,
    ]);
}
// ✅ END OF CRITICAL FIX

// ✅ CRITICAL: CREATE LEDGER ENTRY FOR INVOICE BEFORE ANY PAYMENT
try {
    $invoice->createLedgerEntry(
        'invoice_created',
        $grandTotal,
        0,
        "Invoice {$invoiceNumber} created for ₹" . number_format($grandTotal, 2)
    );
} catch (\Exception $e) {
    DB::rollBack();
    Log::error('Invoice ledger creation failed', [
        'invoice_number' => $invoiceNumber,
        'grand_total' => $grandTotal,
        'error' => $e->getMessage()
    ]);
    return back()->withInput()->withErrors([
        'error' => 'Failed to create invoice ledger: ' . $e->getMessage()
    ]);
}

// Save tax breakdown
foreach ($taxBreakdown as $tax) {
    InvoiceTax::create([
        'invoice_id' => $invoice->id,
        'tax_name' => $tax['name'],
        'tax_type' => $tax['type'],
        'tax_rate' => $tax['rate'],
        'taxable_amount' => $subtotal,
        'tax_amount' => $tax['amount'],
    ]);
}

// ✅ ONLY NOW handle partial payment (after invoice ledger exists)
if ($status === 'partially_paid' && isset($validated['amount_paid'])) {
    $amountPaid = $validated['amount_paid'];
    
    if ($amountPaid > 0 && $amountPaid <= $grandTotal) {
        try {
            $invoice->recordPayment(
                $amountPaid,
                null,
                null,
                'Partial payment received on invoice creation: ₹' . number_format($amountPaid, 2)
            );
        } catch (\Exception $e) {
            // Don't rollback entire invoice - just log payment failure
            Log::warning('Partial payment failed but invoice created', [
                'invoice_id' => $invoice->id,
                'amount' => $amountPaid,
                'error' => $e->getMessage()
            ]);
        }
    }
}

// ✅ CRITICAL FIX: ADD DB::COMMIT() HERE!
DB::commit();

// ✅ Redirect to invoice details page after successful creation
return redirect()->route('admin.invoices.index', $invoice->id)
    ->with('success', 'Invoice created successfully! Invoice Number: ' . $invoice->invoice_number);

    } catch (\Exception $e) {
        // ✅ CRITICAL FIX: ADD CATCH BLOCK HERE!
        DB::rollBack();
        
        Log::error('Invoice creation failed', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ]);

        return back()->withInput()->withErrors([
            'error' => 'Failed to create invoice: ' . $e->getMessage()
        ]);
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

   
    // Show edit form// Show edit form
public function edit(Invoice $invoice)
{
    $customers = Customer::all();
    $products = \App\Models\Product::with('variants')->get();
    // dd($products);
    $invoice->load(['items', 'taxes']);

    // ✅ DEBUG: Check if products exist (remove after testing)
    // dd($products->count() . ' products loaded', $products->pluck('name'));

    return view('admin.pages.invoices.edit-invoice', compact('invoice', 'customers', 'products'));
}
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
        'items.*.quantity' => 'required|numeric|min:0.01',
        'items.*.unit' => 'required|string|max:50',
        'items.*.rate' => 'required|numeric|min:0',
        'items.*.discount_percent' => 'nullable|numeric|min:0|max:100',
        'tax_type' => 'required|in:none,gst_5,gst_12,gst_18,gst_28,cgst_sgst,igst',
        'shipping_cost' => 'nullable|numeric|min:0',
        'notes' => 'nullable|string',
        'round_off' => 'nullable|boolean',
        'status' => 'nullable|in:draft,sent,paid,unpaid,cancelled,partially_paid,refunded',
        'enable_tax' => 'nullable|boolean',
        'discount_type' => 'nullable|string|in:percent,amount',
        'discount_percent' => 'nullable|numeric|min:0|max:100',
        'discount_amount' => 'nullable|numeric|min:0',
    ]);

    DB::beginTransaction();
    try {
        // Parse boolean flags
        $enableTax = $request->boolean('enable_tax');
        $roundOff = $request->boolean('round_off');

        // Recalculate subtotal from items
        $subtotal = 0;
        foreach ($validated['items'] as $item) {
            $itemSubtotal = $item['quantity'] * $item['rate'];
            $discountPercent = $item['discount_percent'] ?? 0;
            $discountAmountItem = ($discountPercent > 0) ? ($itemSubtotal * $discountPercent / 100) : 0;
            $itemAmount = $itemSubtotal - $discountAmountItem;
            $subtotal += $itemAmount;
        }

        // Calculate tax only if enabled and not "none"
        $totalTax = 0;
        $taxBreakdown = [];
        if ($enableTax && $validated['tax_type'] !== 'none') {
            $taxDetails = $this->calculateTax($subtotal, $validated['tax_type']);
            $totalTax = $taxDetails['total_tax'];
            $taxBreakdown = $taxDetails['breakdown'];
        }

        // ✅ CORRECT DISCOUNT HANDLING
        $discount = 0;
        if ($request->filled('discount_type')) {
            if ($request->discount_type === 'percent') {
                $discountPercent = $request->input('discount_percent', 0);
                $discount = ($subtotal * $discountPercent) / 100;
            } elseif ($request->discount_type === 'amount') {
                $discount = $request->input('discount_amount', 0);
            }
        } else {
            // Legacy fallback (optional – remove after full migration)
            $discount = $validated['discount_amount'] ?? 0;
        }

        // Shipping
        $shippingCost = $validated['shipping_cost'] ?? 0;

        // Grand total before rounding
        $grandTotal = $subtotal + $totalTax + $shippingCost - $discount;

        // Round off if enabled
        $roundOffAmount = 0;
        if ($roundOff) {
            $roundedTotal = round($grandTotal);
            $roundOffAmount = $roundedTotal - $grandTotal;
            $grandTotal = $roundedTotal;
        }

        // Update invoice record
        $invoice->update([
            'reference_number' => $validated['reference_number'] ?? null,
            'invoice_date' => $validated['invoice_date'],
            'due_date' => $validated['due_date'] ?? null,
            'customer_id' => $validated['customer_id'],
            'status' => $validated['status'] ?? $invoice->status,
            'subtotal' => $subtotal,
            'total_tax' => $totalTax,
            'discount_amount' => $discount, // ✅ Correct field
            'shipping_cost' => $shippingCost,
            'grand_total' => $grandTotal,
            'tax_type' => $validated['tax_type'],
            'notes' => $validated['notes'] ?? null,
            'round_off' => $roundOff,
            'round_off_amount' => $roundOffAmount,
            'enable_tax' => $enableTax,
        ]);

        // Delete old related records
        $invoice->items()->delete();
        $invoice->taxes()->delete();

        // Re-save invoice items
        foreach ($validated['items'] as $index => $item) {
            $itemSubtotal = $item['quantity'] * $item['rate'];
            $discountPercent = $item['discount_percent'] ?? 0;
            $discountAmountItem = ($discountPercent > 0) ? ($itemSubtotal * $discountPercent / 100) : 0;
            $itemAmount = $itemSubtotal - $discountAmountItem;

            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_name' => $item['item_name'],
                'item_type' => 'product',
                'quantity' => $item['quantity'],
                'unit' => $item['unit'] ?? 'Pcs',
                'rate' => $item['rate'],
                'discount_percent' => $discountPercent,
                'discount_amount' => $discountAmountItem,
                'amount' => $itemAmount,
            ]);
        }

        // Save tax breakdown
        foreach ($taxBreakdown as $tax) {
            InvoiceTax::create([
                'invoice_id' => $invoice->id,
                'tax_name' => $tax['name'],
                'tax_type' => $tax['type'],
                'tax_rate' => $tax['rate'],
                'taxable_amount' => $subtotal,
                'tax_amount' => $tax['amount'],
            ]);
        }
Log::info('Invoice update totals', [
    'subtotal' => $subtotal,
    'total_tax' => $totalTax,
    'shipping' => $shippingCost,
    'discount' => $discount,
    'grand_total' => $grandTotal,
    'round_off' => $roundOff,
    'round_off_amount' => $roundOffAmount,
]);
        DB::commit();

        return redirect()->route('admin.invoices.index')
            ->with('success', 'Invoice updated successfully!');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Invoice update failed', [
            'invoice_id' => $invoice->id,
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        return back()->withInput()->withErrors(['error' => 'Failed to update invoice: ' . $e->getMessage()]);
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
    
    $amountInWords = $this->convertNumberToWords(round($invoice->grand_total));
    
    $pdf = PDF::loadView('admin.pages.invoices.invoice-pdf', compact('invoice', 'amountInWords'));
    $pdf->setPaper('a4', 'portrait');
    
    return $pdf->download($invoice->invoice_number . '.pdf');
}
public function filterLedger(Request $request, Invoice $invoice)
{
    $request->validate([
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ]);

    $ledgers = $invoice->ledgers()
        ->whereBetween('created_at', [
            $request->start_date . ' 00:00:00',
            $request->end_date . ' 23:59:59'
        ])
        ->orderBy('created_at', 'desc')
        ->get();

    return view('admin.pages.invoices.partials.ledger-table', compact('ledgers'));
}
private function convertNumberToWords($number)
{
    if ($number < 0) return 'Negative ' . $this->convertNumberToWords(abs($number));
    if ($number == 0) return 'Zero';
    
    $words = [
        0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four',
        5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen',
        14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen',
        18 => 'Eighteen', 19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty', 70 => 'Seventy',
        80 => 'Eighty', 90 => 'Ninety', 100 => 'Hundred'
    ];

    if ($number < 21) return $words[$number];
    if ($number < 100) return $words[floor($number / 10) * 10] . ($number % 10 ? ' ' . $words[$number % 10] : '');
    if ($number < 1000) return $words[floor($number / 100)] . ' Hundred' . ($number % 100 ? ' ' . $this->convertNumberToWords($number % 100) : '');
    if ($number < 100000) return $this->convertNumberToWords(floor($number / 1000)) . ' Thousand' . ($number % 1000 ? ' ' . $this->convertNumberToWords($number % 1000) : '');
    if ($number < 10000000) return $this->convertNumberToWords(floor($number / 100000)) . ' Lakh' . ($number % 100000 ? ' ' . $this->convertNumberToWords($number % 100000) : '');
    return $this->convertNumberToWords(floor($number / 10000000)) . ' Crore' . ($number % 10000000 ? ' ' . $this->convertNumberToWords($number % 10000000) : '');
}
}
