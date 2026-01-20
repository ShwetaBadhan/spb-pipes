<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /* =======================
       Generate Product Code
    ======================= */
    public function generateCode(Request $request)
    {
        $name = $request->name;
        if (!$name) {
            return response()->json(['code' => '']);
        }

        $clean  = preg_replace('/[^A-Za-z0-9]/', '', $name);
        $prefix = strtoupper(substr(str_pad($clean, 3, 'X'), 0, 3));

        $lastCode = DB::table('products')
            ->orderByRaw('CAST(SUBSTRING_INDEX(code, "-", -1) AS UNSIGNED) DESC')
            ->value('code');

        $nextNumber = $lastCode
            ? ((int) explode('-', $lastCode)[1] + 1)
            : 1100;

        return response()->json([
            'code' => "{$prefix}-{$nextNumber}"
        ]);
    }

    /* =======================
       List Products
    ======================= */
    public function index()
    {
        $products = Product::with('category', 'unit', 'variants')->latest()->get();
        return view('admin.pages.products', compact('products'));
    }

    /* =======================
       Create Form
    ======================= */
    public function create()
    {
        return view('admin.pages.add-product', [
            'categories' => Category::all(),
            'units'      => Unit::all(),
        ]);
    }

    /* =======================
       Store Product
    ======================= */
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'code'         => 'required|regex:/^[A-Z]{3}-\d+$/|unique:products,code',
            'category_id'  => 'required|exists:categories,id',
            'description'  => 'required|string',
            'unit_id'      => 'required|string',
            'status'       => 'required|boolean',

            'image_path'        => 'image|mimes:jpg,png,jpeg|max:5120',
            'gallery.*'    => 'nullable|image|mimes:jpg,png,jpeg|max:5120',

            'variants'     => 'required|array|min:1',
            'variants.*.selling_price'  => 'required|numeric|min:0',
            'variants.*.purchase_price' => 'nullable|numeric|min:0',
            'variants.*.quantity'       => 'required|integer|min:1',
            'variants.*.alert_quantity' => 'required|integer|min:0|lt:variants.*.quantity',
        ], [
            'variants.*.alert_quantity.lt' =>
                'Alert quantity must be less than quantity.',
        ]);

        DB::transaction(function () use ($request) {

            $imagePath = $request->hasFile('image_path')
                ? $request->file('image_path')->store('products', 'public')
                : null;

            $product = Product::create([
                'name'        => $request->name,
                'code'        => $request->code,
                'slug'        => Str::slug($request->name),
                'category_id' => $request->category_id,
                'description' => $request->description,
                'unit_id'     => $request->unit_id,
                'status'      => $request->status, // ✅ FIXED
                'image_path'       => $imagePath,
            ]);

            foreach ($request->variants as $variant) {
                ProductVariant::create([
                    'product_id'     => $product->id,
                    'selling_price'  => $variant['selling_price'],
                    'purchase_price' => $variant['purchase_price'] ?? 0,
                    'quantity'       => $variant['quantity'],
                    'alert_quantity' => $variant['alert_quantity'],
                ]);
            }

            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $file) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $file->store('products/gallery', 'public'),
                    ]);
                }
            }
        });

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully.');
    }

        /* =======================
       Edit Product
    ======================= */
public function edit(Product $product)
{
    $product->load(['variants', 'gallery', 'category', 'unit']);

    $categories = Category::all();
    $units = Unit::all();
    $variants = $product->variants->all();
    $gallery = ProductImage::all();
    return view('admin.pages.edit-product', compact(
        'product',
        'categories',
        'units',
        'variants',
        'gallery'
    ));
}

    /* =======================
       Update Product
    ======================= */
    public function update(Request $request, Product $product)
{
    $request->validate([
        'name'         => 'required|string|max:255',
        'category_id'  => 'required|exists:categories,id',
        'description'  => 'required|string',
        'unit_id'      => 'required|string',
        'status'       => 'required|boolean',
        'image_path'        => 'nullable|image|mimes:jpg,png,jpeg|max:5120',

        // 🔥 VARIANTS
        'variants'     => 'required|array|min:1',
        'variants.*.selling_price'  => 'required|numeric|min:0',
        'variants.*.purchase_price' => 'nullable|numeric|min:0',
        'variants.*.quantity'       => 'required|integer|min:1',
        'variants.*.alert_quantity' => 'required|integer|min:0|lt:variants.*.quantity',
    ], [
        'variants.*.alert_quantity.lt' =>
            'Alert quantity must be less than quantity.',
    ]);

    DB::transaction(function () use ($request, $product) {

        /* ---------- MAIN IMAGE ---------- */
        if ($request->hasFile('image_path')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }

            $product->image_path = $request->file('image_path')
                ->store('products', 'public');
        }

        /* ---------- PRODUCT UPDATE ---------- */
        $product->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'unit_id'     => $request->unit_id,
            'status'      => $request->status,
            'image_path'       => $product->image_path,
        ]);

        /* ---------- VARIANTS UPDATE ---------- */
        $product->variants()->delete();

        foreach ($request->variants as $variant) {
            ProductVariant::create([
                'product_id'     => $product->id,
                'size'           => $variant['size'] ?? null,
                'color'          => $variant['color'] ?? null,
                'type'           => $variant['type'] ?? null,
                'selling_price'  => $variant['selling_price'],
                'purchase_price' => $variant['purchase_price'] ?? 0,
                'quantity'       => $variant['quantity'],
                'alert_quantity' => $variant['alert_quantity'],
            ]);
        }

        /* ---------- GALLERY ---------- */
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $file->store('products/gallery', 'public'),
                ]);
            }
        }
    });

    return redirect()
        ->route('products.index')
        ->with('success', 'Product updated successfully.');
}


    /* =======================
       Delete Product
    ======================= */
    public function destroy(Product $product)
    {
        DB::transaction(function () use ($product) {

            Storage::disk('public')->delete($product->image_path);

            foreach ($product->gallery as $img) {
                Storage::disk('public')->delete($img->image_path);
                $img->delete();
            }

            $product->variants()->delete();
            $product->delete();
        });

        return back()->with('success', 'Product deleted successfully.');
    }
    public function exportPdf()
{
    $products = Product::all();
    $pdf = Pdf::loadView('admin.pages.products', compact('products'));
    return $pdf->download('products.pdf');
}

public function exportExcel()
{
    return Excel::download(new ProductsExport, 'products.xlsx');
}
}
