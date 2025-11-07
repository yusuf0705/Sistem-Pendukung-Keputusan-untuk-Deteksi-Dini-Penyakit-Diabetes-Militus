<!-- components/admin-sidebar.blade.php -->
<aside id="sidebar" class="w-64 bg-green-700 text-white transition-all duration-300">
    <div class="p-6">
        <h1 class="text-2xl font-bold">Admin Panel</h1>
    </div>
    
    <nav class="mt-6">
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center px-6 py-3 sidebar-hover transition {{ request()->routeIs('admin.dashboard') ? 'active-menu' : '' }}">
            <i class="fas fa-home mr-3"></i>
            <span class="menu-text">Dashboard</span>
        </a>
        
        <a href="{{ route('admin.users.index') }}" 
           class="flex items-center px-6 py-3 sidebar-hover transition {{ request()->routeIs('admin.user-management.*') ? 'active-menu' : '' }}">
            <i class="fas fa-users mr-3"></i>
            <span class="menu-text">User Management</span>
        </a>
        
        <a href="" 
           class="flex items-center px-6 py-3 sidebar-hover transition {{ request()->routeIs('riwayat_kesehatan.*') ? 'active-menu' : '' }}">
            <i class="fas fa-heart mr-3"></i>
            <span class="menu-text">Riwayat Kesehatan</span>
        </a>
    </nav>
</aside>