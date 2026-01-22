<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accomplishment | Smart Manager</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
        }
    </style>
</head>

<!-- Always add the dark class here -->

<body class="dark bg-slate-900 text-slate-100 antialiased">

    <nav class="bg-slate-800 border-b border-slate-700 sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="bg-blue-600 p-2 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <span class="text-xl font-bold tracking-tight text-slate-100 block">CRUD-APP</span>
            </div>

            <div class="flex items-center gap-4">
                @auth
                <span class="hidden md:block text-sm font-medium text-slate-400 italic">Hello, {{ auth()->user()->name }}</span>
                <a href="{{ route('tasks.index') }}" class="text-sm font-medium text-slate-200 hover:text-blue-400 transition">My Tasks</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-red-400 hover:text-red-200">Logout</button>
                </form>
                <a href="{{ route('tasks.create') }}" class="bg-slate-700 text-white px-4 py-2 rounded-full text-sm font-medium hover:bg-slate-600 transition">New Task</a>
                @else
                <a href="{{ route('login') }}" class="text-sm font-medium text-slate-300">Login</a>
                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-medium hover:bg-blue-700 transition">Start for Free</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-4 py-8">
        @yield('content')
    </main>

    <footer class="text-center py-10 text-slate-500 text-sm">

    </footer>

</body>

</html>