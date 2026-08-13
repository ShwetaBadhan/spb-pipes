<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\State;
use App\Http\Controllers\Concerns\EnforcesPlanLimits;

class CustomerController extends Controller
{
    use EnforcesPlanLimits;

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
    if ($guard = $this->ensurePlanLimit('customers', 'customer')) {
        return $guard;
    }

    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:customers,email',
        'phone' => 'required|digits_between:8,15|unique:customers,phone',

        // Billing address
        'billing_address' => 'nullable|string|max:500',
        'billing_state' => 'nullable|exists:states,id',
        'billing_city' => 'nullable|exists:cities,id',
        'billing_pincode' => 'nullable|string|max:10',

        // Shipping address
        'shipping_address' => 'nullable|string|max:500',
        'shipping_state' => 'nullable|exists:states,id',
        'shipping_city' => 'nullable|exists:cities,id',
        'shipping_pincode' => 'nullable|string|max:10',

        // Banking details
        'bank_name' => 'nullable|string|max:255',
        'branch' => 'nullable|string|max:255',
        'account_holder' => 'nullable|string|max:255',
        'account_number' => 'nullable|numeric',
        'ifsc' => 'nullable|string|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/|max:11', // IFSC format validation
    ]);

    // ✅ ALL FIELDS WILL NOW BE SAVED
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
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'email',
            Rule::unique('customers')->ignore($customer->id)
        ],
        'phone' => [
            'required',
            'digits_between:8,15',
            Rule::unique('customers')->ignore($customer->id)
        ],

        // Billing address
        'billing_address' => 'nullable|string|max:500',
        'billing_state' => 'nullable|exists:states,id',
        'billing_city' => 'nullable|exists:cities,id',
        'billing_pincode' => 'nullable|string|max:10',

        // Shipping address
        'shipping_address' => 'nullable|string|max:500',
        'shipping_state' => 'nullable|exists:states,id',
        'shipping_city' => 'nullable|exists:cities,id',
        'shipping_pincode' => 'nullable|string|max:10',

        // Banking details
        'bank_name' => 'nullable|string|max:255',
        'branch' => 'nullable|string|max:255',
        'account_holder' => 'nullable|string|max:255',
        'account_number' => 'nullable|numeric',
        'ifsc' => 'nullable|string|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/|max:11',
    ]);

    $customer->update($data);

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
