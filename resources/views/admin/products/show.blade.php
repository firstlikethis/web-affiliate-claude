@extends('layouts.admin')

@section('title', 'รายละเอียดสินค้า')

@section('header_title', 'รายละเอียดสินค้า')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                กลับไปหน้ารายการสินค้า
            </a>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.products.edit', $product) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
                แก้ไขสินค้า
            </a>
            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบสินค้านี้?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    ลบสินค้า
                </button>
            </form>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- รายละเอียดสินค้า -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">รายละเอียดสินค้า</h2>
                </div>
                
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:space-x-6">
                        <div class="md:w-1/3 mb-6 md:mb-0">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-auto rounded-lg">
                        </div>
                        
                        <div class="md:w-2/3">
                            <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $product->name }}</h1>
                            
                            <div class="flex items-center mb-4">
                                <span class="px-2 py-1 text-xs rounded-full {{ $product->platform === 'shopee' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800' }} mr-2">
                                    {{ ucfirst($product->platform) }}
                                </span>
                                
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 mr-2">
                                    {{ $product->category->name }}
                                </span>
                                
                                @if($product->is_featured)
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                        แนะนำ
                                    </span>
                                @endif
                            </div>
                            
                            <div class="mb-4">
                                @if($product->discount_price)
                                    <div class="text-2xl font-bold text-red-600">฿{{ number_format($product->discount_price, 2) }}</div>
                                    <div class="text-gray-500 line-through">฿{{ number_format($product->price, 2) }}</div>
                                    <div class="text-sm text-green-600">
                                        ส่วนลด {{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%
                                    </div>
                                @else
                                    <div class="text-2xl font-bold text-gray-800">฿{{ number_format($product->price, 2) }}</div>
                                @endif
                            </div>
                            
                            <div class="mb-4">
                                <h3 class="text-sm font-medium text-gray-700 mb-1">ลิงก์ Affiliate:</h3>
                                <div class="flex items-center">
                                    <input type="text" value="{{ $product->affiliate_url }}" readonly
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-600">
                                    <button type="button" onclick="copyToClipboard('{{ $product->affiliate_url }}')" 
                                            class="ml-2 px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                        คัดลอก
                                    </button>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h3 class="text-sm font-medium text-gray-700 mb-1">URL ภายใน:</h3>
                                <div class="flex items-center">
                                    <input type="text" value="{{ route('redirect.affiliate', ['product' => $product->slug]) }}" readonly
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-600">
                                    <button type="button" onclick="copyToClipboard('{{ route('redirect.affiliate', ['product' => $product->slug]) }}')" 
                                            class="ml-2 px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                        คัดลอก
                                    </button>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h3 class="text-sm font-medium text-gray-700 mb-1">แท็ก:</h3>
                                <div class="flex flex-wrap gap-2">
                                    @forelse($product->tags as $tag)
                                        <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-800">
                                            {{ $tag->name }}
                                        </span>
                                    @empty
                                        <span class="text-gray-500">ไม่มีแท็ก</span>
                                    @endforelse
                                </div>
                            </div>
                            
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-1">วันที่สร้าง:</h3>
                                <p class="text-gray-600">{{ $product->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-gray-800 mb-3">รายละเอียดสินค้า</h3>
                        <div class="prose max-w-none">
                            <p>{{ $product->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- สถิติและข้อมูลการคลิก -->
        <div>
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">สถิติ</h2>
                </div>
                
                <div class="p-6">
                    <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg mb-4">
                        <div class="text-sm text-gray-700">จำนวนการคลิกทั้งหมด</div>
                        <div class="text-xl font-bold text-blue-600">{{ $product->click_count }}</div>
                    </div>
                    
                    <a href="{{ route('redirect.affiliate', ['product' => $product->slug]) }}" target="_blank" 
                       class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center px-4 py-2 rounded-md">
                        ทดสอบการคลิก
                    </a>
                </div>
            </div>
            
            @if($product->clickLogs->isNotEmpty())
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800">ประวัติการคลิกล่าสุด</h2>
                    </div>
                    
                    <div class="p-4">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-3 text-left text-xs font-semibold text-gray-600">วันที่</th>
                                        <th class="py-2 px-3 text-left text-xs font-semibold text-gray-600">IP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product->clickLogs->take(10) as $log)
                                        <tr>
                                            <td class="py-2 px-3 text-sm text-gray-800">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="py-2 px-3 text-sm text-gray-800">{{ $log->ip_address }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
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