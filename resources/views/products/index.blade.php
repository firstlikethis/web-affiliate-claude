@extends('layouts.app')

@section('title', 'สินค้าทั้งหมด')

@section('meta_description', 'รวมสินค้าคุณภาพจาก Shopee และ Lazada')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">สินค้าทั้งหมด</h1>
            <div class="mt-2 text-gray-600">
                พบ {{ $products->total() }} รายการ
            </div>
        </div>
        
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Sidebar Filters -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">ค้นหา</h2>
                    <form action="{{ route('products.index') }}" method="GET">
                        <div class="mb-4">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="ค้นหาสินค้า..." 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        
                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            ค้นหา
                        </button>
                    </form>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">หมวดหมู่</h2>
                    <form action="{{ route('products.index') }}" method="GET">
                        @if(request()->has('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @if(request()->has('platform'))
                            <input type="hidden" name="platform" value="{{ request('platform') }}">
                        @endif
                        @if(request()->has('min_price'))
                            <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                        @endif
                        @if(request()->has('max_price'))
                            <input type="hidden" name="max_price" value="{{ request('max_price') }}">
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
                
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">แพลตฟอร์ม</h2>
                    <form action="{{ route('products.index') }}" method="GET">
                        @if(request()->has('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @if(request()->has('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if(request()->has('min_price'))
                            <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                        @endif
                        @if(request()->has('max_price'))
                            <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                        @endif
                        
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="radio" id="platform_all" name="platform" value="" 
                                       {{ request('platform') === null ? 'checked' : '' }} class="h-4 w-4 text-blue-600">
                                <label for="platform_all" class="ml-2 text-gray-700">ทั้งหมด</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="platform_shopee" name="platform" value="shopee" 
                                       {{ request('platform') === 'shopee' ? 'checked' : '' }} class="h-4 w-4 text-blue-600">
                                <label for="platform_shopee" class="ml-2 text-gray-700">Shopee</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="platform_lazada" name="platform" value="lazada" 
                                       {{ request('platform') === 'lazada' ? 'checked' : '' }} class="h-4 w-4 text-blue-600">
                                <label for="platform_lazada" class="ml-2 text-gray-700">Lazada</label>
                            </div>
                        </div>
                        
                        <button type="submit" class="mt-4 w-full bg-gray-100 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            กรอง
                        </button>
                    </form>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">ช่วงราคา</h2>
                    <form action="{{ route('products.index') }}" method="GET">
                        @if(request()->has('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @if(request()->has('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if(request()->has('platform'))
                            <input type="hidden" name="platform" value="{{ request('platform') }}">
                        @endif
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="min_price" class="block text-sm text-gray-600 mb-1">ต่ำสุด</label>
                                <input type="number" id="min_price" name="min_price" value="{{ request('min_price') }}" min="0" step="1" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label for="max_price" class="block text-sm text-gray-600 mb-1">สูงสุด</label>
                                <input type="number" id="max_price" name="max_price" value="{{ request('max_price') }}" min="0" step="1" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
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
                                <a href="{{ route('tag.show', ['tag' => $tag->slug, 'type' => 'products']) }}" 
                                   class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-sm">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Product Listing -->
            <div class="lg:w-3/4">
                <!-- Sort Controls -->
                <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="text-gray-600">
                            แสดงผล {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} จาก {{ $products->total() }} รายการ
                        </div>
                        
                        <form action="{{ route('products.index') }}" method="GET" class="flex items-center">
                            @if(request()->has('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            @if(request()->has('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            @if(request()->has('platform'))
                                <input type="hidden" name="platform" value="{{ request('platform') }}">
                            @endif
                            @if(request()->has('min_price'))
                                <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                            @endif
                            @if(request()->has('max_price'))
                                <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                            @endif
                            
                            <label for="sort" class="text-gray-700 mr-2">เรียงตาม:</label>
                            <select id="sort" name="sort" onchange="this.form.submit()" 
                                    class="border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="created_at" {{ request('sort') === 'created_at' || !request('sort') ? 'selected' : '' }}>ล่าสุด</option>
                                <option value="price" {{ request('sort') === 'price' ? 'selected' : '' }}>ราคา: ต่ำ-สูง</option>
                                <option value="price" {{ request('sort') === 'price' && request('direction') === 'desc' ? 'selected' : '' }}>ราคา: สูง-ต่ำ</option>
                                <option value="popularity" {{ request('sort') === 'popularity' ? 'selected' : '' }}>ความนิยม</option>
                                <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>ชื่อ: A-Z</option>
                            </select>
                            
                            @if(request('sort') === 'price' && request('direction') !== 'desc')
                                <input type="hidden" name="direction" value="asc">
                            @elseif(request('sort') === 'price' && request('direction') === 'desc')
                                <input type="hidden" name="direction" value="desc">
                            @else
                                <input type="hidden" name="direction" value="desc">
                            @endif
                        </form>
                    </div>
                </div>
                
                @if($products->isNotEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        @foreach($products as $product)
                            @include('components.product-card', ['product' => $product])
                        @endforeach
                    </div>
                    
                    {{ $products->links('components.pagination') }}
                @else
                    <div class="bg-gray-50 rounded-lg p-8 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">ไม่พบสินค้า</h3>
                        <p class="text-gray-600">กรุณาลองเปลี่ยนตัวกรอง หรือค้นหาด้วยคำอื่น</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection