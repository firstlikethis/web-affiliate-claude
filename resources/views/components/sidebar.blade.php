<aside class="bg-gray-800 text-white w-64 min-h-screen hidden md:block">
    <div class="p-4">
        <a href="{{ route('home') }}" class="text-xl font-bold text-white">
            {{ config('app.name', 'Affiliate Website') }}
        </a>
    </div>
    
    <nav class="mt-6">
        <ul>
            <li class="px-4 py-2 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700' : 'hover:bg-gray-700' }}">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                    <i class="fas fa-tachometer-alt w-6"></i>
                    <span>แดชบอร์ด</span>
                </a>
            </li>
            <li class="px-4 py-2 {{ request()->routeIs('admin.products.*') ? 'bg-blue-700' : 'hover:bg-gray-700' }}">
                <a href="{{ route('admin.products.index') }}" class="flex items-center">
                    <i class="fas fa-box w-6"></i>
                    <span>จัดการสินค้า</span>
                </a>
            </li>
            <li class="px-4 py-2 {{ request()->routeIs('admin.articles.*') ? 'bg-blue-700' : 'hover:bg-gray-700' }}">
                <a href="{{ route('admin.articles.index') }}" class="flex items-center">
                    <i class="fas fa-newspaper w-6"></i>
                    <span>จัดการบทความ</span>
                </a>
            </li>
            <li class="px-4 py-2 {{ request()->routeIs('admin.categories.*') ? 'bg-blue-700' : 'hover:bg-gray-700' }}">
                <a href="{{ route('admin.categories.index') }}" class="flex items-center">
                    <i class="fas fa-folder w-6"></i>
                    <span>จัดการหมวดหมู่</span>
                </a>
            </li>
            <li class="px-4 py-2 {{ request()->routeIs('admin.tags.*') ? 'bg-blue-700' : 'hover:bg-gray-700' }}">
                <a href="{{ route('admin.tags.index') }}" class="flex items-center">
                    <i class="fas fa-tags w-6"></i>
                    <span>จัดการแท็ก</span>
                </a>
            </li>
            @if(Auth::user()->isAdmin())
                <li class="px-4 py-2 {{ request()->routeIs('admin.users.*') ? 'bg-blue-700' : 'hover:bg-gray-700' }}">
                    <a href="{{ route('admin.users.index') }}" class="flex items-center">
                        <i class="fas fa-users w-6"></i>
                        <span>จัดการผู้ใช้</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</aside>

<!-- Mobile Sidebar Toggle Button -->
<div class="md:hidden fixed bottom-4 right-4 z-50">
    <button id="sidebarToggle" class="bg-blue-600 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-lg">
        <i class="fas fa-bars"></i>
    </button>
</div>

<!-- Mobile Sidebar (Hidden by default) -->
<div id="mobileSidebar" class="fixed inset-0 z-40 hidden">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    
    <div class="absolute inset-y-0 left-0 w-64 bg-gray-800 text-white shadow-lg">
        <div class="p-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-xl font-bold text-white">
                {{ config('app.name', 'Affiliate Website') }}
            </a>
            <button id="closeSidebar" class="text-white focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <nav class="mt-6">
            <ul>
                <li class="px-4 py-2 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700' : 'hover:bg-gray-700' }}">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                        <i class="fas fa-tachometer-alt w-6"></i>
                        <span>แดชบอร์ด</span>
                    </a>
                </li>
                <li class="px-4 py-2 {{ request()->routeIs('admin.products.*') ? 'bg-blue-700' : 'hover:bg-gray-700' }}">
                    <a href="{{ route('admin.products.index') }}" class="flex items-center">
                        <i class="fas fa-box w-6"></i>
                        <span>จัดการสินค้า</span>
                    </a>
                </li>
                <li class="px-4 py-2 {{ request()->routeIs('admin.articles.*') ? 'bg-blue-700' : 'hover:bg-gray-700' }}">
                    <a href="{{ route('admin.articles.index') }}" class="flex items-center">
                        <i class="fas fa-newspaper w-6"></i>
                        <span>จัดการบทความ</span>
                    </a>
                </li>
                <li class="px-4 py-2 {{ request()->routeIs('admin.categories.*') ? 'bg-blue-700' : 'hover:bg-gray-700' }}">
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center">
                        <i class="fas fa-folder w-6"></i>
                        <span>จัดการหมวดหมู่</span>
                    </a>
                </li>
                <li class="px-4 py-2 {{ request()->routeIs('admin.tags.*') ? 'bg-blue-700' : 'hover:bg-gray-700' }}">
                    <a href="{{ route('admin.tags.index') }}" class="flex items-center">
                        <i class="fas fa-tags w-6"></i>
                        <span>จัดการแท็ก</span>
                    </a>
                </li>
                @if(Auth::user()->isAdmin())
                    <li class="px-4 py-2 {{ request()->routeIs('admin.users.*') ? 'bg-blue-700' : 'hover:bg-gray-700' }}">
                        <a href="{{ route('admin.users.index') }}" class="flex items-center">
                            <i class="fas fa-users w-6"></i>
                            <span>จัดการผู้ใช้</span>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</div>

<script>
    // Mobile sidebar toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    const closeSidebar = document.getElementById('closeSidebar');
    const mobileSidebar = document.getElementById('mobileSidebar');
    
    if (sidebarToggle && mobileSidebar) {
        sidebarToggle.addEventListener('click', function() {
            mobileSidebar.classList.remove('hidden');
        });
    }
    
    if (closeSidebar && mobileSidebar) {
        closeSidebar.addEventListener('click', function() {
            mobileSidebar.classList.add('hidden');
        });
    }
    
    // Close sidebar when clicking outside
    if (mobileSidebar) {
        mobileSidebar.addEventListener('click', function(event) {
            if (event.target === mobileSidebar) {
                mobileSidebar.classList.add('hidden');
            }
        });
    }
</script>