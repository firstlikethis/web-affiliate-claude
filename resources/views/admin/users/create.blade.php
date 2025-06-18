@extends('layouts.admin')

@section('title', 'เพิ่มผู้ใช้ใหม่')

@section('header_title', 'เพิ่มผู้ใช้ใหม่')

@section('content')
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">ข้อมูลผู้ใช้</h2>
            <p class="text-sm text-gray-600">กรอกข้อมูลผู้ใช้ที่ต้องการเพิ่ม</p>
        </div>
        
        <form action="{{ route('admin.users.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- ชื่อผู้ใช้ -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">ชื่อผู้ใช้ <span class="text-red-600">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- อีเมล -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">อีเมล <span class="text-red-600">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- รหัสผ่าน -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">รหัสผ่าน <span class="text-red-600">*</span></label>
                    <input type="password" id="password" name="password" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="mt-1 text-sm text-gray-500">ต้องมีความยาวอย่างน้อย 8 ตัวอักษร</p>
                </div>
                
                <!-- ยืนยันรหัสผ่าน -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">ยืนยันรหัสผ่าน <span class="text-red-600">*</span></label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- บทบาท -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-3">บทบาท <span class="text-red-600">*</span></label>
                    <div class="flex space-x-6">
                        <div class="flex items-center">
                            <input type="radio" id="role_admin" name="role" value="admin" {{ old('role') === 'admin' ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <label for="role_admin" class="ml-2 text-sm font-medium text-gray-700">
                                ผู้ดูแลระบบ <span class="text-xs text-gray-500">(สามารถจัดการทุกส่วนของระบบได้)</span>
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="role_editor" name="role" value="editor" {{ old('role', 'editor') === 'editor' ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <label for="role_editor" class="ml-2 text-sm font-medium text-gray-700">
                                ผู้เขียนบทความ <span class="text-xs text-gray-500">(สามารถจัดการเฉพาะบทความของตนเองได้)</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-md">
                    ยกเลิก
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                    บันทึกข้อมูล
                </button>
            </div>
        </form>
    </div>
    
    <!-- คำแนะนำเพิ่มเติม -->
    <div class="mt-6">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">คำแนะนำเพิ่มเติม</h2>
            </div>
            
            <div class="p-6">
                <h3 class="text-md font-medium text-gray-800 mb-3">บทบาทในระบบ</h3>
                <div class="mb-6 space-y-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-medium text-gray-800 mb-2">ผู้ดูแลระบบ (Admin)</h4>
                        <ul class="list-disc list-inside text-gray-700 space-y-1">
                            <li>สามารถจัดการทุกส่วนของระบบได้</li>
                            <li>สามารถจัดการผู้ใช้งานทั้งหมด</li>
                            <li>สามารถจัดการสินค้า บทความ หมวดหมู่ และแท็กได้</li>
                            <li>สามารถดูข้อมูลสถิติและรายงานต่างๆ ได้</li>
                        </ul>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-medium text-gray-800 mb-2">ผู้เขียนบทความ (Editor)</h4>
                        <ul class="list-disc list-inside text-gray-700 space-y-1">
                            <li>สามารถจัดการบทความของตนเองได้</li>
                            <li>สามารถดูข้อมูลสินค้า หมวดหมู่ และแท็กได้</li>
                            <li>ไม่สามารถจัดการผู้ใช้งานอื่นได้</li>
                            <li>ไม่สามารถดูข้อมูลสถิติและรายงานต่างๆ ได้</li>
                        </ul>
                    </div>
                </div>
                
                <h3 class="text-md font-medium text-gray-800 mb-3">ข้อแนะนำในการตั้งรหัสผ่าน</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <ul class="list-disc list-inside text-gray-700 space-y-1">
                        <li>ควรมีความยาวอย่างน้อย 8 ตัวอักษร</li>
                        <li>ควรประกอบด้วยตัวอักษรพิมพ์ใหญ่ ตัวอักษรพิมพ์เล็ก ตัวเลข และอักขระพิเศษ</li>
                        <li>ไม่ควรใช้ข้อมูลส่วนตัวที่คาดเดาง่าย เช่น ชื่อ วันเกิด เป็นรหัสผ่าน</li>
                        <li>ไม่ควรใช้รหัสผ่านเดียวกับบัญชีอื่นๆ</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection