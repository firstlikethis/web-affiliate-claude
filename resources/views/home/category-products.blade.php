@extends('layouts.app')

@section('title', $category->name)

@section('meta_description', 'สินค้าในหมวดหมู่ ' . $category->name)

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">หมวดหมู่: {{ $category->name }}</h1>
            <div class="mt-2 text-gray-600">
                พบ {{ $products->total() }} สินค้า
            </div>
        </div>
        
        @if($products->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
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
                <h3 class="text-lg font-semibold text-gray-700 mb-2">ไม่พบสินค้าในหมวดหมู่นี้</h3>
                <p class="text-gray-600">กรุณาลองค้นหาในหมวดหมู่อื่น หรือกลับมาตรวจสอบอีกครั้งในภายหลัง</p>
                <div class="mt-6">
                    <a href="{{ route('products.index') }}" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                        ดูสินค้าทั้งหมด
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection