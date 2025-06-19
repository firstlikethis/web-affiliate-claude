<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the articles.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Article::with(['category', 'user', 'tags'])
            ->where('is_published', true);
        
        // กรองตามหมวดหมู่
        if ($request->has('category') && $request->input('category') !== '') {
            $query->where('category_id', $request->input('category'));
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
        
        // เรียงลำดับ
        $orderBy = $request->input('sort', 'created_at');
        $orderDirection = $request->input('direction', 'desc');
        
        switch ($orderBy) {
            case 'popularity':
                $query->orderBy('view_count', 'desc');
                break;
            case 'title':
                $query->orderBy('title', $orderDirection);
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $articles = $query->paginate(9)->withQueryString();
        $categories = Category::query()->articles()->get();
        $tags = Tag::withCount('articles')
            ->having('articles_count', '>', 0)
            ->orderBy('name')
            ->get();
        
        return view('articles.index', compact('articles', 'categories', 'tags'));
    }
    
    /**
     * Display the specified article.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\View\View
     */
    public function show(Article $article)
    {
        // Increment view count
        $article->increment('view_count');
        
        // Load related data
        $article->load(['category', 'user', 'tags']);
        
        // Get related articles (same category or tags)
        $relatedArticles = Article::with(['category', 'tags'])
            ->where('is_published', true)
            ->where('id', '!=', $article->id)
            ->where(function($query) use ($article) {
                $query->where('category_id', $article->category_id)
                    ->orWhereHas('tags', function($q) use ($article) {
                        $articleTagIds = $article->tags->pluck('id')->toArray();
                        if (!empty($articleTagIds)) {
                            $q->whereIn('tags.id', $articleTagIds);
                        }
                    });
            })
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        
        // Get products mentioned in the article (if any)
        $productSlugs = $this->extractProductSlugs($article->content);
        $mentionedProducts = [];
        
        if (!empty($productSlugs)) {
            $mentionedProducts = Product::with('category')
                ->whereIn('slug', $productSlugs)
                ->get();
        }
        
        return view('articles.show', compact(
            'article', 
            'relatedArticles', 
            'mentionedProducts'
        ));
    }
    
    /**
     * Extract product slugs from article content.
     *
     * @param  string  $content
     * @return array
     */
    private function extractProductSlugs($content)
    {
        $slugs = [];
        $pattern = '/\/go\/([a-z0-9\-]+)/i';
        
        if (preg_match_all($pattern, $content, $matches)) {
            $slugs = $matches[1];
        }
        
        return array_unique($slugs);
    }
}