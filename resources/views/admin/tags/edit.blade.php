@extends('layouts.admin')

@section('title', 'แก้ไขแท็ก')

@section('header_title', 'แก้ไขแท็ก')

@section('content')
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">แก้ไขข้อมูลแท็ก</h2>
            <p class="text-sm text-gray-600">แก้ไขข้อมูลแท็ก ID: {{ $tag->id }}</p>
        </div>
        
        <form action="{{ route('admin.tags.update', $tag) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <!-- ชื่อแท็ก -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">ชื่อแท็ก <span class="text-red-600">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $tag->name) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="mt-1 text-sm text-gray-500">ชื่อแท็กควรสั้น กระชับ และสื่อความหมาย</p>
                </div>
                
                <!-- Slug (แสดงเท่านั้น) -->
                <div class="mt-4">
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug (URL)</label>
                    <input type="text" id="slug" value="{{ $tag->slug }}" readonly
                           class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-600">
                    <p class="mt-1 text-sm text-gray-500">Slug จะถูกสร้างโดยอัตโนมัติจากชื่อแท็ก</p>
                </div>
                
                <!-- แจ้งเตือนกรณีที่แท็กมีการใช้งานอยู่ -->
                @if($tag->products_count > 0 || $tag->articles_count > 0)
                    <div class="mt-4">
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        แท็กนี้มีการใช้งานอยู่ ({{ $tag->products_count }} สินค้า, {{ $tag->articles_count }} บทความ)
                                        การเปลี่ยนชื่อแท็กจะมีผลกับรายการที่ใช้แท็กนี้ทั้งหมด
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.tags.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-md">
                    ยกเลิก
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                    บันทึกการเปลี่ยนแปลง
                </button>
            </div>
        </form>
    </div>
    
    <!-- ข้อมูลการใช้งาน -->
    <div class="mt-6">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">ข้อมูลการใช้งาน</h2>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- สถิติ -->
                    <div>
                        <h3 class="text-md font-medium text-gray-800 mb-3">สถิติ</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-700">จำนวนสินค้า:</span>
                                <span class="font-medium">{{ $tag->products_count }} รายการ</span>
                            </div>
                            
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-700">จำนวนบทความ:</span>
                                <span class="font-medium">{{ $tag->articles_count }} รายการ</span>
                            </div>
                            
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-700">จำนวนการใช้งานทั้งหมด:</span>
                                <span class="font-medium">{{ $tag->products_count + $tag->articles_count }} รายการ</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700">วันที่สร้าง:</span>
                                <span class="font-medium">{{ $tag->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- ลิงก์ -->
                    <div>
                        <h3 class="text-md font-medium text-gray-800 mb-3">ลิงก์</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="mb-3">
                                <p class="text-sm text-gray-600 mb-2">URL ของแท็ก:</p>
                                <div class="flex items-center">
                                    <input type="text" value="{{ route('tag.show', $tag->slug) }}" readonly
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-600 text-sm">
                                    <button type="button" onclick="copyToClipboard('{{ route('tag.show', $tag->slug) }}')" 
                                            class="ml-2 px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                                        คัดลอก
                                    </button>
                                </div>
                            </div>
                            
                            <div>
                                <a href="{{ route('tag.show', $tag->slug) }}" target="_blank" class="text-blue-600 hover:text-blue-800 inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                    ดูหน้าแท็กบนเว็บไซต์
                                </a>
                            </div>
                        </div>
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
    </script>
@endsection