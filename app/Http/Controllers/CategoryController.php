<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('children', 'parent')
            ->whereNull('parent_id') // Chỉ lấy danh mục gốc
            ->latest()
            ->get();

        return view('admin.categories.index', compact('categories'));
    }


    public function create()
    {
        $parents = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_url' => 'nullable|url',
        ]);

        $data = $request->only('name', 'description', 'parent_id');

        // Ưu tiên ảnh từ file upload nếu có
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'category_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/category_images', $filename);
            $data['image'] = 'storage/category_images/' . $filename;
        } elseif ($request->filled('image_url')) {
            $data['image'] = $request->image_url;
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục thành công.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $parents = Category::where('id', '!=', $id)->whereNull('parent_id')->get();
        return view('admin.categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_url' => 'nullable|url',
        ]);

        $data = $request->only('name', 'description', 'parent_id');

        // Nếu có ảnh mới từ file upload
        if ($request->hasFile('image_file')) {
            // Xoá ảnh cũ nếu là ảnh upload
            if ($category->image && str_starts_with($category->image, 'storage/category_images')) {
                Storage::delete(str_replace('storage/', 'public/', $category->image));
            }

            $file = $request->file('image_file');
            $filename = 'category_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/category_images', $filename);
            $data['image'] = 'storage/category_images/' . $filename;
        }
        // Nếu không upload file nhưng có nhập URL
        elseif ($request->filled('image_url')) {
            // Nếu ảnh cũ là ảnh upload thì xoá trước
            if ($category->image && str_starts_with($category->image, 'storage/category_images')) {
                Storage::delete(str_replace('storage/', 'public/', $category->image));
            }
            $data['image'] = $request->image_url;
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Xoá ảnh nếu là ảnh upload
        if ($category->image && str_starts_with($category->image, 'storage/category_images')) {
            Storage::delete(str_replace('storage/', 'public/', $category->image));
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Xoá danh mục thành công.');
    }
}
