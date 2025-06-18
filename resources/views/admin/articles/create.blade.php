@extends('layouts.admin')

@section('title', 'เพิ่มบทความใหม่')

@section('header_title', 'เพิ่มบทความใหม่')

@section('content')
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">ข้อมูลบทความ</h2>
            <p class="text-sm text-gray-600">กรอกข้อมูลบทความที่ต้องการเพิ่ม</p>
        </div>
        
        <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- ชื่อบทความ -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">ชื่อบทความ <span class="text-red-600">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
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
                
                <!-- รูปภาพปก -->
                <div class="md:col-span-2">
                    <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-1">รูปภาพปก <span class="text-red-600">*</span></label>
                    <input type="file" id="thumbnail" name="thumbnail" accept="image/*" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="mt-1 text-sm text-gray-500">ไฟล์ภาพขนาดไม่เกิน 2MB (แนะนำขนาด 1200x800 พิกเซล)</p>
                </div>
                
                <!-- เนื้อหาบทความ -->
                <div class="md:col-span-2">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">เนื้อหาบทความ <span class="text-red-600">*</span></label>
                    <textarea id="content" name="content" rows="12" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('content') }}</textarea>
                    
                    <div class="mt-2 flex space-x-2">
                        <button type="button" onclick="insertProductLink()" class="px-3 py-1 bg-green-600 text-white rounded-md text-sm hover:bg-green-700">
                            แทรกลิงก์สินค้า
                        </button>
                        <button type="button" onclick="insertImage()" class="px-3 py-1 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                            แทรกรูปภาพ
                        </button>
                        <button type="button" onclick="insertHeading()" class="px-3 py-1 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
                            แทรกหัวข้อ
                        </button>
                    </div>
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
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', '1') ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">เผยแพร่บทความนี้</span>
                    </label>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.articles.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-md">
                    ยกเลิก
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                    บันทึกข้อมูล
                </button>
            </div>
        </form>
    </div>
    
    <!-- Modal: แทรกลิงก์สินค้า -->
    <div id="productLinkModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
            <div class="p-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">แทรกลิงก์สินค้า</h3>
            </div>
            <div class="p-4">
                <div class="mb-4">
                    <label for="product_search" class="block text-sm font-medium text-gray-700 mb-1">ค้นหาสินค้า</label>
                    <input type="text" id="product_search" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div class="max-h-60 overflow-y-auto mb-4" id="product_results">
                    <!-- ผลลัพธ์การค้นหาจะถูกแสดงที่นี่ -->
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeProductLinkModal()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-md">
                        ยกเลิก
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        // แทรกลิงก์สินค้า
        function insertProductLink() {
            document.getElementById('productLinkModal').classList.remove('hidden');
            
            // ล้างผลลัพธ์การค้นหาเดิม
            document.getElementById('product_results').innerHTML = '';
            
            // รีเซ็ตช่องค้นหา
            document.getElementById('product_search').value = '';
            
            // เพิ่ม event listener สำหรับการค้นหา
            document.getElementById('product_search').addEventListener('input', function() {
                const query = this.value.trim();
                if (query.length >= 2) {
                    // ส่ง Ajax request เพื่อค้นหาสินค้า
                    fetch(`/admin/products/search?q=${query}`)
                        .then(response => response.json())
                        .then(data => {
                            const resultsContainer = document.getElementById('product_results');
                            resultsContainer.innerHTML = '';
                            
                            if (data.length === 0) {
                                resultsContainer.innerHTML = '<p class="text-gray-500 text-center py-4">ไม่พบสินค้าที่ตรงกับคำค้นหา</p>';
                                return;
                            }
                            
                            data.forEach(product => {
                                const productElement = document.createElement('div');
                                productElement.className = 'flex items-center border-b border-gray-200 py-2 hover:bg-gray-50 cursor-pointer';
                                productElement.innerHTML = `
                                    <img src="/storage/${product.image}" alt="${product.name}" class="h-10 w-10 object-cover rounded mr-3">
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-800">${product.name}</div>
                                        <div class="text-sm text-gray-600">฿${product.price}</div>
                                    </div>
                                `;
                                
                                productElement.addEventListener('click', function() {
                                    // แทรกลิงก์สินค้าในเนื้อหา
                                    const productLink = `<a href="/go/${product.slug}" class="text-blue-600 font-medium">${product.name}</a>`;
                                    insertAtCursor(document.getElementById('content'), productLink);
                                    closeProductLinkModal();
                                });
                                
                                resultsContainer.appendChild(productElement);
                            });
                        });
                }
            });
        }
        
        function closeProductLinkModal() {
            document.getElementById('productLinkModal').classList.add('hidden');
        }
        
        // แทรกรูปภาพ
        function insertImage() {
            const imageUrl = prompt('ใส่ URL ของรูปภาพ:');
            if (imageUrl && imageUrl.trim() !== '') {
                const imageTag = `<img src="${imageUrl}" alt="รูปภาพประกอบ" class="my-4 rounded-lg max-w-full">`;
                insertAtCursor(document.getElementById('content'), imageTag);
            }
        }
        
        // แทรกหัวข้อ
        function insertHeading() {
            const headingText = prompt('ใส่ข้อความสำหรับหัวข้อ:');
            if (headingText && headingText.trim() !== '') {
                const headingTag = `\n<h2 class="text-xl font-bold my-4">${headingText}</h2>\n`;
                insertAtCursor(document.getElementById('content'), headingTag);
            }
        }
        
        // แทรกข้อความที่ตำแหน่ง cursor
        function insertAtCursor(textarea, text) {
            const startPos = textarea.selectionStart;
            const endPos = textarea.selectionEnd;
            const scrollTop = textarea.scrollTop;
            
            textarea.value = textarea.value.substring(0, startPos) + text + textarea.value.substring(endPos, textarea.value.length);
            
            textarea.focus();
            textarea.selectionStart = startPos + text.length;
            textarea.selectionEnd = startPos + text.length;
            textarea.scrollTop = scrollTop;
        }
        
        // ปิด Modal เมื่อคลิกที่พื้นหลัง
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('productLinkModal');
            if (event.target === modal) {
                closeProductLinkModal();
            }
        });
    </script>
    @endpush
@endsection