<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function index(Request $request)
    {
        $query = BankAccount::query();

        // Server-side search (pure PHP)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('account_holder_name', 'like', "%{$search}%")
                  ->orWhere('bank_name', 'like', "%{$search}%")
                  ->orWhere('branch_name', 'like', "%{$search}%")
                  ->orWhere('account_number', 'like', "%{$search}%")
                  ->orWhere('aba_number', 'like', "%{$search}%");
            });
        }

        $bankAccounts = $query->latest()->paginate(10)->withQueryString();

        return view('admin.pages.settings.finance-settings.bank-accounts-settings', compact('bankAccounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_holder_name' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'branch_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'aba_number' => 'nullable|string|max:20',
        ]);

        BankAccount::create($validated);

        return redirect()->back()->with('success', 'Bank account added successfully!');
    }

    public function update(Request $request, $id)
    {
        $bankAccount = BankAccount::findOrFail($id);

        $validated = $request->validate([
            'account_holder_name' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'branch_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'aba_number' => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $bankAccount->update($validated);

        return redirect()->back()->with('success', 'Bank account updated successfully!');
    }

    public function destroy($id)
    {
        $bankAccount = BankAccount::findOrFail($id);
        $bankAccount->delete();

        return redirect()->back()->with('success', 'Bank account deleted successfully!');
    }
}
