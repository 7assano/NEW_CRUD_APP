@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-100"> Welcome to your to-do list </h1>
            <p class="text-slate-400">You currently have {{ $tasks->count() }} tasks.</p>
        </div>

        <div class="flex gap-2 text-xs font-semibold uppercase tracking-wider">
            <span class="bg-blue-900/30 text-blue-400 px-3 py-1 rounded-full border border-blue-800">
                Pending: {{ $tasks->where('is_completed', false)->count() }}
            </span>
            <span class="bg-emerald-900/30 text-emerald-400 px-3 py-1 rounded-full border border-emerald-800">
                Completed: {{ $tasks->where('is_completed', true)->count() }}
            </span>
        </div>
    </div>

    <div class="bg-slate-800 p-4 rounded-2xl border border-slate-700 shadow-lg">
        <form action="{{ route('tasks.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
            <div class="relative flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search for a task..."
                    class="w-full pr-10 pl-4 py-2 bg-slate-900 border border-slate-700 text-slate-100 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <div class="flex gap-2">
                <select name="filter" onchange="this.form.submit()" class="bg-slate-900 border border-slate-700 rounded-xl px-4 py-2 text-sm text-slate-300 outline-none">
                    <option value="">All tasks</option>
                    <option value="pending" {{ request('filter') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('filter') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-xl hover:bg-blue-700 transition font-bold">Search</button>
                <a href="{{ route('tasks.index') }}" class="bg-slate-700 text-slate-300 px-4 py-2 rounded-xl hover:bg-slate-600 transition text-center flex items-center">Reset</a>
            </div>
        </form>
    </div>

    @if(session('success'))
    <div class="bg-emerald-900/20 border border-emerald-800/50 text-emerald-400 px-4 py-3 rounded-xl flex items-center gap-3">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="grid gap-4">
        @forelse($tasks as $task)
        <div class="group bg-slate-800 border border-slate-700 p-5 rounded-2xl shadow-sm hover:border-blue-500/50 transition-all duration-300">
            <div class="flex items-start justify-between">
                <div class="flex gap-4">
                    <form action="{{ route('tasks.toggle', $task->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="focus:outline-none block mt-1">
                            @if($task->is_completed)
                            <div class="w-6 h-6 rounded-full bg-emerald-900/40 flex items-center justify-center text-emerald-500 border border-emerald-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            @else
                            <div class="w-6 h-6 rounded-full border-2 border-slate-600 transition hover:border-blue-500 shadow-inner"></div>
                            @endif
                        </button>
                    </form>

                    <div>
                        <h3 class="font-bold text-lg leading-tight {{ $task->is_completed ? 'text-slate-500 line-through' : 'text-slate-100' }}">
                            {{ $task->title }}
                        </h3>
                        @if($task->description)
                        <p class="text-slate-400 text-sm mt-1">{{ $task->description }}</p>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <a href="{{ route('tasks.edit', $task->id) }}" class="p-2 text-slate-500 hover:text-blue-400 hover:bg-slate-700 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </a>
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد؟')">
                        @csrf @method('DELETE')
                        <button class="p-2 text-slate-500 hover:text-red-400 hover:bg-slate-700 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-slate-800 border-2 border-dashed border-slate-700 rounded-3xl p-12 text-center">
            <h2 class="text-xl font-bold text-slate-400">The task list is empty</h2>
            <a href="{{ route('tasks.create') }}" class="mt-6 inline-block bg-blue-600 text-white px-8 py-3 rounded-full font-bold">Add your first task</a>
        </div>
        @endforelse
    </div>
</div>
@endsection