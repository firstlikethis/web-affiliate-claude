<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'tags']);
        
        // ค้นหาตามชื่อสินค้า
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }
        
        // กรองตามหมวดหมู่
        if ($request->has('category') && $request->input('category') !== '') {
            $query->where('category_id', $request->input('category'));
        }
        
        // กรองตามแพลตฟอร์ม
        if ($request->has('platform') && $request->input('platform') !== '') {
            $query->where('platform', $request->input('platform'));
        }
        
        // เรียงลำดับ
        $orderBy = $request->input('order_by', 'created_at');
        $orderDirection = $request->input('order_direction', 'desc');
        $query->orderBy($orderBy, $orderDirection);
        
        $products = $query->paginate(15)->withQueryString();
        $categories = Category::query()->products()->get();
        
        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::query()->products()->get();
        $tags = Tag::orderBy('name')->get();
        
        return view('admin.products.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        
        // Generate slug
        $data['slug'] = Str::slug($data['name']);
        
        // Upload image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }
        
        // Set featured status
        $data['is_featured'] = $request->has('is_featured');
        
        // Create product
        $product = Product::create($data);
        
        // Attach tags
        if ($request->has('tags')) {
            $product->tags()->attach($request->input('tags'));
        }
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\View
     */
    public function show(Product $product)
    {
        $product->load(['category', 'tags', 'clickLogs']);
        
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\View
     */
    public function edit(Product $product)
    {
        $categories = Category::query()->products()->get();
        $tags = Tag::orderBy('name')->get();
        $selectedTags = $product->tags->pluck('id')->toArray();
        
        return view('admin.products.edit', compact('product', 'categories', 'tags', 'selectedTags'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        
        // Generate slug if name changed
        if ($request->has('name') && $product->name !== $request->input('name')) {
            $data['slug'] = Str::slug($data['name']);
        }
        
        // Update image if provided
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            // Upload new image
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }
        
        // Set featured status
        $data['is_featured'] = $request->has('is_featured');
        
        // Update product
        $product->update($data);
        
        // Sync tags
        if ($request->has('tags')) {
            $product->tags()->sync($request->input('tags'));
        } else {
            $product->tags()->detach();
        }
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        // Delete image
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        // Delete product (related records will be deleted via cascade)
        $product->delete();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}