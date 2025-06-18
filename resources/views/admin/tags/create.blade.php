@extends('layouts.admin')

@section('title', 'เพิ่มแท็กใหม่')

@section('header_title', 'เพิ่มแท็กใหม่')

@section('content')
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">ข้อมูลแท็ก</h2>
            <p class="text-sm text-gray-600">กรอกข้อมูลแท็กที่ต้องการเพิ่ม</p>
        </div>
        
        <form action="{{ route('admin.tags.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="mb-6">
                <!-- ชื่อแท็ก -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">ชื่อแท็ก <span class="text-red-600">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="mt-1 text-sm text-gray-500">ชื่อแท็กควรสั้น กระชับ และสื่อความหมาย</p>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.tags.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-md">
                    ยกเลิก
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                    บันทึกข้อมูล
                </button>
            </div>
        </form>
    </div>
    
    <!-- คำแนะนำ -->
    <div class="mt-6">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">คำแนะนำในการตั้งชื่อแท็ก</h2>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-md font-medium text-gray-800 mb-3">แนวทางการตั้งชื่อแท็กที่ดี</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <ul class="list-disc list-inside text-gray-700 space-y-2">
                                <li>ใช้คำที่สั้น กระชับ และเข้าใจง่าย</li>
                                <li>ใช้คำที่คนมักจะค้นหาเพื่อเพิ่มโอกาสในการถูกค้นพบ</li>
                                <li>หลีกเลี่ยงการใช้คำที่มีความหมายคล้ายกันหลายคำ</li>
                                <li>ใช้คำที่เกี่ยวข้องกับเนื้อหาโดยตรง</li>
                                <li>หลีกเลี่ยงการใช้อักขระพิเศษ ควรใช้เฉพาะตัวอักษรและตัวเลข</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-md font-medium text-gray-800 mb-3">ตัวอย่างแท็กที่ดี</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="mb-4">
                                <p class="font-medium text-gray-700 mb-2">สำหรับเว็บไซต์สินค้า:</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">ลดราคา</span>
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">สินค้าใหม่</span>
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">ของแท้</span>
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">โปรโมชั่น</span>
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">ส่งฟรี</span>
                                </div>
                            </div>
                            
                            <div>
                                <p class="font-medium text-gray-700 mb-2">สำหรับบทความ:</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">วิธีใช้</span>
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">รีวิว</span>
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">เคล็ดลับ</span>
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">เปรียบเทียบ</span>
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">แนะนำ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- ตัวอย่างการแสดงผล -->
    <div class="mt-6">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">ตัวอย่างการแสดงผล</h2>
                <p class="text-sm text-gray-600">ตัวอย่างการแสดงผลแท็กบนหน้าเว็บไซต์</p>
            </div>
            
            <div class="p-6">
                <div class="mb-4">
                    <h3 class="text-md font-medium text-gray-800 mb-3">แท็กในการ์ดสินค้า</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex justify-center">
                            <div class="w-64 bg-white rounded-lg shadow-md overflow-hidden">
                                <div class="h-40 bg-gray-200"></div>
                                <div class="p-4">
                                    <h4 class="font-medium text-gray-800 mb-2">ชื่อสินค้าตัวอย่าง</h4>
                                    <div class="flex items-center mb-3">
                                        <span class="text-lg font-bold text-red-600">฿1,990</span>
                                        <span class="ml-2 text-sm text-gray-500 line-through">฿2,590</span>
                                    </div>
                                    <div class="flex flex-wrap gap-1">
                                        <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">
                                            <span id="tag-preview">ชื่อแท็ก</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-md font-medium text-gray-800 mb-3">แท็กในหน้าแท็ก</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="text-center">
                            <h4 class="text-xl font-bold text-gray-800 mb-3">แท็ก: <span id="tag-title-preview">ชื่อแท็ก</span></h4>
                            <p class="text-gray-600 mb-3">พบ 0 สินค้า และ 0 บทความ</p>
                            <div class="inline-flex space-x-2">
                                <span class="px-4 py-1 rounded-full bg-blue-600 text-white">ทั้งหมด</span>
                                <span class="px-4 py-1 rounded-full bg-gray-100 text-gray-800 hover:bg-gray-200">สินค้า</span>
                                <span class="px-4 py-1 rounded-full bg-gray-100 text-gray-800 hover:bg-gray-200">บทความ</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        // อัพเดทตัวอย่างเมื่อพิมพ์ชื่อแท็ก
        const nameInput = document.getElementById('name');
        const tagPreview = document.getElementById('tag-preview');
        const tagTitlePreview = document.getElementById('tag-title-preview');
        
        nameInput.addEventListener('input', function() {
            const value = this.value || 'ชื่อแท็ก';
            tagPreview.textContent = value;
            tagTitlePreview.textContent = value;
        });
    </script>
    @endpush
@endsection