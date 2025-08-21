<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: false }" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Edmate Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Heroicons -->
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen flex">


<div class="flex min-h-screen w-full">
    <!-- Mobile overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-40 z-20 lg:hidden"
         x-show="sidebarOpen"
         @click="sidebarOpen = false"></div>

    <!-- Sidebar -->
    <aside
        class="fixed z-30 inset-y-0 left-0 w-64 bg-white shadow-lg transform transition-transform duration-200 lg:translate-x-0 lg:static lg:inset-0"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        @include('components.partials.sidebar')
    </aside>
    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-2 rounded">
            {{ session('success') }}
        </div>
    @endif
    <!-- Main Section -->
    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- Navbar -->
        <header class="sticky top-0 bg-white shadow z-10">
           <x-partials.navbar />
        </header>

        <!-- Body -->
        <main class="flex-1 overflow-y-auto p-6">
            {{--            @include('dashboard.auth.dashboard.components.main')--}}
            @yield('content')

        </main>

        <!-- Footer -->
        <footer class="bg-gray-100 border-t p-4 text-center text-sm">
            <x-partials.footer />
        </footer>
    </div>
</div>

<script>
    feather.replace()
</script>
</body>
</html>
