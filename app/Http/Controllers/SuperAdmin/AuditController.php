<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditController extends Controller
{
    public function index(Request $request): View
    {
        $logs = AuditLog::query()
            ->with(['tenant'])
            ->when($request->filled('event'), fn ($q) => $q->where('event', $request->event))
            ->when($request->filled('tenant_id'), fn ($q) => $q->where('tenant_id', $request->tenant_id))
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('super-admin.audit-logs.index', compact('logs'));
    }
}
