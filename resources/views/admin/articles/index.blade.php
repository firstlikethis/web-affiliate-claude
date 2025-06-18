@extends('layouts.admin')

@section('title', 'จัดการบทความ')

@section('header_title', 'จัดการบทความ')

@section('content')
    <!-- Control Bar -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <a href="{{ route('admin.articles.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                เพิ่มบทความใหม่
            </a>
            
            <form action="{{ route('admin.articles.index') }}" method="GET" class="flex items-center">
                <div class="flex space-x-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="ค้นหาบทความ..." 
                           class="border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    
                    <select name="category" class="border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">ทุกหมวดหมู่</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    
                    <select name="status" class="border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">ทุกสถานะ</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>เผยแพร่</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>ร่าง</option>
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
    
    <!-- Articles Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">รายการบทความทั้งหมด</h2>
            <p class="text-sm text-gray-600">พบ {{ $articles->total() }} รายการ</p>
        </div>
        
        @if($articles->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-3 px-4 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">บทความ</th>
                            <th class="py-3 px-4 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">หมวดหมู่</th>
                            <th class="py-3 px-4 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ผู้เขียน</th>
                            <th class="py-3 px-4 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">จำนวนอ่าน</th>
                            <th class="py-3 px-4 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">สถานะ</th>
                            <th class="py-3 px-4 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">วันที่สร้าง</th>
                            <th class="py-3 px-4 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($articles as $article)
                            <tr>
                                <td class="py-3 px-4">
                                    <div class="flex items-center">
                                        <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="h-10 w-10 object-cover rounded">
                                        <div class="ml-4">
                                            <div class="font-medium text-gray-900 truncate max-w-xs">{{ $article->title }}</div>
                                            <div class="text-sm text-gray-500 truncate max-w-xs">{{ Str::limit(strip_tags($article->content), 30) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                        {{ $article->category->name }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">{{ $article->user->name }}</td>
                                <td class="py-3 px-4 font-medium">{{ $article->view_count }}</td>
                                <td class="py-3 px-4">
                                    @if($article->is_published)
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">เผยแพร่</span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">ร่าง</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-sm text-gray-500">{{ $article->created_at->format('d/m/Y') }}</td>
                                <td class="py-3 px-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.articles.show', $article) }}" class="text-blue-600 hover:text-blue-900" title="ดูรายละเอียด">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.articles.edit', $article) }}" class="text-yellow-600 hover:text-yellow-900" title="แก้ไข">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="inline" onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบบทความนี้?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="ลบ">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 border-t border-gray-200">
                {{ $articles->links('components.pagination') }}
            </div>
        @else
            <div class="p-6 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-600 mb-1">ไม่พบข้อมูลบทความ</h3>
                <p class="text-gray-500 mb-4">เริ่มเพิ่มบทความแรกของคุณตอนนี้</p>
                <a href="{{ route('admin.articles.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    เพิ่มบทความใหม่
                </a>
            </div>
        @endif
    </div>
@endsection