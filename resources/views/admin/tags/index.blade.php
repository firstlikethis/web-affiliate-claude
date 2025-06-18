@extends('layouts.admin')

@section('title', 'จัดการแท็ก')

@section('header_title', 'จัดการแท็ก')

@section('content')
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">จัดการแท็ก</h2>
        </div>
        
        <div class="p-6">
            <form action="{{ route('admin.tags.store') }}" method="POST" class="mb-6">
                @csrf
                
                <div class="flex space-x-2">
                    <input type="text" name="name" placeholder="ชื่อแท็กใหม่" required
                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">เพิ่มแท็ก</button>
                </div>
            </form>
            
            <!-- ค้นหาและกรอง -->
            <div class="mb-6">
                <form action="{{ route('admin.tags.index') }}" method="GET">
                    <div class="flex space-x-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="ค้นหาแท็ก..." 
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-md">ค้นหา</button>
                    </div>
                </form>
            </div>
            
            @if($tags->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-3 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">แท็ก</th>
                                <th class="py-3 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Slug</th>
                                <th class="py-3 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">จำนวนสินค้า</th>
                                <th class="py-3 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">จำนวนบทความ</th>
                                <th class="py-3 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">วันที่สร้าง</th>
                                <th class="py-3 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">การจัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($tags as $tag)
                                <tr>
                                    <td class="py-3 px-4">
                                        <form id="edit-tag-{{ $tag->id }}" action="{{ route('admin.tags.update', $tag) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('PUT')
                                            <input type="text" name="name" value="{{ $tag->name }}" required
                                                   class="w-full px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        </form>
                                        <span class="edit-tag-name" data-id="{{ $tag->id }}">{{ $tag->name }}</span>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-600">{{ $tag->slug }}</td>
                                    <td class="py-3 px-4">{{ $tag->products_count }}</td>
                                    <td class="py-3 px-4">{{ $tag->articles_count }}</td>
                                    <td class="py-3 px-4 text-sm text-gray-500">{{ $tag->created_at->format('d/m/Y') }}</td>
                                    <td class="py-3 px-4">
                                        <div class="flex space-x-2">
                                            <button type="button" class="text-yellow-600 hover:text-yellow-900 toggle-edit-tag" data-id="{{ $tag->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </button>
                                            <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" class="inline" onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบแท็กนี้?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
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
                
                <div class="mt-4">
                    {{ $tags->links('components.pagination') }}
                </div>
            @else
                <div class="text-center py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-600 mb-1">ไม่พบข้อมูลแท็ก</h3>
                    <p class="text-gray-500 mb-4">เริ่มเพิ่มแท็กแรกของคุณตอนนี้</p>
                </div>
            @endif
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleEditButtons = document.querySelectorAll('.toggle-edit-tag');
            
            toggleEditButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const nameElement = document.querySelector(`.edit-tag-name[data-id="${id}"]`);
                    const formElement = document.getElementById(`edit-tag-${id}`);
                    
                    if (nameElement.style.display !== 'none') {
                        // Switch to edit mode
                        nameElement.style.display = 'none';
                        formElement.style.display = 'block';
                        formElement.querySelector('input').focus();
                    } else {
                        // Submit the form
                        formElement.submit();
                    }
                });
            });
        });
    </script>
    @endpush
@endsection