<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\State;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with([
    'billingStateRelation', 
    'billingCityRelation',
    'shippingStateRelation',
    'shippingCityRelation'
])->get();

        return view('admin.pages.customers.customers-view', compact('customers'));
    }
    public function create()
    {
        $states = State::orderBy('name')->get();

        return view('admin.pages.customers.add-customer', compact('states'));
    }

    public function store(Request $request)
    {
        // Validate input
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|digits_between:8,15',

            'account_number' => 'nullable|numeric',
            'ifsc' => 'nullable|string|max:20',
        ]);

        // Check if customer already exists by email or phone
        $exists = Customer::where('email', $request->email)
            ->orWhere('phone', $request->phone)
            ->first();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['duplicate' => 'Customer already exists.']);
        }

        // Create new customer
        Customer::create($data);

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully.');
    }

    public function edit(Customer $customer)
    {
         // Get all states from your states table
    $states = State::all(); // <-- make sure your State model exists
        return view('admin.pages.customers.edit-customer', compact('customer', 'states'));
    }

    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('customers')->ignore($customer->id)
            ],
            'phone' => 'required|digits_between:8,15',

            'account_number' => 'nullable|numeric',
            'ifsc' => 'nullable|string|max:20',
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}
