@extends('layouts.admin')

@section('title', 'Dashboard')

@section('header_title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- สรุปสินค้า -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">สินค้าทั้งหมด</h3>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalProducts }}</p>
                </div>
            </div>
        </div>
        
        <!-- สรุปบทความ -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">บทความทั้งหมด</h3>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalArticles }}</p>
                </div>
            </div>
        </div>
        
        <!-- สรุปการคลิก -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">การคลิกทั้งหมด</h3>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalClicks }}</p>
                </div>
            </div>
        </div>
        
        <!-- สรุปรายได้ (ประมาณการ) -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">รายได้โดยประมาณ</h3>
                    <p class="text-3xl font-bold text-gray-800">฿{{ number_format($totalClicks * 2.5, 2) }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- สินค้ายอดนิยม -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">สินค้ายอดนิยม</h3>
            
            @if($popularProducts->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">สินค้า</th>
                                <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ราคา</th>
                                <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">การคลิก</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($popularProducts as $product)
                                <tr>
                                    <td class="py-2 px-4 border-b">
                                        <div class="flex items-center">
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-10 w-10 object-cover rounded">
                                            <div class="ml-4">
                                                <a href="{{ route('admin.products.show', $product) }}" class="font-medium text-blue-600 hover:text-blue-800 truncate max-w-xs">
                                                    {{ $product->name }}
                                                </a>
                                                <div class="text-sm text-gray-500">{{ $product->platform }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        @if($product->discount_price)
                                            <span class="text-red-600 font-medium">฿{{ number_format($product->discount_price, 2) }}</span>
                                            <span class="text-gray-500 line-through text-sm">฿{{ number_format($product->price, 2) }}</span>
                                        @else
                                            <span class="font-medium">฿{{ number_format($product->price, 2) }}</span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-4 border-b font-medium">{{ $product->click_count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500">ยังไม่มีข้อมูล</p>
            @endif
        </div>
        
        <!-- บทความยอดนิยม -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">บทความยอดนิยม</h3>
            
            @if($popularArticles->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">บทความ</th>
                                <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ผู้เขียน</th>
                                <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">จำนวนอ่าน</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($popularArticles as $article)
                                <tr>
                                    <td class="py-2 px-4 border-b">
                                        <div class="flex items-center">
                                            <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="h-10 w-10 object-cover rounded">
                                            <div class="ml-4">
                                                <a href="{{ route('admin.articles.show', $article) }}" class="font-medium text-blue-600 hover:text-blue-800 truncate max-w-xs">
                                                    {{ $article->title }}
                                                </a>
                                                <div class="text-sm text-gray-500">{{ $article->category->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b">{{ $article->user->name }}</td>
                                    <td class="py-2 px-4 border-b font-medium">{{ $article->view_count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500">ยังไม่มีข้อมูล</p>
            @endif
        </div>
    </div>
    
    <!-- สถิติการคลิก -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">สถิติการคลิกในรอบ 7 วัน</h3>
        
        @if($clickStats->isNotEmpty())
            <div class="w-full h-64">
                <canvas id="clickStatsChart"></canvas>
            </div>
            
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const ctx = document.getElementById('clickStatsChart').getContext('2d');
                    
                    const clickStats = @json($clickStats);
                    const labels = clickStats.map(stat => stat.date);
                    const data = clickStats.map(stat => stat.count);
                    
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'จำนวนการคลิก',
                                data: data,
                                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                                borderColor: 'rgba(59, 130, 246, 1)',
                                borderWidth: 2,
                                tension: 0.3,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    }
                                }
                            }
                        }
                    });
                });
            </script>
        @else
            <p class="text-gray-500">ยังไม่มีข้อมูล</p>
        @endif
    </div>
@endsection