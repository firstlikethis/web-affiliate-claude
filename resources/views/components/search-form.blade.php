<form action="{{ route('search') }}" method="GET" class="w-full">
    <div class="flex">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="ค้นหาสินค้าหรือบทความ..." 
               class="w-full px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        
        <select name="type" class="border-t border-b border-r border-gray-300 px-3 py-2 bg-gray-100 text-gray-700">
            <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>ทั้งหมด</option>
            <option value="products" {{ request('type') == 'products' ? 'selected' : '' }}>สินค้า</option>
            <option value="articles" {{ request('type') == 'articles' ? 'selected' : '' }}>บทความ</option>
        </select>
        
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </button>
    </div>
</form>