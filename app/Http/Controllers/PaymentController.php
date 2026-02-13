<?php

namespace App\Http\Controllers; // ✅ CORRECT NAMESPACE (no Admin subfolder)

use App\Models\Invoice;
use App\Models\Ledger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    // ✅ Show payment form
    public function create($invoiceId)
    {
        $invoice = Invoice::with('customer')->findOrFail($invoiceId);
        
        // Calculate outstanding amount
        $totalPaid = Ledger::where('invoice_id', $invoice->id)
            ->where('transaction_type', 'payment_received')
            ->sum('credit');
        
        $outstanding = $invoice->grand_total - $totalPaid;
        
        return view('admin.pages.invoices.add-payment', compact('invoice', 'outstanding'));
    }
    
    // ✅ Record payment
   // app/Http/Controllers/PaymentController.php

public function store(Request $request, $invoiceId)
{
    $invoice = Invoice::findOrFail($invoiceId);
    
    $validated = $request->validate([
        'amount' => 'required|integer|min:1', // ✅ Changed to integer (no decimals)
        'payment_mode' => 'required|in:cash,bank_transfer,upi,card,cheque',
        'transaction_id' => 'nullable|string|max:100',
        'notes' => 'nullable|string',
    ]);
    
    // Validate amount
    $outstanding = $invoice->outstanding_amount;
    if ($validated['amount'] > $outstanding) {
        return back()->withErrors([
            'amount' => "Payment amount cannot exceed outstanding balance of ₹" . number_format($outstanding, 0) // ✅ No decimals
        ]);
    }
    
    DB::beginTransaction();
    try {
        $invoice->recordPayment(
            $validated['amount'],
            $validated['payment_mode'],
            $validated['transaction_id'] ?? null,
            $validated['notes'] ?? null
        );
        
        DB::commit();
        
        return redirect()->route('admin.invoices.show', $invoice->id)
            ->with('success', 'Payment recorded successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Payment recording failed: ' . $e->getMessage());
        
        return back()->withInput()->withErrors(['error' => $e->getMessage()]);
    }
}
    
    // ✅ Get ledger for invoice (AJAX)
    public function getLedger($invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);
        $ledger = Ledger::forInvoice($invoiceId)->get();
        
        return response()->json([
            'success' => true,
            'ledger' => $ledger,
            'invoice' => [
                'id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'grand_total' => $invoice->grand_total,
                'total_paid' => $invoice->total_paid,
                'outstanding_amount' => $invoice->outstanding_amount,
            ],
        ]);
    }
}