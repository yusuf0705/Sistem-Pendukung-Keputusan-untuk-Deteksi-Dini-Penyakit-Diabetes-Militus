<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .sidebar-hover:hover {
            background-color: #0f4a27;
        }
        .active-menu {
            background-color: #0f4a27;
        }
    </style>
</head>
<body class="bg-gray-100">

<div class="flex h-screen">
    <!-- Sidebar -->
    @include('components.admin-sidebar')

    <!-- Konten Utama -->
    <div class="flex-1 overflow-auto flex flex-col">

        <!-- Topbar -->
        <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
            <h1 class="text-lg font-semibold text-gray-700">
                @yield('page_title', 'Admin Dashboard')
            </h1>

            <!-- Logout -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                        class="flex items-center gap-2 text-red-600 hover:text-red-800 font-medium">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </button>
            </form>
        </header>

        <!-- Content -->
        <main class="p-6 flex-1">
            @yield('content')
        </main>

    </div>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const menuTexts = document.querySelectorAll('.menu-text');

        sidebar.classList.toggle('w-64');
        sidebar.classList.toggle('w-20');

        menuTexts.forEach(text => {
            text.classList.toggle('hidden');
        });
    }
</script>

@if (session('login'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Login Berhasil',
        text: '{{ session('login') }}',
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif

</body>
</html>
