@extends('layouts.admin')

@section('title', 'เพิ่มหมวดหมู่ใหม่')

@section('header_title', 'เพิ่มหมวดหมู่ใหม่')

@section('content')
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">ข้อมูลหมวดหมู่</h2>
            <p class="text-sm text-gray-600">กรอกข้อมูลหมวดหมู่ที่ต้องการเพิ่ม</p>
        </div>
        
        <form action="{{ route('admin.categories.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- ชื่อหมวดหมู่ -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">ชื่อหมวดหมู่ <span class="text-red-600">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- ประเภท -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">ประเภท <span class="text-red-600">*</span></label>
                    <select id="type" name="type" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">เลือกประเภท</option>
                        <option value="product" {{ old('type') == 'product' ? 'selected' : '' }}>หมวดหมู่สินค้า</option>
                        <option value="article" {{ old('type') == 'article' ? 'selected' : '' }}>หมวดหมู่บทความ</option>
                    </select>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-md">
                    ยกเลิก
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                    บันทึกข้อมูล
                </button>
            </div>
        </form>
    </div>
    
    <!-- Preview Section -->
    <div class="mt-6">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">ตัวอย่างการแสดงผล</h2>
                <p class="text-sm text-gray-600">ตัวอย่างการแสดงผลหมวดหมู่บนหน้าเว็บไซต์</p>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- ตัวอย่างหมวดหมู่สินค้า -->
                    <div id="product-category-preview" class="hidden">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">ตัวอย่างหมวดหมู่สินค้า</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-800" id="product-category-name">ชื่อหมวดหมู่</div>
                                    <div class="text-sm text-gray-600">0 สินค้า</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- ตัวอย่างหมวดหมู่บทความ -->
                    <div id="article-category-preview" class="hidden">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">ตัวอย่างหมวดหมู่บทความ</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-800" id="article-category-name">ชื่อหมวดหมู่</div>
                                    <div class="text-sm text-gray-600">0 บทความ</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        // แสดงตัวอย่างตามประเภทที่เลือก
        const typeSelect = document.getElementById('type');
        const nameInput = document.getElementById('name');
        const productPreview = document.getElementById('product-category-preview');
        const articlePreview = document.getElementById('article-category-preview');
        const productNamePreview = document.getElementById('product-category-name');
        const articleNamePreview = document.getElementById('article-category-name');
        
        // อัพเดทตัวอย่างเมื่อเลือกประเภท
        typeSelect.addEventListener('change', updatePreview);
        
        // อัพเดทชื่อในตัวอย่างเมื่อพิมพ์
        nameInput.addEventListener('input', function() {
            productNamePreview.textContent = this.value || 'ชื่อหมวดหมู่';
            articleNamePreview.textContent = this.value || 'ชื่อหมวดหมู่';
        });
        
        // อัพเดทตัวอย่างเมื่อโหลดหน้า
        document.addEventListener('DOMContentLoaded', updatePreview);
        
        function updatePreview() {
            const selectedType = typeSelect.value;
            
            if (selectedType === 'product') {
                productPreview.classList.remove('hidden');
                articlePreview.classList.add('hidden');
            } else if (selectedType === 'article') {
                productPreview.classList.add('hidden');
                articlePreview.classList.remove('hidden');
            } else {
                productPreview.classList.add('hidden');
                articlePreview.classList.add('hidden');
            }
        }
    </script>
    @endpush
@endsection