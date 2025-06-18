@extends('layouts.admin')

@section('title', 'รายละเอียดแท็ก')

@section('header_title', 'รายละเอียดแท็ก')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <a href="{{ route('admin.tags.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                กลับไปหน้ารายการแท็ก
            </a>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('tag.show', $tag->slug) }}" target="_blank" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                ดูหน้าเว็บ
            </a>
            <a href="{{ route('admin.tags.edit', $tag) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
                แก้ไขแท็ก
            </a>
            <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" class="inline-block" onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบแท็กนี้?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    ลบแท็ก
                </button>
            </form>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- รายละเอียดแท็ก -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">รายละเอียดแท็ก</h2>
                </div>
                
                <div class="p-6">
                    <div class="mb-6 flex items-center justify-center">
                        <div class="w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                    </div>
                    
                    <h1 class="text-xl font-bold text-gray-800 text-center mb-6">{{ $tag->name }}</h1>
                    
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-1">Slug:</h3>
                            <p class="text-gray-600">{{ $tag->slug }}</p>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-1">จำนวนสินค้า:</h3>
                            <p class="text-gray-600">{{ $tag->products->count() }} รายการ</p>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-1">จำนวนบทความ:</h3>
                            <p class="text-gray-600">{{ $tag->articles->count() }} รายการ</p>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-1">วันที่สร้าง:</h3>
                            <p class="text-gray-600">{{ $tag->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-1">วันที่อัพเดทล่าสุด:</h3>
                            <p class="text-gray-600">{{ $tag->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-1">URL:</h3>
                            <div class="flex items-center">
                                <input type="text" value="{{ route('tag.show', $tag->slug) }}" readonly
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-600 text-sm">
                                <button type="button" onclick="copyToClipboard('{{ route('tag.show', $tag->slug) }}')" 
                                        class="ml-2 px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                                    คัดลอก
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- แท็บ Products/Articles -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="border-b border-gray-200">
                    <ul class="flex flex-wrap -mb-px">
                        <li class="mr-2">
                            <button id="products-tab" class="inline-block py-4 px-4 text-sm font-medium text-center text-blue-600 border-b-2 border-blue-600 active">
                                สินค้า ({{ $tag->products->count() }})
                            </button>
                        </li>
                        <li class="mr-2">
                            <button id="articles-tab" class="inline-block py-4 px-4 text-sm font-medium text-center text-gray-500 hover:text-gray-600 hover:border-gray-300 border-b-2 border-transparent">
                                บทความ ({{ $tag->articles->count() }})
                            </button>
                        </li>
                    </ul>
                </div>
                
                <div class="p-6">
                    <!-- สินค้า -->
                    <div id="products-content">
                        @if($tag->products->isNotEmpty())
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr>
                                            <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">สินค้า</th>
                                            <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ราคา</th>
                                            <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">แพลตฟอร์ม</th>
                                            <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">การคลิก</th>
                                            <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tag->products as $product)
                                            <tr>
                                                <td class="py-2 px-4 border-b">
                                                    <div class="flex items-center">
                                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-10 w-10 object-cover rounded mr-3">
                                                        <div class="font-medium text-gray-800">{{ $product->name }}</div>
                                                    </div>
                                                </td>
                                                <td class="py-2 px-4 border-b">
                                                    @if($product->discount_price)
                                                        <span class="text-red-600 font-medium">฿{{ number_format($product->discount_price, 2) }}</span>
                                                        <span class="text-gray-500 line-through text-sm">฿{{ number_format($product->price, 2) }}</span>
                                                    @else
                                                        <span class="font-medium">฿{{ number_format($product->price, 2) }}</span>
                                                    @endif
                                                </td>
                                                <td class="py-2 px-4 border-b">
                                                    <span class="px-2 py-1 text-xs rounded-full {{ $product->platform === 'shopee' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ ucfirst($product->platform) }}
                                                    </span>
                                                </td>
                                                <td class="py-2 px-4 border-b font-medium">{{ $product->click_count }}</td>
                                                <td class="py-2 px-4 border-b">
                                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-800 mr-2">แก้ไข</a>
                                                    <a href="{{ route('admin.products.show', $product) }}" class="text-gray-600 hover:text-gray-800">ดู</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-600 mb-1">ยังไม่มีสินค้าที่ใช้แท็กนี้</h3>
                                <p class="text-gray-500 mb-4">เริ่มเพิ่มแท็กนี้ให้กับสินค้าเพื่อแสดงบนเว็บไซต์</p>
                                <a href="{{ route('admin.products.create') }}" class="text-blue-600 hover:text-blue-800 inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    เพิ่มสินค้าใหม่
                                </a>
                            </div>
                        @endif
                    </div>
                    
                    <!-- บทความ -->
                    <div id="articles-content" class="hidden">
                        @if($tag->articles->isNotEmpty())
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr>
                                            <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">บทความ</th>
                                            <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ผู้เขียน</th>
                                            <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">จำนวนอ่าน</th>
                                            <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">สถานะ</th>
                                            <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tag->articles as $article)
                                            <tr>
                                                <td class="py-2 px-4 border-b">
                                                    <div class="flex items-center">
                                                        <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="h-10 w-10 object-cover rounded mr-3">
                                                        <div class="font-medium text-gray-800">{{ $article->title }}</div>
                                                    </div>
                                                </td>
                                                <td class="py-2 px-4 border-b">{{ $article->user->name }}</td>
                                                <td class="py-2 px-4 border-b font-medium">{{ $article->view_count }}</td>
                                                <td class="py-2 px-4 border-b">
                                                    @if($article->is_published)
                                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">เผยแพร่</span>
                                                    @else
                                                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">ร่าง</span>
                                                    @endif
                                                </td>
                                                <td class="py-2 px-4 border-b">
                                                    <a href="{{ route('admin.articles.edit', $article) }}" class="text-blue-600 hover:text-blue-800 mr-2">แก้ไข</a>
                                                    <a href="{{ route('admin.articles.show', $article) }}" class="text-gray-600 hover:text-gray-800">ดู</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-600 mb-1">ยังไม่มีบทความที่ใช้แท็กนี้</h3>
                                <p class="text-gray-500 mb-4">เริ่มเพิ่มแท็กนี้ให้กับบทความเพื่อแสดงบนเว็บไซต์</p>
                                <a href="{{ route('admin.articles.create') }}" class="text-blue-600 hover:text-blue-800 inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    เพิ่มบทความใหม่
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function copyToClipboard(text) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
            
            alert('คัดลอกลิงก์เรียบร้อยแล้ว');
        }
        
        // แท็บสินค้า/บทความ
        const productsTab = document.getElementById('products-tab');
        const articlesTab = document.getElementById('articles-tab');
        const productsContent = document.getElementById('products-content');
        const articlesContent = document.getElementById('articles-content');
        
        productsTab.addEventListener('click', function() {
            productsTab.classList.add('text-blue-600', 'border-blue-600');
            productsTab.classList.remove('text-gray-500', 'hover:text-gray-600', 'hover:border-gray-300', 'border-transparent');
            
            articlesTab.classList.remove('text-blue-600', 'border-blue-600');
            articlesTab.classList.add('text-gray-500', 'hover:text-gray-600', 'hover:border-gray-300', 'border-transparent');
            
            productsContent.classList.remove('hidden');
            articlesContent.classList.add('hidden');
        });
        
        articlesTab.addEventListener('click', function() {
            articlesTab.classList.add('text-blue-600', 'border-blue-600');
            articlesTab.classList.remove('text-gray-500', 'hover:text-gray-600', 'hover:border-gray-300', 'border-transparent');
            
            productsTab.classList.remove('text-blue-600', 'border-blue-600');
            productsTab.classList.add('text-gray-500', 'hover:text-gray-600', 'hover:border-gray-300', 'border-transparent');
            
            articlesContent.classList.remove('hidden');
            productsContent.classList.add('hidden');
        });
    </script>
@endsection