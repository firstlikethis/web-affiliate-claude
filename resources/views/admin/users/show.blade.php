@extends('layouts.admin')

@section('title', 'รายละเอียดผู้ใช้')

@section('header_title', 'รายละเอียดผู้ใช้')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                กลับไปหน้ารายการผู้ใช้
            </a>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.users.edit', $user) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
                แก้ไขผู้ใช้
            </a>
            
            @if(Auth::id() !== $user->id)
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบผู้ใช้นี้?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        ลบผู้ใช้
                    </button>
                </form>
            @endif
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- รายละเอียดผู้ใช้ -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">รายละเอียดผู้ใช้</h2>
                </div>
                
                <div class="p-6">
                    <div class="mb-6 flex items-center justify-center">
                        <div class="w-24 h-24 rounded-full bg-blue-500 flex items-center justify-center text-white text-3xl font-bold">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    </div>
                    
                    <h1 class="text-xl font-bold text-gray-800 text-center mb-6">{{ $user->name }}</h1>
                    
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-1">อีเมล:</h3>
                            <p class="text-gray-600">{{ $user->email }}</p>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-1">บทบาท:</h3>
                            @if($user->role === 'admin')
                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">ผู้ดูแลระบบ</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">ผู้เขียนบทความ</span>
                            @endif
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-1">วันที่สร้าง:</h3>
                            <p class="text-gray-600">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-1">วันที่อัพเดทล่าสุด:</h3>
                            <p class="text-gray-600">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-1">จำนวนบทความ:</h3>
                            <p class="text-gray-600">{{ $user->articles->count() }} รายการ</p>
                        </div>
                    </div>
                    
                    @if(Auth::id() === $user->id)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex justify-center">
                                <span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                    นี่คือบัญชีของคุณ
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- บทความของผู้ใช้ -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">บทความของผู้ใช้</h2>
                </div>
                
                <div class="p-6">
                    @if($user->articles->isNotEmpty())
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">บทความ</th>
                                        <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">หมวดหมู่</th>
                                        <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">จำนวนอ่าน</th>
                                        <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">สถานะ</th>
                                        <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">วันที่สร้าง</th>
                                        <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->articles as $article)
                                        <tr>
                                            <td class="py-2 px-4 border-b">
                                                <div class="flex items-center">
                                                    <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="h-10 w-10 object-cover rounded mr-3">
                                                    <div class="font-medium text-gray-800">{{ $article->title }}</div>
                                                </div>
                                            </td>
                                            <td class="py-2 px-4 border-b">{{ $article->category->name }}</td>
                                            <td class="py-2 px-4 border-b font-medium">{{ $article->view_count }}</td>
                                            <td class="py-2 px-4 border-b">
                                                @if($article->is_published)
                                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">เผยแพร่</span>
                                                @else
                                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">ร่าง</span>
                                                @endif
                                            </td>
                                            <td class="py-2 px-4 border-b text-sm text-gray-500">{{ $article->created_at->format('d/m/Y') }}</td>
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
                            <h3 class="text-lg font-semibold text-gray-600 mb-1">ยังไม่มีบทความ</h3>
                            <p class="text-gray-500 mb-4">ผู้ใช้นี้ยังไม่ได้สร้างบทความใดๆ</p>
                            <a href="{{ route('admin.articles.create') }}" class="text-blue-600 hover:text-blue-800 inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                สร้างบทความใหม่
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection