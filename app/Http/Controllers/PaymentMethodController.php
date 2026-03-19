<?php

namespace App\Http\Controllers;



use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
class PaymentMethodController extends Controller
{
    /**
     * Display payment methods
     */
    public function index()
    {
      
        
        $paymentMethods = PaymentMethod::all();
        return view('admin.pages.settings.finance-settings.payment-methods', compact('paymentMethods'));
    }

    /**
     * Store a new payment method
     */
  // app/Http/Controllers/Admin/PaymentMethodController.php

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'slug' => 'required|string|unique:payment_methods,slug',
        'logo' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048', // ✅ Logo validation
        'email' => 'nullable|email',
        'api_key' => 'nullable|string',
        'secret_key' => 'nullable|string',
        'is_active' => 'nullable|boolean',
    ]);

    // ✅ Handle Logo Upload
    $logoPath = null;
    if ($request->hasFile('logo')) {
        $logo = $request->file('logo');
        $logoName = time() . '_' . $request->slug . '_logo.' . $logo->getClientOriginalExtension();
        $logoPath = $logo->storeAs('payment-methods', $logoName, 'public');
    }

    $paymentMethod = PaymentMethod::create([
        'name' => $validated['name'],
        'slug' => $validated['slug'],
        'logo' => $logoPath, // ✅ Store logo path
        'email' => $validated['email'] ?? null,
        'api_key' => Crypt::encryptString($validated['api_key'] ?? ''),
        'secret_key' => Crypt::encryptString($validated['secret_key'] ?? ''),
        'is_active' => $request->has('is_active'),
        'is_connected' => !empty($validated['api_key']) && !empty($validated['secret_key']),
    ]);

    return redirect()->back()->with('success', "{$paymentMethod->name} payment method added successfully!");
}

    /**
     * Update payment method
     */
    public function update(Request $request, $id)
{
 

    $paymentMethod = PaymentMethod::findOrFail($id);

    // Validation rules - logo ko optional banao
    $rules = [
        'email' => 'nullable|email',
        'api_key' => 'nullable|string',
        'secret_key' => 'nullable|string',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
        'is_active' => 'nullable|boolean',
    ];

    $validated = $request->validate($rules);

    $updateData = [
        'email' => $validated['email'] ?? $paymentMethod->email,
    ];

    // ✅ Robust Logo Upload Check
    if ($request->hasFile('logo')) {
        $file = $request->file('logo');
        
        // Check if file is valid
        if ($file->isValid()) {
            // Delete old logo
            if ($paymentMethod->logo && Storage::disk('public')->exists($paymentMethod->logo)) {
                Storage::disk('public')->delete($paymentMethod->logo);
            }
            
            // Generate unique filename
            $extension = $file->getClientOriginalExtension();
            $logoName = time() . '_' . $paymentMethod->slug . '_logo.' . $extension;
            
            // Store the file
            $path = $file->storeAs('payment-methods', $logoName, 'public');
            
            if ($path) {
                $updateData['logo'] = $path;
                Log::info('Logo uploaded successfully: ' . $path);
            } else {
                Log::error('Logo upload failed for: ' . $paymentMethod->name);
            }
        } else {
            Log::error('Invalid file upload for: ' . $paymentMethod->name);
        }
    }

    // Handle API Key encryption
    if (!empty($validated['api_key'])) {
        $updateData['api_key'] = Crypt::encryptString($validated['api_key']);
    }

    // Handle Secret Key encryption
    if (!empty($validated['secret_key'])) {
        $updateData['secret_key'] = Crypt::encryptString($validated['secret_key']);
    }

    $updateData['is_active'] = $request->has('is_active');
    
    // Check connection
    $hasApiKey = !empty($validated['api_key']) || !empty($paymentMethod->api_key);
    $hasSecretKey = !empty($validated['secret_key']) || !empty($paymentMethod->secret_key);
    $updateData['is_connected'] = $hasApiKey && $hasSecretKey;

    try {
        $paymentMethod->update($updateData);
        return redirect()->back()->with('success', "{$paymentMethod->name} payment method updated successfully!");
    } catch (\Exception $e) {
        Log::error('Payment method update failed: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Update failed: ' . $e->getMessage());
    }
}
    /**
     * Toggle payment method status
     */
    public function toggleStatus($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        $paymentMethod->update(['is_active' => !$paymentMethod->is_active]);

        $status = $paymentMethod->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "{$paymentMethod->name} payment method {$status}!");
    }

    /**
     * Delete payment method
     */
    public function destroy($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        $paymentMethod->delete();

        return redirect()->back()->with('success', 'Payment method deleted successfully!');
    }

    /**
     * Test connection (optional - for future use)
     */
    public function testConnection($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        
        // Here you would add actual API testing logic
        $isConnected = !empty($paymentMethod->api_key) && !empty($paymentMethod->secret_key);
        
        if ($isConnected) {
            $paymentMethod->update(['is_connected' => true]);
            return response()->json(['success' => true, 'message' => 'Connection successful!']);
        }

        return response()->json(['success' => false, 'message' => 'Connection failed!'], 400);
    }
}
