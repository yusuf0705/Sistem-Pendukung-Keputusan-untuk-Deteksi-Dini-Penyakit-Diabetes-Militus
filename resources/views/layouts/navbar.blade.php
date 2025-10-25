<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'deteksi Kesehatan')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar-hover:hover {
            background-color: #0f4a27;
        }
        .active-menu {
            background-color: #0f4a27;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            @yield('content')
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
    @stack('scripts')
</body>
</html>
