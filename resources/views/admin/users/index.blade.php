@extends('layouts.admin')

@section('title', 'จัดการผู้ใช้')

@section('header_title', 'จัดการผู้ใช้')

@section('content')
    <!-- Control Bar -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                เพิ่มผู้ใช้ใหม่
            </a>
            
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex items-center">
                <div class="flex space-x-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="ค้นหาผู้ใช้..." 
                           class="border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    
                    <select name="role" class="border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">ทุกบทบาท</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>ผู้ดูแลระบบ</option>
                        <option value="editor" {{ request('role') == 'editor' ? 'selected' : '' }}>ผู้เขียนบทความ</option>
                    </select>
                    
                    <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-1 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">รายการผู้ใช้ทั้งหมด</h2>
            <p class="text-sm text-gray-600">พบ {{ $users->total() }} รายการ</p>
        </div>
        
        @if($users->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-3 px-4 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ชื่อ</th>
                            <th class="py-3 px-4 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">อีเมล</th>
                            <th class="py-3 px-4 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">บทบาท</th>
                            <th class="py-3 px-4 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">จำนวนบทความ</th>
                            <th class="py-3 px-4 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">วันที่สร้าง</th>
                            <th class="py-3 px-4 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($users as $user)
                            <tr>
                                <td class="py-3 px-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white mr-3">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-sm text-gray-600">{{ $user->email }}</td>
                                <td class="py-3 px-4">
                                    @if($user->role === 'admin')
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">ผู้ดูแลระบบ</span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">ผู้เขียนบทความ</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center">{{ $user->articles_count }}</td>
                                <td class="py-3 px-4 text-sm text-gray-500">{{ $user->created_at->format('d/m/Y') }}</td>
                                <td class="py-3 px-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-900" title="ดูรายละเอียด">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="text-yellow-600 hover:text-yellow-900" title="แก้ไข">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                        
                                        @if(Auth::id() !== $user->id)
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบผู้ใช้นี้?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="ลบ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 border-t border-gray-200">
                {{ $users->links('components.pagination') }}
            </div>
        @else
            <div class="p-6 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-600 mb-1">ไม่พบข้อมูลผู้ใช้</h3>
                <p class="text-gray-500 mb-4">เริ่มเพิ่มผู้ใช้ใหม่ตอนนี้</p>
                <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    เพิ่มผู้ใช้ใหม่
                </a>
            </div>
        @endif
    </div>
@endsection