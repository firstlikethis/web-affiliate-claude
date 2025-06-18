<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;

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
        
        // กรองตามหมวดหมู่
        if ($request->has('category') && $request->input('category') !== '') {
            $query->where('category_id', $request->input('category'));
        }
        
        // กรองตามแพลตฟอร์ม
        if ($request->has('platform') && $request->input('platform') !== '') {
            $query->where('platform', $request->input('platform'));
        }
        
        // กรองตาม tag
        if ($request->has('tag') && $request->input('tag') !== '') {
            $tag = Tag::where('slug', $request->input('tag'))->first();
            if ($tag) {
                $query->whereHas('tags', function($q) use ($tag) {
                    $q->where('tags.id', $tag->id);
                });
            }
        }
        
        // กรองตามช่วงราคา
        if ($request->has('min_price') && $request->input('min_price') !== '') {
            $query->where('price', '>=', $request->input('min_price'));
        }
        
        if ($request->has('max_price') && $request->input('max_price') !== '') {
            $query->where('price', '<=', $request->input('max_price'));
        }
        
        // เรียงลำดับ
        $orderBy = $request->input('sort', 'created_at');
        $orderDirection = $request->input('direction', 'desc');
        
        switch ($orderBy) {
            case 'price':
                $query->orderBy('price', $orderDirection);
                break;
            case 'popularity':
                $query->orderBy('click_count', 'desc');
                break;
            case 'name':
                $query->orderBy('name', $orderDirection);
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $products = $query->paginate(12)->withQueryString();
        $categories = Category::products()->get();
        $tags = Tag::withCount('products')
            ->having('products_count', '>', 0)
            ->orderBy('name')
            ->get();
        
        // ช่วงราคาของสินค้าทั้งหมด
        $priceRange = [
            'min' => Product::min('price'),
            'max' => Product::max('price'),
        ];
        
        return view('products.index', compact('products', 'categories', 'tags', 'priceRange'));
    }
    
    /**
     * Display the specified product.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($slug)
    {
        // Redirect to affiliate link directly
        $product = Product::where('slug', $slug)->firstOrFail();
        
        return redirect()->route('redirect.affiliate', ['product' => $product->slug]);
    }

    /**
     * Search products by name or description.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }
        
        $products = Product::where(function($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                ->orWhere('description', 'like', '%' . $query . '%');
            })
            ->select('id', 'name', 'slug', 'image', 'price', 'discount_price', 'platform')
            ->orderBy('name')
            ->limit(10)
            ->get();
        
        return response()->json($products);
    }
}