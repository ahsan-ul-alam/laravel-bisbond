<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('bisbond.dashboard.title', 'Bisbond') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-900 font-sans">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="w-64 bg-indigo-900 text-white flex-shrink-0">
            <div class="p-6">
                <h1 class="text-2xl font-bold flex items-center">
                    <i class="fas fa-rocket mr-2 text-indigo-400"></i>
                    Bisbond
                </h1>
            </div>
            <nav class="mt-4 px-4 space-y-2">
                <a href="{{ route('bisbond.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-800 transition {{ request()->routeIs('bisbond.dashboard') ? 'bg-indigo-800' : '' }}">
                    <i class="fas fa-home w-6"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('bisbond.settings.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-800 transition {{ request()->routeIs('bisbond.settings.*') ? 'bg-indigo-800' : '' }}">
                    <i class="fas fa-cog w-6"></i>
                    <span>Settings</span>
                </a>
                <a href="{{ route('bisbond.invoice.preview') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-800 transition {{ request()->routeIs('bisbond.invoice.*') ? 'bg-indigo-800' : '' }}">
                    <i class="fas fa-file-invoice w-6"></i>
                    <span>Invoice Preview</span>
                </a>
                <div class="pt-4 pb-2 text-xs font-semibold text-indigo-400 uppercase tracking-wider px-4">
                    System Explorer
                </div>
                <a href="{{ route('bisbond.system.routes') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-800 transition {{ request()->routeIs('bisbond.system.routes') ? 'bg-indigo-800' : '' }}">
                    <i class="fas fa-route w-6"></i>
                    <span>Routes</span>
                </a>
                <a href="{{ route('bisbond.system.commands') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-800 transition {{ request()->routeIs('bisbond.system.commands') ? 'bg-indigo-800' : '' }}">
                    <i class="fas fa-terminal w-6"></i>
                    <span>Commands</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white border-b border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-800">
                        @yield('title', 'Dashboard')
                    </h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-500">v1.1.0</span>
                        <a href="/" class="text-sm text-indigo-600 hover:text-indigo-800">Back to App</a>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
