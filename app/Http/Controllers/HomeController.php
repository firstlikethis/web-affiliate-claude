<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // สินค้าแนะนำ
        $featuredProducts = Product::with(['category', 'tags'])
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
        
        // สินค้าล่าสุด
        $latestProducts = Product::with(['category', 'tags'])
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
        
        // บทความล่าสุด
        $latestArticles = Article::with(['category', 'user', 'tags'])
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        
        // หมวดหมู่สินค้ายอดนิยม
        $popularProductCategories = Category::query()->products()
            ->withCount('products')
            ->orderBy('products_count', 'desc')
            ->take(6)
            ->get();
        
        // Tags ยอดนิยม
        $popularTags = Tag::withCount(['products', 'articles'])
            ->orderByRaw('products_count + articles_count DESC')
            ->take(10)
            ->get();
        
        return view('home.index', compact(
            'featuredProducts',
            'latestProducts',
            'latestArticles',
            'popularProductCategories',
            'popularTags'
        ));
    }
    
    /**
     * Display products and articles by category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\View\View
     */
    public function category(Category $category = null)
    {
        if (!$category) {
            // จัดการกรณีที่ไม่มีพารามิเตอร์ - เช่น แสดงรายการหมวดหมู่ทั้งหมด หรือ redirect ไปหน้าหลัก
            return redirect()->route('home');
        }

        // โค้ดเดิม...
        if ($category->type === 'product') {
            $products = Product::with(['category', 'tags'])
                ->where('category_id', $category->id)
                ->orderBy('created_at', 'desc')
                ->paginate(12);
            
            return view('home.category-products', compact('category', 'products'));
        } else {
            $articles = Article::with(['category', 'user', 'tags'])
                ->where('category_id', $category->id)
                ->where('is_published', true)
                ->orderBy('created_at', 'desc')
                ->paginate(9);
            
            return view('home.category-articles', compact('category', 'articles'));
        }
    }
    
    /**
     * Display products and articles by tag.
     *
     * @param  \App\Models\Tag  $tag
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function tag(Tag $tag = null, Request $request)
    {
        if (!$tag) {
            // จัดการกรณีที่ไม่มีพารามิเตอร์ - เช่น แสดงรายการแท็กทั้งหมด หรือ redirect ไปหน้าหลัก
            return redirect()->route('home');
        }

        // โค้ดเดิม...
        $type = $request->input('type', 'all');
        
        if ($type === 'products' || $type === 'all') {
            $products = $tag->products()
                ->with(['category', 'tags'])
                ->orderBy('created_at', 'desc')
                ->paginate($type === 'all' ? 8 : 12, ['*'], 'products_page');
        } else {
            $products = collect([]);
        }
        
        if ($type === 'articles' || $type === 'all') {
            $articles = $tag->articles()
                ->with(['category', 'user', 'tags'])
                ->where('is_published', true)
                ->orderBy('created_at', 'desc')
                ->paginate($type === 'all' ? 6 : 9, ['*'], 'articles_page');
        } else {
            $articles = collect([]);
        }
        
        return view('home.tag', compact('tag', 'products', 'articles', 'type'));
    }
    
    /**
     * Search for products and articles.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $query = $request->input('q', '');
        $type = $request->input('type', 'all');
        
        if (empty($query)) {
            return redirect()->route('home');
        }
        
        if ($type === 'products' || $type === 'all') {
            $products = Product::with(['category', 'tags'])
                ->where('name', 'like', '%' . $query . '%')
                ->orWhere('description', 'like', '%' . $query . '%')
                ->orderBy('created_at', 'desc')
                ->paginate($type === 'all' ? 8 : 12, ['*'], 'products_page');
        } else {
            $products = collect([]);
        }
        
        if ($type === 'articles' || $type === 'all') {
            $articles = Article::with(['category', 'user', 'tags'])
                ->where('is_published', true)
                ->where(function($q) use ($query) {
                    $q->where('title', 'like', '%' . $query . '%')
                      ->orWhere('content', 'like', '%' . $query . '%');
                })
                ->orderBy('created_at', 'desc')
                ->paginate($type === 'all' ? 6 : 9, ['*'], 'articles_page');
        } else {
            $articles = collect([]);
        }
        
        return view('home.search', compact('query', 'products', 'articles', 'type'));
    }
}