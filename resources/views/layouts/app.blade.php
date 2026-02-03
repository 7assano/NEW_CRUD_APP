<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskly Pro | Dashboard</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
    </style>
</head>

<body class="bg-[#0f172a] text-slate-200 min-h-screen selection:bg-blue-500/30 selection:text-blue-200">
    <div class="flex relative">
        {{-- Overlay for mobile --}}
        <div id="sidebar-overlay" class="fixed inset-0 bg-[#020617]/80 backdrop-blur-md z-40 lg:hidden hidden"></div>

        {{-- Sidebar --}}
        <aside id="sidebar" class="fixed lg:sticky top-0 left-0 h-screen bg-[#1e293b]/40 backdrop-blur-xl border-r border-slate-800/60 transition-all duration-500 z-50 w-72 overflow-hidden group">
            <div class="flex flex-col h-full">
                {{-- Header Section --}}
                <div class="p-6">
                    <div class="flex items-center justify-between mb-8">
                        {{-- Logo --}}
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 bg-gradient-to-tr from-blue-600 via-blue-500 to-indigo-400 rounded-2xl flex items-center justify-center text-white font-black text-2xl shadow-xl shadow-blue-500/20 rotate-3 group-hover:rotate-0 transition-transform duration-500">
                                T
                            </div>
                            <div class="sidebar-text animate-in slide-in-from-left duration-500">
                                <h1 class="text-white font-extrabold text-xl tracking-tight uppercase italic">Taskly</h1>
                                <p class="text-blue-400/60 text-[10px] font-bold tracking-widest uppercase">Premium Workspace</p>
                            </div>
                        </div>

                        {{-- Toggle Button (Desktop) --}}
                        <button id="sidebar-toggle" class="lg:block hidden p-2.5 rounded-xl bg-slate-800/40 border border-slate-700/50 text-slate-400 hover:text-white hover:bg-slate-700 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
                        </button>
                    </div>

                    {{-- User Profile Card --}}
                    <div class="bg-gradient-to-br from-slate-800/80 to-slate-900/80 rounded-2xl p-4 border border-slate-700/50 shadow-2xl relative overflow-hidden group/profile">
                        <div class="absolute -right-2 -top-2 w-12 h-12 bg-blue-500/10 rounded-full blur-2xl"></div>
                        <div class="flex items-center gap-4 relative z-10">
                            <div class="shrink-0">
                                @if(Auth::user()->avatar)
                                    <img src="{{ Auth::user()->avatar_url }}" class="w-12 h-12 rounded-xl object-cover ring-2 ring-blue-500/20 shadow-lg">
                                @else
                                    <div class="w-12 h-12 bg-gradient-to-br from-slate-700 to-slate-800 rounded-xl flex items-center justify-center text-blue-400 font-black text-xl border border-slate-600">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0 sidebar-text">
                                <p class="text-white font-bold text-sm truncate">{{ Auth::user()->name }}</p>
                                <div class="flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                    <p class="text-slate-500 text-[10px] font-medium tracking-wide">Online Now</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Navigation Section --}}
                <nav class="flex-1 px-4 space-y-1.5 overflow-y-auto custom-scrollbar">
                    <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.2em] px-4 py-4 sidebar-text">Navigation</p>
                    
                    <a href="{{ route('tasks.index') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all duration-300 group/nav {{ request()->routeIs('tasks.index') ? 'bg-blue-600/10 text-blue-400 border border-blue-500/20 shadow-[0_0_20px_rgba(37,99,235,0.1)]' : 'text-slate-400 hover:bg-slate-800/40 hover:text-white' }}">
                        <svg class="w-5 h-5 group-hover/nav:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        <span class="font-bold text-sm sidebar-text">My Workspace</span>
                    </a>

                    <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all duration-300 group/nav {{ request()->routeIs('categories.*') ? 'bg-purple-600/10 text-purple-400 border border-purple-500/20' : 'text-slate-400 hover:bg-slate-800/40 hover:text-white' }}">
                        <svg class="w-5 h-5 group-hover/nav:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        <span class="font-bold text-sm sidebar-text">Collections</span>
                    </a>

                    <a href="{{ route('trash.index') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all duration-300 group/nav {{ request()->routeIs('trash.*') ? 'bg-red-600/10 text-red-400 border border-red-500/20' : 'text-slate-400 hover:bg-slate-800/40 hover:text-white' }}">
                        <svg class="w-5 h-5 group-hover/nav:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        <span class="font-bold text-sm sidebar-text">Trash Bin</span>
                    </a>
                </nav>

                {{-- Stats Widget Section --}}
                <div class="px-6 py-6 border-t border-slate-800/60">
                    <div class="grid grid-cols-2 gap-2 sidebar-text">
                        <div class="bg-slate-800/40 p-3 rounded-2xl border border-slate-700/50">
                            <p class="text-[9px] text-slate-500 font-black uppercase">Tasks</p>
                            <p class="text-lg font-bold text-white">{{ Auth::user()->tasks()->count() }}</p>
                        </div>
                        <div class="bg-emerald-500/5 p-3 rounded-2xl border border-emerald-500/10">
                            <p class="text-[9px] text-emerald-500 font-black uppercase">Done</p>
                            <p class="text-lg font-bold text-emerald-400">{{ Auth::user()->tasks()->where('is_completed', true)->count() }}</p>
                        </div>
                    </div>
                </div>

                {{-- Footer (Logout) --}}
                <div class="p-6 border-t border-slate-800/60">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3.5 rounded-2xl bg-red-500/5 text-red-400 hover:bg-red-500 hover:text-white transition-all duration-300 font-bold text-sm group/out">
                            <svg class="w-5 h-5 group-hover/out:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            <span class="sidebar-text">Sign Out</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 min-h-screen relative overflow-x-hidden">
            {{-- Modern Navbar (Mobile Only) --}}
            <div class="lg:hidden sticky top-0 z-30 bg-[#0f172a]/80 backdrop-blur-lg border-b border-slate-800 px-6 py-4">
                <div class="flex items-center justify-between">
                    <button id="sidebar-open" class="p-2.5 bg-slate-800/50 rounded-xl text-slate-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg"></div>
                        <h1 class="text-white font-black text-sm tracking-widest uppercase">Taskly</h1>
                    </div>
                    <div class="w-10"></div>
                </div>
            </div>

            {{-- Background Decor --}}
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-600/5 rounded-full blur-[120px] -z-10"></div>
            <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-purple-600/5 rounded-full blur-[100px] -z-10"></div>

            {{-- Dynamic Page Content --}}
            <div class="p-4 lg:p-10 animate-in fade-in slide-in-from-bottom-4 duration-700">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- Keep your original JS logic, it's perfect --}}
    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebarOpen = document.getElementById('sidebar-open');
        const sidebarClose = document.getElementById('sidebar-close');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const sidebarTexts = document.querySelectorAll('.sidebar-text');

        let isCollapsed = false;

        sidebarToggle?.addEventListener('click', () => {
            isCollapsed = !isCollapsed;
            if (isCollapsed) {
                sidebar.classList.remove('w-72');
                sidebar.classList.add('w-24');
                sidebarTexts.forEach(el => el.style.display = 'none');
                sidebarToggle.style.transform = 'rotate(180deg)';
            } else {
                sidebar.classList.remove('w-24');
                sidebar.classList.add('w-72');
                sidebarTexts.forEach(el => el.style.display = 'block');
                sidebarToggle.style.transform = 'rotate(0deg)';
            }
        });

        sidebarOpen?.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            sidebarOverlay.classList.remove('hidden');
        });

        sidebarOverlay?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });

        if (window.innerWidth < 1024) { sidebar.classList.add('-translate-x-full'); }
    </script>
</body>
</html>