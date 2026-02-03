@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 animate-in fade-in duration-500">
    
    {{-- Top Header Section --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-extrabold text-white tracking-tight">My Workspace</h1>
            <p class="text-slate-400 mt-1 flex items-center gap-2">
                <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                You have <span class="text-blue-400 font-bold">{{ $tasks->count() }}</span> total tasks assigned to you.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-4">
            {{-- Professional Stats --}}
            <div class="flex bg-slate-800/50 p-1 rounded-2xl border border-slate-700/50 backdrop-blur-sm">
                <div class="px-4 py-2 text-center border-r border-slate-700/50">
                    <p class="text-[10px] uppercase font-bold text-slate-500 tracking-widest">Pending</p>
                    <p class="text-xl font-black text-blue-400">{{ $tasks->where('is_completed', false)->count() }}</p>
                </div>
                <div class="px-4 py-2 text-center">
                    <p class="text-[10px] uppercase font-bold text-slate-500 tracking-widest">Done</p>
                    <p class="text-xl font-black text-emerald-400">{{ $tasks->where('is_completed', true)->count() }}</p>
                </div>
            </div>

            <a href="{{ route('tasks.create') }}" class="group bg-blue-600 hover:bg-blue-500 text-white px-6 py-3.5 rounded-2xl font-bold transition-all duration-300 flex items-center gap-2 shadow-xl shadow-blue-900/20 active:scale-95">
                <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create New Task
            </a>
        </div>
    </div>

    {{-- Advanced Search & Filter Bar --}}
    <div class="bg-slate-800/40 p-6 rounded-3xl border border-slate-700/50 backdrop-blur-md shadow-2xl">
        <form action="{{ route('tasks.index') }}" method="GET" class="space-y-4">
            <div class="flex flex-col md:flex-row gap-4">
                {{-- Search Input --}}
                <div class="relative flex-1 group">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search for tasks, notes..."
                        class="w-full pl-12 pr-4 py-3.5 bg-slate-900/50 border border-slate-700 rounded-2xl text-slate-100 placeholder-slate-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-blue-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2"></path></svg>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <select name="filter" class="bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-300 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Status</option>
                        <option value="pending" {{ request('filter') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                        <option value="completed" {{ request('filter') == 'completed' ? 'selected' : '' }}>✅ Completed</option>
                    </select>

                    <select name="priority" class="bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-300 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Priority</option>
                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>🟢 Low</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>🔴 High</option>
                    </select>

                    <select name="category" class="bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-300 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>📁 {{ $category->name }}</option>
                        @endforeach
                    </select>

                    <label class="flex items-center gap-2 bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-300 cursor-pointer hover:bg-slate-800 transition">
                        <input type="checkbox" name="favorite" value="1" {{ request('favorite') == '1' ? 'checked' : '' }}
                            class="w-4 h-4 rounded border-slate-700 bg-slate-800 text-blue-600 focus:ring-blue-500">
                        <span>⭐ Favorites</span>
                    </label>

                    <div class="flex gap-2 ml-auto">
                        <button type="submit" class="bg-white text-slate-900 px-6 py-3 rounded-xl hover:bg-blue-400 transition font-bold shadow-lg">Apply</button>
                        <a href="{{ route('tasks.index') }}" class="bg-slate-700 text-white p-3 rounded-xl hover:bg-slate-600 transition shadow-lg">🔄</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-6 py-4 rounded-2xl flex items-center gap-4 shadow-2xl animate-bounce">
        <div class="bg-emerald-500 text-white p-1 rounded-full">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
        </div>
        <span class="font-bold">{{ session('success') }}</span>
    </div>
    @endif

    {{-- Tasks List --}}
    @if($tasks->isEmpty())
    <div class="bg-slate-800/30 border-2 border-dashed border-slate-700 rounded-[2.5rem] p-20 text-center">
        <div class="bg-slate-800 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 shadow-2xl">
            <span class="text-4xl">🏝️</span>
        </div>
        <h3 class="text-2xl font-black text-slate-200 mb-2">Everything's Done!</h3>
        <p class="text-slate-500 max-w-sm mx-auto mb-8 text-lg">No tasks found matching your filters. Take a break or create something new.</p>
        <a href="{{ route('tasks.create') }}" class="bg-blue-600 text-white px-10 py-4 rounded-2xl font-bold hover:bg-blue-500 transition shadow-xl">Start New Project</a>
    </div>
    @else
    <div class="grid gap-5">
        @foreach($tasks as $task)
        <div class="bg-slate-800/40 border border-slate-700/50 rounded-[2rem] p-6 hover:bg-slate-800 hover:border-blue-500/30 transition-all duration-300 group shadow-lg hover:shadow-blue-900/10 relative overflow-hidden">
            
            {{-- Background Decoration --}}
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-600/5 rounded-full -mr-16 -mt-16 group-hover:bg-blue-600/10 transition-all"></div>

            <div class="flex flex-col sm:flex-row items-start gap-6 relative z-10">
                {{-- Status Toggle Button --}}
                <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="mt-1">
                    @csrf @method('PATCH')
                    <button type="submit" class="focus:outline-none transition transform active:scale-90">
                        @if($task->is_completed)
                            <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center shadow-lg shadow-emerald-900/40">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        @else
                            <div class="w-8 h-8 border-2 border-slate-600 rounded-full hover:border-blue-500 transition-colors bg-slate-900/50 shadow-inner"></div>
                        @endif
                    </button>
                </form>

                {{-- Task Content --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-4 mb-2">
                        <div>
                            <h3 class="text-xl font-bold text-slate-100 group-hover:text-white transition-colors {{ $task->is_completed ? 'line-through opacity-40' : '' }}">
                                {{ $task->title }}
                            </h3>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="text-[10px] font-black text-slate-500 uppercase tracking-tighter italic">Created {{ $task->created_at->diffForHumans() }}</span>
                                @if($task->is_completed)
                                    <span class="bg-emerald-500/10 text-emerald-400 text-[10px] font-bold px-2 py-0.5 rounded-md border border-emerald-500/20 uppercase">Completed</span>
                                @endif
                            </div>
                        </div>

                        {{-- Favorite Button --}}
                        <form action="{{ route('tasks.favorite', $task) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-2xl hover:scale-125 transition-transform p-2 bg-slate-900/40 rounded-xl border border-slate-700/50">
                                {{ $task->is_favorite ? '⭐' : '☆' }}
                            </button>
                        </form>
                    </div>

                    @if($task->description)
                    <p class="text-slate-400 text-sm mb-4 leading-relaxed line-clamp-2 {{ $task->is_completed ? 'opacity-30' : '' }}">
                        {{ $task->description }}
                    </p>
                    @endif

                    <div class="flex flex-wrap items-center justify-between gap-4 mt-4 pt-4 border-t border-slate-700/30">
                        {{-- Badges --}}
                        <div class="flex flex-wrap gap-2">
                            @if($task->priority == 'high')
                                <span class="bg-red-500/10 text-red-500 text-[11px] font-bold px-3 py-1 rounded-lg border border-red-500/20">🔥 High Priority</span>
                            @elseif($task->priority == 'medium')
                                <span class="bg-amber-500/10 text-amber-500 text-[11px] font-bold px-3 py-1 rounded-lg border border-amber-500/20">⚡ Medium</span>
                            @else
                                <span class="bg-blue-500/10 text-blue-500 text-[11px] font-bold px-3 py-1 rounded-lg border border-blue-500/20">🌱 Low</span>
                            @endif

                            @if($task->category)
                                <span class="bg-purple-500/10 text-purple-400 text-[11px] font-bold px-3 py-1 rounded-lg border border-purple-500/20">
                                    📁 {{ $task->category->name }}
                                </span>
                            @endif
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center gap-1">
                            <a href="{{ route('tasks.edit', $task) }}" class="p-2.5 bg-slate-900/50 text-blue-400 hover:bg-blue-600 hover:text-white rounded-xl transition-all shadow-lg" title="Edit Task">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Move to trash?')" class="p-2.5 bg-slate-900/50 text-red-400 hover:bg-red-600 hover:text-white rounded-xl transition-all shadow-lg" title="Delete Task">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Task Image (Professional Placement) --}}
                @if($task->image)
                <div class="w-24 h-24 sm:w-32 sm:h-32 flex-shrink-0 group-hover:scale-105 transition-transform">
                    <img src="{{ asset('storage/' . $task->image) }}" alt="Task" class="w-full h-full rounded-2xl object-cover shadow-2xl border border-slate-700/50">
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<style>
    @keyframes fade-in { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-in { animation: fade-in 0.6s ease-out forwards; }
</style>
@endsection