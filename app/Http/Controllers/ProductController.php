<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::with('category', 'images')->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->with('children')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'material' => 'nullable|string',
            'dimensions' => 'nullable|string',
            'weight' => 'nullable|numeric',
            'main_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'main_image_url' => 'nullable|url',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_image_urls' => 'nullable|string',
        ]);

        // Xử lý ảnh chính
        if ($request->hasFile('main_image_file')) {
            $mainImage = $request->file('main_image_file')->store('products/main', 'public');
            $validated['main_image_url'] = 'storage/' . $mainImage;
        } elseif ($request->filled('main_image_url') && filter_var($request->main_image_url, FILTER_VALIDATE_URL)) {
            $validated['main_image_url'] = $request->main_image_url;
        } else {
            $validated['main_image_url'] = null;
        }

        $product = Product::create($validated);

        // Xử lý ảnh phụ từ file
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $image) {
                $path = $image->store('products/gallery', 'public');
                $product->images()->create(['image_url' => 'storage/' . $path]);
            }
        }

        // Xử lý ảnh phụ từ URL
        if ($request->filled('additional_image_urls')) {
            $urls = preg_split('/\r\n|\r|\n/', $request->additional_image_urls);
            foreach ($urls as $url) {
                $url = trim($url);
                if (filter_var($url, FILTER_VALIDATE_URL)) {
                    $product->images()->create(['image_url' => $url]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công.');
    }


    public function edit(Product $product)
    {
        $categories = Category::whereNull('parent_id')->with('children')->get();
        $product->load('images');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'material' => 'nullable|string',
            'dimensions' => 'nullable|string',
            'weight' => 'nullable|numeric',
            'main_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'main_image_url' => 'nullable|url',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_image_urls' => 'nullable|string',
        ]);

        // Xử lý ảnh chính
        if ($request->hasFile('main_image_file')) {
            if ($product->main_image_url && Str::startsWith($product->main_image_url, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $product->main_image_url));
            }

            $mainImage = $request->file('main_image_file')->store('products/main', 'public');
            $validated['main_image_url'] = 'storage/' . $mainImage;
        } elseif ($request->filled('main_image_url') && filter_var($request->main_image_url, FILTER_VALIDATE_URL)) {
            if ($product->main_image_url && Str::startsWith($product->main_image_url, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $product->main_image_url));
            }

            $validated['main_image_url'] = $request->main_image_url;
        } else {
            unset($validated['main_image_url']);
        }

        $product->update($validated);

        // Xử lý ảnh phụ mới từ file
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $image) {
                $path = $image->store('products/gallery', 'public');
                $product->images()->create(['image_url' => 'storage/' . $path]);
            }
        }

        // Xử lý ảnh phụ mới từ URL
        if ($request->filled('additional_image_urls')) {
            $urls = preg_split('/\r\n|\r|\n/', $request->additional_image_urls);
            foreach ($urls as $url) {
                $url = trim($url);
                if (filter_var($url, FILTER_VALIDATE_URL)) {
                    $product->images()->create(['image_url' => $url]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công.');
    }


    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);

        // Xóa file nếu là ảnh upload
        if (!$image->is_url && file_exists(public_path($image->image_url))) {
            unlink(public_path($image->image_url));
        }

        $image->delete();
        return back()->with('success', 'Đã xóa ảnh phụ thành công.');
    }


    public function destroy(Product $product)
    {
        // Xoá ảnh phụ
        foreach ($product->images as $img) {
            if (Str::startsWith($img->image_url, 'storage/')) {
                $path = str_replace('storage/', '', $img->image_url);
                Storage::disk('public')->delete($path);
            }
        }

        $product->images()->delete();

        // Xoá ảnh chính nếu là ảnh upload
        if ($product->main_image_url && Str::startsWith($product->main_image_url, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $product->main_image_url));
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Đã xoá sản phẩm.');
    }
}
