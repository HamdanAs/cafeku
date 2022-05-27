<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->


    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @livewireStyles
    @livewireScripts
    @livewireChartsScripts
    <wireui:scripts />
    @powerGridStyles
    @powerGridScripts
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Page Heading -->

        @auth

        <nav class="bg-white border-b border-gray-200 w-full fixed z-30">
            <div class="px-3 py-5 lg:px-5 lg:pl-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-between w-full">
                        <button id="toggleSidebarMobile" aria-expanded="true" aria-controls="sidebar" class="lg:hidden mr-2 text-gray-600 hover:text-gray-900 cursor-pointer p-2 hover:bg-gray-100 focus:bg-gray-100 focus:ring-2 focus:ring-gray-100 rounded">
                            <svg id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <svg id="toggleSidebarMobileClose" class="w-6 h-6 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <a href="" class="text-xl font-bold flex items-center lg:ml-2.5">
                            <span class="self-center whitespace-nowrap">Dashboard</span>
                        </a>
                    </div>
                    <div class="flex items-center">
                        <!-- Search mobile -->
                        <button id="toggleSidebarMobileSearch" type="button" class="lg:hidden text-gray-500 hover:text-gray-900 hover:bg-gray-100 p-2 rounded-lg">
                            <span class="sr-only">Search</span>
                            <!-- Search icon -->
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <aside id="sidebar" class="fixed hidden z-20 h-full top-0 left-0 pt-16 flex lg:flex flex-shrink-0 flex-col w-56 transition-width duration-75" aria-label="Sidebar">
            <div class="relative flex-1 flex flex-col min-h-0 border-r border-gray-200 bg-white pt-0">
                <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                    <div class="flex-1 px-3 bg-white divide-y space-y-1">
                        <ul class="space-y-2 pb-2">

                            @if (Auth::user()->role->id === \App\Models\User::ADMIN)
                            <li>
                                <x-nav-link href="{{ route('admin.dashboard') }}" icon="pie-chart">Dashboard</x-nav-link>
                            </li>
                            <li>
                                <x-nav-link href="{{ route('admin.user') }}" icon="people">User</x-nav-link>
                            </li>
                            @endif

                            @if (Auth::user()->role->id === \App\Models\User::MANAGER)
                            <li>
                                <x-nav-link href="{{ route('manager.dashboard') }}" icon="pie-chart">Dashboard</x-nav-link>
                            </li>
                            <li>
                                <x-nav-link href="{{ route('manager.menu') }}" icon="pricetags">Menu</x-nav-link>
                            </li>
                            <li>
                                <x-nav-link href="{{ route('manager.category') }}" icon="apps">Kategori</x-nav-link>
                            </li>
                            <li>
                                <x-nav-link href="{{ route('manager.report') }}" icon="document-text">Laporan</x-nav-link>
                            </li>
                            @endif

                            @if (Auth::user()->role->id === \App\Models\User::CASHIER)
                            <li>
                                <x-nav-link href="{{ route('cashier.dashboard') }}" icon="pie-chart">Dashboard</x-nav-link>
                            </li>
                            <li>
                                <x-nav-link href="{{ route('cashier.transaction') }}" icon="cash">Transaksi</x-nav-link>
                            </li>
                            <li>
                                <x-nav-link href="{{ route('cashier.transaction.history') }}" icon="timer">History Transaksi</x-nav-link>
                            </li>
                            @endif

                            <li>
                                < livewire:logout />
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>

        <div class="bg-gray-900 opacity-50 hidden fixed inset-0 z-10" id="sidebarBackdrop"></div>

        <div id="main-content" class="h-screen bg-grey-50 relative overflow-y-auto lg:pl-56 pt-24 mx-4">
            <main>
                {{ $slot }}
            </main>
        </div>

        @endauth

        @guest
        <main>
            {{ $slot }}
        </main>
        @endguest

    </div>



    <script type="module">
        import hotwiredTurbo from 'https://cdn.skypack.dev/@hotwired/turbo';
    </script>

    <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js" data-turbolinks-eval="false" data-turbo-eval="false"></script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-livewire-alert::scripts />
    <x-livewire-alert::flash />

    @stack('scripts')
</body>

</html>
