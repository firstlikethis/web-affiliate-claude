@extends('layouts.admin')

@section('title', 'แก้ไขหมวดหมู่')

@section('header_title', 'แก้ไขหมวดหมู่')

@section('content')
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">แก้ไขข้อมูลหมวดหมู่</h2>
            <p class="text-sm text-gray-600">แก้ไขข้อมูลหมวดหมู่ ID: {{ $category->id }}</p>
        </div>
        
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- ชื่อหมวดหมู่ -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">ชื่อหมวดหมู่ <span class="text-red-600">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- ประเภท -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">ประเภท <span class="text-red-600">*</span></label>
                    <select id="type" name="type" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">เลือกประเภท</option>
                        <option value="product" {{ old('type', $category->type) == 'product' ? 'selected' : '' }}>หมวดหมู่สินค้า</option>
                        <option value="article" {{ old('type', $category->type) == 'article' ? 'selected' : '' }}>หมวดหมู่บทความ</option>
                    </select>
                </div>
                
                <!-- Slug (แสดงเท่านั้น) -->
                <div class="md:col-span-2">
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug (URL)</label>
                    <input type="text" id="slug" value="{{ $category->slug }}" readonly
                           class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-600">
                    <p class="mt-1 text-sm text-gray-500">Slug จะถูกสร้างโดยอัตโนมัติจากชื่อหมวดหมู่</p>
                </div>
                
                <!-- แจ้งเตือนกรณีที่หมวดหมู่มีการใช้งานอยู่ -->
                @if(($category->type === 'product' && $category->products->isNotEmpty()) || 
                    ($category->type === 'article' && $category->articles->isNotEmpty()))
                    <div class="md:col-span-2">
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        หมวดหมู่นี้มีการใช้งานอยู่ การเปลี่ยนประเภทอาจส่งผลต่อข้อมูลที่เกี่ยวข้อง
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-md">
                    ยกเลิก
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                    บันทึกการเปลี่ยนแปลง
                </button>
            </div>
        </form>
    </div>
    
    <!-- ข้อมูลเพิ่มเติม -->
    <div class="mt-6">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">ข้อมูลเพิ่มเติม</h2>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- สถิติการใช้งาน -->
                    <div>
                        <h3 class="text-md font-medium text-gray-800 mb-3">สถิติการใช้งาน</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            @if($category->type === 'product')
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-700">จำนวนสินค้าในหมวดหมู่:</span>
                                    <span class="font-medium">{{ $category->products->count() }} รายการ</span>
                                </div>
                            @else
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-700">จำนวนบทความในหมวดหมู่:</span>
                                    <span class="font-medium">{{ $category->articles->count() }} รายการ</span>
                                </div>
                            @endif
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700">วันที่สร้าง:</span>
                                <span class="font-medium">{{ $category->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- ดูหน้าเว็บไซต์ -->
                    <div>
                        <h3 class="text-md font-medium text-gray-800 mb-3">ลิงก์ไปยังหน้าเว็บไซต์</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-600 mb-3">คุณสามารถดูหมวดหมู่นี้บนหน้าเว็บไซต์ได้โดยคลิกที่ปุ่มด้านล่าง</p>
                            <a href="{{ route('category.show', $category->slug) }}" target="_blank" 
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md inline-block">
                                ดูหน้าเว็บไซต์
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection