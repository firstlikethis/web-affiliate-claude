@extends('layouts.admin')

@section('title', 'เพิ่มสินค้าใหม่')

@section('header_title', 'เพิ่มสินค้าใหม่')

@section('content')
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">ข้อมูลสินค้า</h2>
            <p class="text-sm text-gray-600">กรอกข้อมูลสินค้าที่ต้องการเพิ่ม</p>
        </div>
        
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- ชื่อสินค้า -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">ชื่อสินค้า <span class="text-red-600">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- หมวดหมู่ -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">หมวดหมู่ <span class="text-red-600">*</span></label>
                    <select id="category_id" name="category_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">เลือกหมวดหมู่</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- ราคาปกติ -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">ราคาปกติ <span class="text-red-600">*</span></label>
                    <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- ราคาส่วนลด -->
                <div>
                    <label for="discount_price" class="block text-sm font-medium text-gray-700 mb-1">ราคาส่วนลด (ถ้ามี)</label>
                    <input type="number" id="discount_price" name="discount_price" value="{{ old('discount_price') }}" step="0.01" min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- แพลตฟอร์ม -->
                <div>
                    <label for="platform" class="block text-sm font-medium text-gray-700 mb-1">แพลตฟอร์ม <span class="text-red-600">*</span></label>
                    <select id="platform" name="platform" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">เลือกแพลตฟอร์ม</option>
                        <option value="shopee" {{ old('platform') == 'shopee' ? 'selected' : '' }}>Shopee</option>
                        <option value="lazada" {{ old('platform') == 'lazada' ? 'selected' : '' }}>Lazada</option>
                    </select>
                </div>
                
                <!-- Affiliate URL -->
                <div>
                    <label for="affiliate_url" class="block text-sm font-medium text-gray-700 mb-1">Affiliate URL <span class="text-red-600">*</span></label>
                    <input type="url" id="affiliate_url" name="affiliate_url" value="{{ old('affiliate_url') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- รูปภาพสินค้า -->
                <div class="md:col-span-2">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">รูปภาพสินค้า <span class="text-red-600">*</span></label>
                    <input type="file" id="image" name="image" accept="image/*" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="mt-1 text-sm text-gray-500">ไฟล์ภาพขนาดไม่เกิน 2MB (แนะนำขนาด 800x800 พิกเซล)</p>
                </div>
                
                <!-- รายละเอียดสินค้า -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">รายละเอียดสินค้า <span class="text-red-600">*</span></label>
                    <textarea id="description" name="description" rows="4" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description') }}</textarea>
                </div>
                
                <!-- แท็ก -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">แท็ก</label>
                    <div class="border border-gray-300 rounded-md p-3 max-h-48 overflow-y-auto">
                        @foreach($tags as $tag)
                            <label class="inline-flex items-center mr-4 mb-2">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" 
                                       {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">{{ $tag->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                
                <!-- สถานะ -->
                <div class="md:col-span-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">แสดงเป็นสินค้าแนะนำ</span>
                    </label>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-md">
                    ยกเลิก
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                    บันทึกข้อมูล
                </button>
            </div>
        </form>
    </div>
@endsection