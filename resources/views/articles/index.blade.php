@extends('layouts.app')

@section('title', 'บทความทั้งหมด')

@section('meta_description', 'รวมบทความเกี่ยวกับสินค้าและการเลือกซื้อสินค้าออนไลน์')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">บทความทั้งหมด</h1>
            <div class="mt-2 text-gray-600">
                พบ {{ $articles->total() }} รายการ
            </div>
        </div>
        
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Sidebar -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">ค้นหา</h2>
                    <form action="{{ route('articles.index') }}" method="GET">
                        <div class="mb-4">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="ค้นหาบทความ..." 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        
                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            ค้นหา
                        </button>
                    </form>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">หมวดหมู่</h2>
                    <form action="{{ route('articles.index') }}" method="GET">
                        @if(request()->has('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="radio" id="category_all" name="category" value="" 
                                       {{ request('category') === null ? 'checked' : '' }} class="h-4 w-4 text-blue-600">
                                <label for="category_all" class="ml-2 text-gray-700">ทั้งหมด</label>
                            </div>
                            
                            @foreach($categories as $category)
                                <div class="flex items-center">
                                    <input type="radio" id="category_{{ $category->id }}" name="category" value="{{ $category->id }}" 
                                           {{ request('category') == $category->id ? 'checked' : '' }} class="h-4 w-4 text-blue-600">
                                    <label for="category_{{ $category->id }}" class="ml-2 text-gray-700">{{ $category->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        
                        <button type="submit" class="mt-4 w-full bg-gray-100 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            กรอง
                        </button>
                    </form>
                </div>
                
                @if($tags->isNotEmpty())
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">แท็กยอดนิยม</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tags as $tag)
                                <a href="{{ route('tag.show', ['tag' => $tag->slug, 'type' => 'articles']) }}" 
                                   class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-sm">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Articles Listing -->
            <div class="lg:w-3/4">
                <!-- Sort Controls -->
                <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="text-gray-600">
                            แสดงผล {{ $articles->firstItem() ?? 0 }} - {{ $articles->lastItem() ?? 0 }} จาก {{ $articles->total() }} รายการ
                        </div>
                        
                        <form action="{{ route('articles.index') }}" method="GET" class="flex items-center">
                            @if(request()->has('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            @if(request()->has('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            
                            <label for="sort" class="text-gray-700 mr-2">เรียงตาม:</label>
                            <select id="sort" name="sort" onchange="this.form.submit()" 
                                    class="border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="created_at" {{ request('sort') === 'created_at' || !request('sort') ? 'selected' : '' }}>ล่าสุด</option>
                                <option value="popularity" {{ request('sort') === 'popularity' ? 'selected' : '' }}>ความนิยม</option>
                                <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>ชื่อ: A-Z</option>
                            </select>
                            
                            <input type="hidden" name="direction" value="{{ request('sort') === 'title' ? 'asc' : 'desc' }}">
                        </form>
                    </div>
                </div>
                
                @if($articles->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        @foreach($articles as $article)
                            @include('components.article-card', ['article' => $article])
                        @endforeach
                    </div>
                    
                    {{ $articles->links('components.pagination') }}
                @else
                    <div class="bg-gray-50 rounded-lg p-8 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">ไม่พบบทความ</h3>
                        <p class="text-gray-600">กรุณาลองเปลี่ยนตัวกรอง หรือค้นหาด้วยคำอื่น</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection