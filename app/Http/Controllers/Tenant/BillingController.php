<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\BillingInvoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\View\View;

class BillingController extends Controller
{
    public function index(): View
    {
        $tenant = currentTenant();
        abort_if(! $tenant, 404);

        $invoices = $tenant->billingInvoices()->latest()->paginate(15);

        return view('admin.pages.settings.general-settings.billing-transactions', compact('tenant', 'invoices'));
    }

    public function download(BillingInvoice $invoice): Response
    {
        $tenant = currentTenant();
        abort_if(! $tenant || $invoice->tenant_id !== $tenant->id, 404);

        if ($invoice->pdf_path && file_exists(storage_path('app/'.$invoice->pdf_path))) {
            return response()->download(storage_path('app/'.$invoice->pdf_path));
        }

        $pdfPath = 'invoices/invoice-'.$invoice->id.'.pdf';

        if (! file_exists(storage_path('app/invoices'))) {
            mkdir(storage_path('app/invoices'), 0755, true);
        }

        Pdf::loadView('billing.invoice-pdf', ['invoice' => $invoice, 'tenant' => $tenant])
            ->save(storage_path('app/'.$pdfPath));

        $invoice->update(['pdf_path' => $pdfPath]);

        return response()->download(storage_path('app/'.$pdfPath));
    }
}
