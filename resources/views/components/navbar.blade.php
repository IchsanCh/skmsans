<!-- Drawer Component -->
<div class="drawer sticky top-0 z-50">
    <!-- Drawer Toggle (hidden checkbox) -->
    <input id="drawer-toggle" type="checkbox" class="drawer-toggle" />

    <!-- Main Content Wrapper -->
    <div class="drawer-content flex flex-col">
        <!-- Navbar -->
        <div class="navbar color1 text-white lg:pr-8 lg:pl-8">
            <!-- Mobile Menu Button -->
            <div class="navbar-start">
                <label for="drawer-toggle" class="btn btn-square btn-ghost drawer-button lg:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </label>

                <!-- Logo -->
                <h1 class="text-xl font-bold ml-2 lg:ml-0">SURVEYLO</h1>
            </div>
            <!-- Desktop Navigation -->
            <div class="navbar-end hidden lg:flex">
                <ul class="menu menu-horizontal px-1 space-x-2">
                    <li>
                        <a href="{{ route('home') }}"
                            class="rounded-xl font-semibold san4 {{ request()->routeIs('home') ? 'color3 font-bold border-b-2 border-white' : '' }}">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('statistik.index') }}"
                            class="rouded-xl font-semibold san4 {{ request()->routeIs('statistik.index') ? 'color3 font-bold border-b-2 border-white' : '' }}">
                            Statistik
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Mobile Sidebar -->
    <div class="drawer-side z-50">
        <label for="drawer-toggle" class="drawer-overlay"></label>
        <aside class="min-h-full w-64 color1 text-white">
            <!-- Sidebar Header -->
            <div class="p-4 border-b border-base-300">
                <h2 class="text-lg font-bold">SURVEYLO</h2>
            </div>

            <!-- Sidebar Menu -->
            <ul class="menu p-4 space-y-2 w-full">
                <li>
                    <a href="{{ route('home') }}"
                        class="flex items-center space-x-3 p-3 rounded-lg san4 transition-colors {{ request()->routeIs('home') ? 'color3 font-bold border-b-2 border-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span>Home</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('statistik.index') }}"
                        class="flex items-center space-x-3 p-3 rounded-lg san4 transition-colors {{ request()->routeIs('statistik.index') ? 'color3 font-bold border-b-2 border-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                        <span>Statistik</span>
                    </a>
                </li>
            </ul>
        </aside>
    </div>
</div>

<script>
    // Auto-close drawer when clicking on menu items
    document.querySelectorAll('.drawer-side a').forEach(link => {
        link.addEventListener('click', () => {
            document.getElementById('drawer-toggle').checked = false;
        });
    });
</script>
