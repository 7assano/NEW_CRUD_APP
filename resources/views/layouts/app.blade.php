<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 min-h-screen">
    <div class="flex relative">
        {{-- Overlay for mobile --}}
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden hidden"></div>

        {{-- Sidebar --}}
        <aside id="sidebar" class="fixed lg:sticky top-0 left-0 h-screen bg-slate-800/50 backdrop-blur-sm border-r border-slate-700 transition-all duration-300 z-50 w-64">
            <div class="flex flex-col h-full">
                {{-- Header with Toggle --}}
                <div class="p-6 border-b border-slate-700">
                    <div class="flex items-center justify-between mb-6">
                        {{-- Logo --}}
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg">
                                T
                            </div>
                            <div class="sidebar-text">
                                <h1 class="text-white font-bold text-lg">TaskManager</h1>
                                <p class="text-slate-400 text-xs">Stay organized</p>
                            </div>
                        </div>

                        {{-- Toggle Button --}}
                        <button id="sidebar-toggle" class="lg:block hidden p-2 rounded-lg hover:bg-slate-700/50 text-slate-400 hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                            </svg>
                        </button>

                        {{-- Close Button (Mobile) --}}
                        <button id="sidebar-close" class="lg:hidden p-2 rounded-lg hover:bg-slate-700/50 text-slate-400 hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    {{-- User Info --}}
                    <div class="bg-slate-900/50 rounded-xl p-4 border border-slate-700 hover:border-slate-600 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg shrink-0">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0 sidebar-text">
                                <p class="text-white font-semibold text-sm truncate">{{ Auth::user()->name }}</p>
                                <p class="text-slate-400 text-xs truncate">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Navigation --}}
                <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                    {{-- My Tasks --}}
                    <a href="{{ route('tasks.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition group {{ request()->routeIs('tasks.index') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <span class="font-medium sidebar-text">My Tasks</span>
                    </a>

                    {{-- Categories --}}
                    <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition group {{ request()->routeIs('categories.*') ? 'bg-purple-600 text-white shadow-lg shadow-purple-600/30' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        <span class="font-medium sidebar-text">Categories</span>
                    </a>

                    {{-- Trash --}}
                    <a href="{{ route('trash.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition group {{ request()->routeIs('trash.*') ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        <span class="font-medium sidebar-text">Trash</span>
                    </a>
                </nav>

                {{-- Quick Stats --}}
                <div class="p-4 border-t border-slate-700">
                    <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-3 sidebar-text">Quick Stats</p>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between bg-slate-900/50 rounded-lg p-3 border border-slate-700 hover:border-blue-600/50 transition">
                            <span class="text-slate-300 text-sm sidebar-text">Total Tasks</span>
                            <span class="text-white font-bold">{{ Auth::user()->tasks()->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between bg-slate-900/50 rounded-lg p-3 border border-slate-700 hover:border-emerald-600/50 transition">
                            <span class="text-slate-300 text-sm sidebar-text">Completed</span>
                            <span class="text-emerald-400 font-bold">{{ Auth::user()->tasks()->where('is_completed', true)->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between bg-slate-900/50 rounded-lg p-3 border border-slate-700 hover:border-yellow-600/50 transition">
                            <span class="text-slate-300 text-sm sidebar-text">Pending</span>
                            <span class="text-yellow-400 font-bold">{{ Auth::user()->tasks()->where('is_completed', false)->count() }}</span>
                        </div>
                    </div>
                </div>

                {{-- Logout --}}
                <div class="p-4 border-t border-slate-700">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl bg-red-600/10 text-red-400 hover:bg-red-600 hover:text-white transition group">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="font-medium sidebar-text">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 min-h-screen">
            {{-- Mobile Header --}}
            <div class="lg:hidden sticky top-0 z-30 bg-slate-800/95 backdrop-blur-sm border-b border-slate-700 px-4 py-3">
                <div class="flex items-center justify-between">
                    <button id="sidebar-open" class="p-2 rounded-lg hover:bg-slate-700/50 text-slate-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <h1 class="text-white font-bold">TaskManager</h1>
                    <div class="w-10"></div>
                </div>
            </div>

            {{-- Page Content --}}
            <div class="p-6">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Sidebar Toggle Logic
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebarOpen = document.getElementById('sidebar-open');
        const sidebarClose = document.getElementById('sidebar-close');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const sidebarTexts = document.querySelectorAll('.sidebar-text');

        let isCollapsed = false;

        // Desktop Toggle
        sidebarToggle?.addEventListener('click', () => {
            isCollapsed = !isCollapsed;
            
            if (isCollapsed) {
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-20');
                sidebarTexts.forEach(el => el.classList.add('hidden'));
                sidebarToggle.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>';
            } else {
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-64');
                sidebarTexts.forEach(el => el.classList.remove('hidden'));
                sidebarToggle.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>';
            }
        });

        // Mobile Open
        sidebarOpen?.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            sidebarOverlay.classList.remove('hidden');
        });

        // Mobile Close
        sidebarClose?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });

        sidebarOverlay?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });

        // Initial mobile state
        if (window.innerWidth < 1024) {
            sidebar.classList.add('-translate-x-full');
        }
    </script>
</body>

</html>