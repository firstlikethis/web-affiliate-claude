<header class="bg-white shadow-sm">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <!-- Logo -->
            <div>
                <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">
                    {{ config('app.name', 'Affiliate Website') }}
                </a>
            </div>
            
            <!-- Navigation -->
            <nav class="hidden md:flex space-x-6">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600">หน้าแรก</a>
                <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-blue-600">สินค้า</a>
                <a href="{{ route('articles.index') }}" class="text-gray-700 hover:text-blue-600">บทความ</a>
                
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">จัดการระบบ</a>
                @endauth
            </nav>
            
            <!-- Search and Mobile Menu -->
            <div class="flex items-center space-x-4">
                <!-- Search Button -->
                <button id="searchToggle" class="text-gray-700 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
                
                <!-- Mobile Menu Button -->
                <button id="mobileMenuToggle" class="md:hidden text-gray-700 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile Navigation (Hidden by default) -->
        <div id="mobileNav" class="md:hidden py-4 hidden">
            <div class="flex flex-col space-y-3">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600">หน้าแรก</a>
                <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-blue-600">สินค้า</a>
                <a href="{{ route('articles.index') }}" class="text-gray-700 hover:text-blue-600">บทความ</a>
                
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">จัดการระบบ</a>
                @endauth
            </div>
        </div>
        
        <!-- Search Form (Hidden by default) -->
        <div id="searchForm" class="py-4 hidden">
            @include('components.search-form')
        </div>
    </div>
</header>

<script>
    // Mobile menu toggle
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const mobileNav = document.getElementById('mobileNav');
    
    if (mobileMenuToggle && mobileNav) {
        mobileMenuToggle.addEventListener('click', function() {
            mobileNav.classList.toggle('hidden');
            searchForm.classList.add('hidden');
        });
    }
    
    // Search form toggle
    const searchToggle = document.getElementById('searchToggle');
    const searchForm = document.getElementById('searchForm');
    
    if (searchToggle && searchForm) {
        searchToggle.addEventListener('click', function() {
            searchForm.classList.toggle('hidden');
            mobileNav.classList.add('hidden');
        });
    }
</script>