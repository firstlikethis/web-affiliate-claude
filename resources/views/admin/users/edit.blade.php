@extends('layouts.admin')

@section('title', 'แก้ไขผู้ใช้')

@section('header_title', 'แก้ไขผู้ใช้')

@section('content')
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">แก้ไขข้อมูลผู้ใช้</h2>
            <p class="text-sm text-gray-600">แก้ไขข้อมูลผู้ใช้ ID: {{ $user->id }}</p>
        </div>
        
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- ชื่อผู้ใช้ -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">ชื่อผู้ใช้ <span class="text-red-600">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- อีเมล -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">อีเมล <span class="text-red-600">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- รหัสผ่าน (เปลี่ยนเฉพาะเมื่อต้องการ) -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">รหัสผ่านใหม่ <span class="text-gray-500">(ไม่ต้องกรอกถ้าไม่ต้องการเปลี่ยน)</span></label>
                    <input type="password" id="password" name="password"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="mt-1 text-sm text-gray-500">ต้องมีความยาวอย่างน้อย 8 ตัวอักษร</p>
                </div>
                
                <!-- ยืนยันรหัสผ่าน -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">ยืนยันรหัสผ่านใหม่</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- บทบาท -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-3">บทบาท <span class="text-red-600">*</span></label>
                    <div class="flex space-x-6">
                        <div class="flex items-center">
                            <input type="radio" id="role_admin" name="role" value="admin" {{ old('role', $user->role) === 'admin' ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <label for="role_admin" class="ml-2 text-sm font-medium text-gray-700">
                                ผู้ดูแลระบบ <span class="text-xs text-gray-500">(สามารถจัดการทุกส่วนของระบบได้)</span>
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="role_editor" name="role" value="editor" {{ old('role', $user->role) === 'editor' ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <label for="role_editor" class="ml-2 text-sm font-medium text-gray-700">
                                ผู้เขียนบทความ <span class="text-xs text-gray-500">(สามารถจัดการเฉพาะบทความของตนเองได้)</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- แจ้งเตือนในกรณีที่กำลังแก้ไขบัญชีตนเอง -->
                @if(Auth::id() === $user->id)
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
                                        คุณกำลังแก้ไขบัญชีของคุณเอง หากเปลี่ยนบทบาทจาก "ผู้ดูแลระบบ" เป็น "ผู้เขียนบทความ" คุณจะไม่สามารถเข้าถึงหน้าจัดการผู้ใช้ได้อีกต่อไป
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-md">
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
                    <!-- ข้อมูลทั่วไป -->
                    <div>
                        <h3 class="text-md font-medium text-gray-800 mb-3">ข้อมูลทั่วไป</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-700">สถานะ:</span>
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">ปกติ</span>
                            </div>
                            
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-700">วันที่สร้าง:</span>
                                <span class="font-medium">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-700">วันที่อัพเดทล่าสุด:</span>
                                <span class="font-medium">{{ $user->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700">จำนวนบทความ:</span>
                                <span class="font-medium">{{ $user->articles->count() }} รายการ</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- คำแนะนำ -->
                    <div>
                        <h3 class="text-md font-medium text-gray-800 mb-3">คำแนะนำ</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <ul class="list-disc list-inside text-gray-700 space-y-1">
                                <li>การเปลี่ยนอีเมลจะต้องใช้อีเมลที่ไม่ซ้ำกับผู้ใช้อื่น</li>
                                <li>หากไม่ต้องการเปลี่ยนรหัสผ่าน ให้เว้นช่องรหัสผ่านไว้</li>
                                <li>ไม่แนะนำให้มีผู้ดูแลระบบน้อยกว่า 2 คน เพื่อป้องกันการสูญเสียการเข้าถึง</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection