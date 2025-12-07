<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/logo.svg') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-100">

    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 w-64 bg-gray-900 text-white z-50">
        <div class="flex flex-col h-full">
            <!-- Logo/Brand -->
            <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-shield-check text-blue-400 w-8 h-8">
                    <path
                        d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                    <path d="m9 12 2 2 4-4" />
                </svg>
                <div>
                    <h1 class="text-lg font-bold">Admin Panel</h1>
                    <p class="text-xs text-gray-400">PLV Cloud</p>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-300' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-layout-dashboard w-5 h-5">
                        <rect width="7" height="9" x="3" y="3" rx="1" />
                        <rect width="7" height="5" x="14" y="3" rx="1" />
                        <rect width="7" height="9" x="14" y="12" rx="1" />
                        <rect width="7" height="5" x="3" y="16" rx="1" />
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>                

                <a href="{{ route('home') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition-colors duration-200 text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-globe w-5 h-5">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20" />
                        <path d="M2 12h20" />
                    </svg>
                    <span class="font-medium">View Site</span>
                </a>
            </nav>

            <!-- Footer -->
            <div class="px-4 py-4 border-t border-gray-700">
                <p class="text-xs text-gray-400 text-center">© 2025 PLV Cloud</p>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="ml-64 min-h-screen flex flex-col">
        <!-- Top Navigation Bar -->
        <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Admin Dashboard</h2>
                        <p class="text-sm text-gray-500">Welcome back, Administrator</p>
                    </div>

                    <div class="flex items-center gap-4">                        
                        <!-- Logout Button -->
                        <a href="{{ route('admin.login') }}"
                            onclick="event.preventDefault(); sessionStorage.clear(); window.location.href='{{ route('admin.login') }}';"
                            class="flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-log-out w-4 h-4">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                <polyline points="16 17 21 12 16 7" />
                                <line x1="21" x2="9" y1="12" y2="12" />
                            </svg>
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1">
            {{ $slot }}
        </main>

        <x-ui.flashes.success-flash />
    </div>

</body>

</html>