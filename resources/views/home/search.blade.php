@extends('layouts.app')

@section('title', 'ค้นหา: ' . $query)

@section('meta_description', 'ผลการค้นหาสำหรับ ' . $query)

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">ผลการค้นหา: "{{ $query }}"</h1>
            <div class="mt-2 text-gray-600">
                พบ {{ $products->total() }} สินค้า และ {{ $articles->total() }} บทความ
            </div>
        </div>
        
        <!-- Search Form -->
        <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
            @include('components.search-form')
        </div>
        
        <!-- Filter Controls -->
        <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
            <div class="flex flex-wrap items-center gap-4">
                <span class="text-gray-700">แสดง:</span>
                <a href="{{ route('search', ['q' => $query, 'type' => 'all']) }}" 
                   class="px-4 py-1 rounded-full {{ $type === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                    ทั้งหมด
                </a>
                <a href="{{ route('search', ['q' => $query, 'type' => 'products']) }}" 
                   class="px-4 py-1 rounded-full {{ $type === 'products' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                    สินค้า
                </a>
                <a href="{{ route('search', ['q' => $query, 'type' => 'articles']) }}" 
                   class="px-4 py-1 rounded-full {{ $type === 'articles' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                    บทความ
                </a>
            </div>
        </div>
        
        <!-- Products Section -->
        @if($type === 'all' || $type === 'products')
            <section class="mb-10">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">สินค้า</h2>
                    @if($type === 'all' && $products->total() > $products->count())
                        <a href="{{ route('search', ['q' => $query, 'type' => 'products']) }}" class="text-blue-600 hover:text-blue-800 font-medium">ดูทั้งหมด</a>
                    @endif
                </div>
                
                @if($products->isNotEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-6">
                        @foreach($products as $product)
                            @include('components.product-card', ['product' => $product])
                        @endforeach
                    </div>
                    
                    {{ $products->appends(['q' => $query, 'type' => $type])->links('components.pagination') }}
                @else
                    <div class="bg-gray-50 rounded-lg p-6 text-center">
                        <p class="text-gray-600">ไม่พบสินค้าที่ตรงกับคำค้นหา "{{ $query }}"</p>
                    </div>
                @endif
            </section>
        @endif
        
        <!-- Articles Section -->
        @if($type === 'all' || $type === 'articles')
            <section>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">บทความ</h2>
                    @if($type === 'all' && $articles->total() > $articles->count())
                        <a href="{{ route('search', ['q' => $query, 'type' => 'articles']) }}" class="text-blue-600 hover:text-blue-800 font-medium">ดูทั้งหมด</a>
                    @endif
                </div>
                
                @if($articles->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        @foreach($articles as $article)
                            @include('components.article-card', ['article' => $article])
                        @endforeach
                    </div>
                    
                    {{ $articles->appends(['q' => $query, 'type' => $type])->links('components.pagination') }}
                @else
                    <div class="bg-gray-50 rounded-lg p-6 text-center">
                        <p class="text-gray-600">ไม่พบบทความที่ตรงกับคำค้นหา "{{ $query }}"</p>
                    </div>
                @endif
            </section>
        @endif
    </div>
@endsection