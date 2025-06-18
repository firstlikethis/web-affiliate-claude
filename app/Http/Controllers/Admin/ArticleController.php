<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $query = Article::with(['category', 'user', 'tags']);
        
        // ค้นหาตามชื่อบทความ
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->input('search') . '%');
        }
        
        // กรองตามหมวดหมู่
        if ($request->has('category') && $request->input('category') !== '') {
            $query->where('category_id', $request->input('category'));
        }
        
        // กรองตามสถานะ
        if ($request->has('status') && $request->input('status') !== '') {
            $status = $request->input('status') === 'published';
            $query->where('is_published', $status);
        }
        
        // เรียงลำดับ
        $orderBy = $request->input('order_by', 'created_at');
        $orderDirection = $request->input('order_direction', 'desc');
        $query->orderBy($orderBy, $orderDirection);
        
        $articles = $query->paginate(15)->withQueryString();
        $categories = Category::articles()->get();
        
        return view('admin.articles.index', compact('articles', 'categories'));
    }

    /**
     * Show the form for creating a new article.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::articles()->get();
        $tags = Tag::orderBy('name')->get();
        
        return view('admin.articles.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created article in storage.
     *
     * @param  \App\Http\Requests\StoreArticleRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreArticleRequest $request)
    {
        $data = $request->validated();
        
        // Generate slug
        $data['slug'] = Str::slug($data['title']);
        
        // Set current user as author
        $data['user_id'] = Auth::id();
        
        // Upload thumbnail
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('articles', 'public');
            $data['thumbnail'] = $path;
        }
        
        // Set published status
        $data['is_published'] = $request->has('is_published');
        
        // Create article
        $article = Article::create($data);
        
        // Attach tags
        if ($request->has('tags')) {
            $article->tags()->attach($request->input('tags'));
        }
        
        return redirect()->route('admin.articles.index')
            ->with('success', 'Article created successfully.');
    }

    /**
     * Display the specified article.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\View\View
     */
    public function show(Article $article)
    {
        $article->load(['category', 'user', 'tags']);
        
        return view('admin.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified article.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\View\View
     */
    public function edit(Article $article)
    {
        $categories = Category::articles()->get();
        $tags = Tag::orderBy('name')->get();
        $selectedTags = $article->tags->pluck('id')->toArray();
        
        return view('admin.articles.edit', compact('article', 'categories', 'tags', 'selectedTags'));
    }

    /**
     * Update the specified article in storage.
     *
     * @param  \App\Http\Requests\UpdateArticleRequest  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $data = $request->validated();
        
        // Generate slug if title changed
        if ($request->has('title') && $article->title !== $request->input('title')) {
            $data['slug'] = Str::slug($data['title']);
        }
        
        // Update thumbnail if provided
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($article->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }
            
            // Upload new thumbnail
            $path = $request->file('thumbnail')->store('articles', 'public');
            $data['thumbnail'] = $path;
        }
        
        // Set published status
        $data['is_published'] = $request->has('is_published');
        
        // Update article
        $article->update($data);
        
        // Sync tags
        if ($request->has('tags')) {
            $article->tags()->sync($request->input('tags'));
        } else {
            $article->tags()->detach();
        }
        
        return redirect()->route('admin.articles.index')
            ->with('success', 'Article updated successfully.');
    }

    /**
     * Remove the specified article from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Article $article)
    {
        // Delete thumbnail
        if ($article->thumbnail) {
            Storage::disk('public')->delete($article->thumbnail);
        }
        
        // Delete article (related records will be deleted via cascade)
        $article->delete();
        
        return redirect()->route('admin.articles.index')
            ->with('success', 'Article deleted successfully.');
    }
}