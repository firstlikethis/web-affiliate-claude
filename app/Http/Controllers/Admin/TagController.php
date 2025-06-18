<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the tags.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Tag::withCount(['products', 'articles']);
        
        // ค้นหาตามชื่อแท็ก
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }
        
        // เรียงลำดับ
        $orderBy = $request->input('order_by', 'name');
        $orderDirection = $request->input('order_direction', 'asc');
        $query->orderBy($orderBy, $orderDirection);
        
        $tags = $query->paginate(15)->withQueryString();
        
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new tag.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created tag in storage.
     *
     * @param  \App\Http\Requests\StoreTagRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTagRequest $request)
    {
        $data = $request->validated();
        
        // Generate slug
        $data['slug'] = Str::slug($data['name']);
        
        // Create tag
        Tag::create($data);
        
        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag created successfully.');
    }

    /**
     * Display the specified tag.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\View\View
     */
    public function show(Tag $tag)
    {
        $tag->load(['products', 'articles']);
        
        return view('admin.tags.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified tag.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\View\View
     */
    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified tag in storage.
     *
     * @param  \App\Http\Requests\UpdateTagRequest  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $data = $request->validated();
        
        // Generate slug if name changed
        if ($request->has('name') && $tag->name !== $request->input('name')) {
            $data['slug'] = Str::slug($data['name']);
        }
        
        // Update tag
        $tag->update($data);
        
        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag updated successfully.');
    }

    /**
     * Remove the specified tag from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Tag $tag)
    {
        // Delete tag (related records in the pivot table will be deleted via cascade)
        $tag->delete();
        
        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag deleted successfully.');
    }
}