@extends('layouts.app')

@section('title', 'หน้าแรก')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-8 md:mb-0">
                    <h1 class="text-3xl md:text-4xl font-bold mb-4">สินค้าคุณภาพจาก Shopee และ Lazada</h1>
                    <p class="text-lg mb-6">รวบรวมสินค้าคุณภาพจากร้านค้าออนไลน์ชั้นนำ พร้อมบทความรีวิวและคำแนะนำในการเลือกซื้อ</p>
                    <div class="flex space-x-4">
                        <a href="{{ route('products.index') }}" class="bg-white text-blue-600 hover:bg-gray-100 px-6 py-2 rounded-md font-semibold">
                            ดูสินค้าทั้งหมด
                        </a>
                        <a href="{{ route('articles.index') }}" class="bg-transparent hover:bg-blue-700 border border-white px-6 py-2 rounded-md font-semibold">
                            อ่านบทความ
                        </a>
                    </div>
                </div>
                <div class="md:w-1/2">
                    <img src="{{ asset('images/hero-image.jpg') }}" alt="Hero Image" class="rounded-lg shadow-lg w-full" onerror="this.src='https://via.placeholder.com/600x400?text=Hero+Image'">
                </div>
            </div>
        </div>
    </section>
    
    <!-- Featured Products -->
    @if($featuredProducts->isNotEmpty())
        <section class="py-10">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">สินค้าแนะนำ</h2>
                    <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">ดูทั้งหมด</a>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                    @foreach($featuredProducts as $product)
                        @include('components.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    
    <!-- Latest Products -->
    @if($latestProducts->isNotEmpty())
        <section class="py-10 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">สินค้าล่าสุด</h2>
                    <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">ดูทั้งหมด</a>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($latestProducts as $product)
                        @include('components.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    
    <!-- Popular Categories -->
    @if($popularProductCategories->isNotEmpty())
        <section class="py-10">
            <div class="container mx-auto px-4">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">หมวดหมู่ยอดนิยม</h2>
                
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    @foreach($popularProductCategories as $category)
                        <a href="{{ route('category.show', ['category' => $category->slug]) }}" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            <div class="p-4 text-center">
                                <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-blue-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-gray-800">{{ $category->name }}</h3>
                                <p class="text-sm text-gray-600 mt-1">{{ $category->products_count }} สินค้า</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    
    <!-- Latest Articles -->
    @if($latestArticles->isNotEmpty())
        <section class="py-10 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">บทความล่าสุด</h2>
                    <a href="{{ route('articles.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">ดูทั้งหมด</a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($latestArticles as $article)
                        @include('components.article-card', ['article' => $article])
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    
    <!-- Popular Tags -->
    @if($popularTags->isNotEmpty())
        <section class="py-10">
            <div class="container mx-auto px-4">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">แท็กยอดนิยม</h2>
                
                <div class="flex flex-wrap gap-2">
                    @foreach($popularTags as $tag)
                        <a href="{{ route('tag.show', ['tag' => $tag->slug]) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-sm">
                            {{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection