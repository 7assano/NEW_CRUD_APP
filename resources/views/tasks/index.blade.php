@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-100">Welcome to your to-do list</h1>
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

    {{-- Search & Filter Bar --}}
    <div class="bg-slate-800 p-4 rounded-2xl border border-slate-700 shadow-lg">
        <form action="{{ route('tasks.index') }}" method="GET" class="flex flex-col gap-3">
            {{-- Search Input --}}
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

            {{-- Filters Row --}}
            <div class="flex flex-wrap gap-2">
                {{-- Status Filter --}}
                <select name="filter" class="bg-slate-900 border border-slate-700 rounded-xl px-4 py-2 text-sm text-slate-300 outline-none">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('filter') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('filter') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>

                {{-- Priority Filter --}}
                <select name="priority" class="bg-slate-900 border border-slate-700 rounded-xl px-4 py-2 text-sm text-slate-300 outline-none">
                    <option value="">All Priorities</option>
                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                </select>

                {{-- Category Filter --}}
                <select name="category" class="bg-slate-900 border border-slate-700 rounded-xl px-4 py-2 text-sm text-slate-300 outline-none">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>

                {{-- Favorite Filter --}}
                <label class="flex items-center gap-2 bg-slate-900 border border-slate-700 rounded-xl px-4 py-2 text-sm text-slate-300 cursor-pointer">
                    <input type="checkbox" name="favorite" value="1" {{ request('favorite') == '1' ? 'checked' : '' }}
                        class="rounded bg-slate-800 border-slate-600 text-yellow-500 focus:ring-yellow-500">
                    <span>⭐ Favorites</span>
                </label>

                {{-- Buttons --}}
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-xl hover:bg-blue-700 transition font-bold">
                    Search
                </button>
                <a href="{{ route('tasks.index') }}" class="bg-slate-700 text-slate-300 px-4 py-2 rounded-xl hover:bg-slate-600 transition text-center flex items-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="bg-emerald-900/20 border border-emerald-800/50 text-emerald-400 px-4 py-3 rounded-xl flex items-center gap-3">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    {{-- Tasks List --}}
    @if($tasks->isEmpty())
    <div class="bg-slate-800 border border-slate-700 rounded-2xl p-12 text-center">
        <div class="text-slate-500 mb-4">
            <svg class="w-20 h-20 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
        </div>
        <h3 class="text-xl font-semibold text-slate-300 mb-2">No tasks found</h3>
        <p class="text-slate-500 mb-6">Start by creating your first task!</p>
        <a href="{{ route('tasks.create') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Create Task
        </a>
    </div>
    @else
    <div class="grid gap-4">
        @foreach($tasks as $task)
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-5 hover:border-slate-600 transition-all group">
            <div class="flex items-start gap-4">
                {{-- Checkbox --}}
                <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="mt-1">
                        @if($task->is_completed)
                        <svg class="w-6 h-6 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        @else
                        <div class="w-6 h-6 border-2 border-slate-600 rounded-full hover:border-blue-500 transition"></div>
                        @endif
                    </button>
                </form>

                {{-- Task Image --}}
                @if($task->image)
                <img src="{{ asset('storage/' . $task->image) }}" alt="Task" class="w-16 h-16 rounded-lg object-cover">
                @endif

                {{-- Task Content --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-3 mb-2">
                        <h3 class="text-lg font-semibold text-slate-100 {{ $task->is_completed ? 'line-through opacity-50' : '' }}">
                            {{ $task->title }}
                        </h3>

                        {{-- Favorite Button --}}
                        <form action="{{ route('tasks.favorite', $task) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-2xl hover:scale-110 transition">
                                {{ $task->is_favorite ? '⭐' : '☆' }}
                            </button>
                        </form>
                    </div>

                    @if($task->description)
                    <p class="text-slate-400 text-sm mb-3 {{ $task->is_completed ? 'line-through opacity-50' : '' }}">
                        {{ $task->description }}
                    </p>
                    @endif

                    {{-- Tags --}}
                    <div class="flex flex-wrap gap-2 mb-3">
                        {{-- Priority Badge --}}
                        @if($task->priority == 'high')
                        <span class="bg-red-900/30 text-red-400 text-xs px-2 py-1 rounded-full border border-red-800">🔴 High</span>
                        @elseif($task->priority == 'medium')
                        <span class="bg-yellow-900/30 text-yellow-400 text-xs px-2 py-1 rounded-full border border-yellow-800">🟡 Medium</span>
                        @else
                        <span class="bg-green-900/30 text-green-400 text-xs px-2 py-1 rounded-full border border-green-800">🟢 Low</span>
                        @endif

                        {{-- Category Badge --}}
                        @if($task->category)
                        <span class="bg-purple-900/30 text-purple-400 text-xs px-2 py-1 rounded-full border border-purple-800">
                            📁 {{ $task->category->name }}
                        </span>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 text-sm">
                        <a href="{{ route('tasks.edit', $task) }}" class="text-blue-400 hover:text-blue-300 font-medium">
                            ✏️ Edit
                        </a>
                        <span class="text-slate-600">•</span>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Move to trash?')" class="text-red-400 hover:text-red-300 font-medium">
                                🗑️ Delete
                            </button>
                        </form>
                        <span class="text-slate-600 ml-auto">{{ $task->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection