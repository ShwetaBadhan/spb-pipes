<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AddonController extends Controller
{
    public function index(): View
    {
        $addons = Addon::withCount('tenants')->orderBy('price_monthly')->get();

        return view('super-admin.addons.index', compact('addons'));
    }

    public function create(): View
    {
        return view('super-admin.addons.create', ['features' => config('saas.features')]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        Addon::create($data);

        return redirect()->route('super-admin.addons.index')->with('success', 'Add-on created.');
    }

    public function edit(Addon $addon): View
    {
        return view('super-admin.addons.edit', [
            'addon' => $addon,
            'features' => config('saas.features'),
        ]);
    }

    public function update(Request $request, Addon $addon): RedirectResponse
    {
        $data = $this->validated($request);

        $addon->update($data);

        return redirect()->route('super-admin.addons.index')->with('success', 'Add-on updated.');
    }

    public function destroy(Addon $addon): RedirectResponse
    {
        $addon->delete();

        return redirect()->route('super-admin.addons.index')->with('success', 'Add-on deleted.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'alpha_dash', 'max:60', Rule::unique('addons', 'slug')->ignore($request->route('addon'))],
            'price_monthly' => ['required', 'numeric', 'min:0'],
            'feature' => ['nullable', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
        ]);
    }
}
