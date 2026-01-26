@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-100">🗑️ Trash</h1>
            <p class="text-slate-400">Deleted tasks (can be restored or permanently deleted).</p>
        </div>

        @if($trashedTasks->count() > 0)
        <form action="{{ route('trash.empty') }}" method="POST" onsubmit="return confirm('⚠️ Permanently delete ALL tasks? This cannot be undone!')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-bold transition shadow-lg">
                🗑️ Empty Trash
            </button>
        </form>
        @endif
    </div>

    @if(session('success'))
    <div class="bg-emerald-900/20 border border-emerald-800/50 text-emerald-400 px-4 py-3 rounded-xl flex items-center gap-3">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if($trashedTasks->isEmpty())
    <div class="bg-slate-800 border border-slate-700 rounded-2xl p-12 text-center">
        <div class="text-slate-500 mb-4">
            <svg class="w-20 h-20 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
        </div>
        <h3 class="text-xl font-semibold text-slate-300 mb-2">Trash is empty</h3>
        <p class="text-slate-500 mb-6">No deleted tasks found.</p>
        <a href="{{ route('tasks.index') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition">
            ← Back to Tasks
        </a>
    </div>
    @else
    <div class="grid gap-4">
        @foreach($trashedTasks as $task)
        <div class="bg-slate-800 border border-red-900/50 rounded-2xl p-5 hover:border-red-800 transition-all opacity-75">
            <div class="flex items-start gap-4">
                {{-- Task Image --}}
                @if($task->image)
                <img src="{{ asset('storage/' . $task->image) }}" alt="Task" class="w-16 h-16 rounded-lg object-cover opacity-50">
                @endif

                {{-- Task Content --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-3 mb-2">
                        <h3 class="text-lg font-semibold text-slate-300 line-through">
                            {{ $task->title }}
                        </h3>
                    </div>

                    @if($task->description)
                    <p class="text-slate-500 text-sm mb-3 line-through">
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

                        {{-- Deleted Badge --}}
                        <span class="bg-red-900/30 text-red-400 text-xs px-2 py-1 rounded-full border border-red-800">
                            🗑️ Deleted {{ $task->deleted_at->diffForHumans() }}
                        </span>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 text-sm">
                        <form action="{{ route('trash.restore', $task->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-green-400 hover:text-green-300 font-medium">
                                ↩️ Restore
                            </button>
                        </form>
                        <span class="text-slate-600">•</span>
                        <form action="{{ route('trash.forceDelete', $task->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('⚠️ Permanently delete this task? This cannot be undone!')" class="text-red-400 hover:text-red-300 font-medium">
                                ❌ Delete Forever
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection