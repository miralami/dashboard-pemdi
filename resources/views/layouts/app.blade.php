<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Portal Pemerintahan Digital') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|playfair-display:400,500,600,700,800" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="antialiased">
    <!-- Header Navigation -->
    <header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300" id="main-header">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/LogoPANRB.png') }}" alt="Logo PANRB" class="h-12 w-auto drop-shadow-lg">
                    <span class="text-white font-bold text-xl hidden sm:block drop-shadow-lg">panrb</span>
                </div>

                <!-- Navigation Links -->
                <div class="flex items-center space-x-6">
                    <a href="{{ url('/') }}" class="text-white hover:text-panrb-gold-light transition-colors font-medium px-4 py-2 rounded-lg hover:bg-white/10">Home</a>
                    <a href="{{ route('login') }}" class="text-white hover:bg-panrb-gold hover:text-panrb-blue-dark transition-all font-semibold px-6 py-2 rounded-lg border-2 border-white/50">Login</a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <!-- Footer Logo -->
                <div class="flex items-center space-x-3 mb-4 md:mb-0">
                    <img src="{{ asset('images/LogoPANRB.png') }}" alt="Logo PANRB" class="h-12 w-auto">
                    <div>
                        <span class="font-bold text-gray-800 text-lg">panrb</span>
                        <p class="text-xs text-gray-500">Pemerintahan Digital Indonesia</p>
                    </div>
                </div>

                <!-- Footer Links -->
                <div class="flex items-center space-x-8 text-sm">
                    <a href="#" class="text-gray-600 hover:text-panrb-blue transition-colors">Tentang</a>
                    <a href="#" class="text-gray-600 hover:text-panrb-blue transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="text-gray-600 hover:text-panrb-blue transition-colors">Kontak</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
