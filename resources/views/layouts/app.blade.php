<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 min-h-screen">
    <div class="flex">
        {{-- Sidebar --}}
        <aside class="w-64 bg-slate-800/50 backdrop-blur-sm border-r border-slate-700 min-h-screen sticky top-0">
            <div class="p-6">
                {{-- Logo --}}
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                        T
                    </div>
                    <div>
                        <h1 class="text-white font-bold text-lg">TaskManager</h1>
                        <p class="text-slate-400 text-xs">Stay organized</p>
                    </div>
                </div>

                {{-- User Info --}}
                <div class="bg-slate-900/50 rounded-xl p-4 mb-6 border border-slate-700">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-full flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-white font-semibold text-sm truncate">{{ Auth::user()->name }}</p>
                            <p class="text-slate-400 text-xs truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>

                {{-- Navigation --}}
                <nav class="space-y-1">
                    {{-- Tasks --}}
                    <a href="{{ route('tasks.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('tasks.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700/50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <span class="font-medium">My Tasks</span>
                    </a>

                    {{-- Categories --}}
                    <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('categories.*') ? 'bg-purple-600 text-white' : 'text-slate-300 hover:bg-slate-700/50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                        <span class="font-medium">Categories</span>
                    </a>

                    {{-- Trash --}}
                    <a href="{{ route('trash.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('trash.*') ? 'bg-red-600 text-white' : 'text-slate-300 hover:bg-slate-700/50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        <span class="font-medium">Trash</span>
                    </a>

                    {{-- Divider --}}
                    <div class="border-t border-slate-700 my-4"></div>

                    {{-- Quick Stats --}}
                    <div class="px-4 py-2">
                        <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold mb-3">Quick Stats</p>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between text-slate-300">
                                <span>Total Tasks</span>
                                <span class="font-bold">{{ Auth::user()->tasks()->count() }}</span>
                            </div>
                            <div class="flex justify-between text-slate-300">
                                <span>Completed</span>
                                <span class="font-bold text-green-400">{{ Auth::user()->tasks()->where('is_completed', true)->count() }}</span>
                            </div>
                            <div class="flex justify-between text-slate-300">
                                <span>Pending</span>
                                <span class="font-bold text-yellow-400">{{ Auth::user()->tasks()->where('is_completed', false)->count() }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="border-t border-slate-700 my-4"></div>

                    {{-- Logout --}}
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:bg-red-900/20 transition font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </nav>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 p-8">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>