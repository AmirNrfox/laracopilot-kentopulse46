<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    private function checkAuth()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return null;
    }

    public function index()
    {
        if ($r = $this->checkAuth()) return $r;
        $products = Product::with('category')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        if ($r = $this->checkAuth()) return $r;
        $categories = Category::where('active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if ($r = $this->checkAuth()) return $r;

        $data = $request->validate([
            'name_fa'              => 'required|string|max:255',
            'name_en'              => 'required|string|max:255',
            'category_id'          => 'required|exists:categories,id',
            'price'                => 'required|integer|min:0',
            'sale_price'           => 'nullable|integer|min:0',
            'stock'                => 'required|integer|min:0',
            'brand'                => 'nullable|string|max:100',
            'sku'                  => 'nullable|string|max:100|unique:products',
            'weight'               => 'nullable|numeric',
            'description_fa'       => 'nullable|string',
            'description_en'       => 'nullable|string',
            'short_description_fa' => 'nullable|string|max:500',
            'short_description_en' => 'nullable|string|max:500',
            'main_image'           => 'nullable|image|max:2048',
            'meta_title'           => 'nullable|string|max:255',
            'meta_description'     => 'nullable|string|max:500',
        ]);

        $data['slug']     = Str::slug($request->name_en) . '-' . time();
        $data['active']   = $request->has('active');
        $data['featured'] = $request->has('featured');

        if ($request->hasFile('main_image')) {
            $data['main_image'] = $request->file('main_image')->store('products', 'public');
        }

        $product = Product::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products', 'public');
                ProductImage::create(['product_id' => $product->id, 'image' => $path]);
            }
        }

        if ($request->filled('variants')) {
            foreach ($request->variants as $v) {
                if (!empty($v['value_fa'])) {
                    ProductVariant::create([
                        'product_id'     => $product->id,
                        'type'           => $v['type'],
                        'value_fa'       => $v['value_fa'],
                        'value_en'       => $v['value_en'],
                        'price_modifier' => $v['price_modifier'] ?? 0,
                        'stock'          => $v['stock'] ?? 0,
                        'sku'            => $v['sku'] ?? null,
                        'active'         => true,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'محصول با موفقیت ایجاد شد ✅');
    }

    public function edit($id)
    {
        if ($r = $this->checkAuth()) return $r;
        $product    = Product::with(['images', 'variants'])->findOrFail($id);
        $categories = Category::where('active', true)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        if ($r = $this->checkAuth()) return $r;
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'name_fa'              => 'required|string|max:255',
            'name_en'              => 'required|string|max:255',
            'category_id'          => 'required|exists:categories,id',
            'price'                => 'required|integer|min:0',
            'sale_price'           => 'nullable|integer|min:0',
            'stock'                => 'required|integer|min:0',
            'brand'                => 'nullable|string|max:100',
            'weight'               => 'nullable|numeric',
            'description_fa'       => 'nullable|string',
            'description_en'       => 'nullable|string',
            'short_description_fa' => 'nullable|string|max:500',
            'short_description_en' => 'nullable|string|max:500',
            'main_image'           => 'nullable|image|max:2048',
            'meta_title'           => 'nullable|string|max:255',
            'meta_description'     => 'nullable|string|max:500',
        ]);

        $data['active']   = $request->has('active');
        $data['featured'] = $request->has('featured');

        if ($request->hasFile('main_image')) {
            if ($product->main_image) Storage::disk('public')->delete($product->main_image);
            $data['main_image'] = $request->file('main_image')->store('products', 'public');
        }

        $product->update($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products', 'public');
                ProductImage::create(['product_id' => $product->id, 'image' => $path]);
            }
        }

        if ($request->filled('variants')) {
            foreach ($request->variants as $vid => $v) {
                if (is_numeric($vid)) {
                    ProductVariant::where('id', $vid)->update([
                        'value_fa'       => $v['value_fa'],
                        'value_en'       => $v['value_en'],
                        'price_modifier' => $v['price_modifier'] ?? 0,
                        'stock'          => $v['stock'] ?? 0,
                    ]);
                } elseif (!empty($v['value_fa'])) {
                    ProductVariant::create([
                        'product_id'     => $product->id,
                        'type'           => $v['type'],
                        'value_fa'       => $v['value_fa'],
                        'value_en'       => $v['value_en'],
                        'price_modifier' => $v['price_modifier'] ?? 0,
                        'stock'          => $v['stock'] ?? 0,
                        'active'         => true,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'محصول با موفقیت ویرایش شد ✅');
    }

    public function destroy($id)
    {
        if ($r = $this->checkAuth()) return $r;
        $product = Product::findOrFail($id);
        if ($product->main_image) Storage::disk('public')->delete($product->main_image);
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->image);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'محصول حذف شد');
    }

    public function uploadImage(Request $request, $id)
    {
        if ($r = $this->checkAuth()) return $r;
        $request->validate(['image' => 'required|image|max:2048']);
        $path = $request->file('image')->store('products', 'public');
        ProductImage::create(['product_id' => $id, 'image' => $path]);
        return back()->with('success', 'تصویر آپلود شد');
    }

    public function deleteImage($imageId)
    {
        if ($r = $this->checkAuth()) return $r;
        $image = ProductImage::findOrFail($imageId);
        Storage::disk('public')->delete($image->image);
        $image->delete();
        return back()->with('success', 'تصویر حذف شد');
    }
}