@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
    
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-red-500/10 rounded-xl flex items-center justify-center text-red-500 border border-red-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Trash Bin</h1>
            </div>
            <p class="text-slate-500 text-sm font-medium">Items here will stay until you permanently delete them or empty the trash.</p>
        </div>

        @if($trashedTasks->count() > 0)
        <form action="{{ route('trash.empty') }}" method="POST" onsubmit="return confirm('⚠️ Danger: Permanently delete ALL tasks? This action is irreversible!')">
            @csrf @method('DELETE')
            <button type="submit" class="bg-red-600/10 hover:bg-red-600 text-red-500 hover:text-white px-6 py-3.5 rounded-2xl font-bold transition-all duration-300 border border-red-600/20 shadow-lg shadow-red-900/10 flex items-center gap-2 group">
                <svg class="w-5 h-5 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Empty Everything
            </button>
        </form>
        @endif
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
    <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-6 py-4 rounded-2xl flex items-center gap-3 animate-in zoom-in duration-300">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
        <span class="font-bold">{{ session('success') }}</span>
    </div>
    @endif

    {{-- Trashed Tasks List --}}
    @if($trashedTasks->isEmpty())
    <div class="bg-slate-800/30 border-2 border-dashed border-slate-700/50 rounded-[2.5rem] p-24 text-center">
        <div class="w-24 h-24 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6 shadow-2xl grayscale">
            <svg class="w-12 h-12 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
        </div>
        <h3 class="text-2xl font-black text-slate-400 mb-2">Trash is empty</h3>
        <p class="text-slate-600 max-w-xs mx-auto mb-10 text-lg font-medium">No deleted tasks found. Your workspace is tidy!</p>
        <a href="{{ route('tasks.index') }}" class="bg-blue-600 text-white px-10 py-4 rounded-2xl font-bold hover:bg-blue-500 transition-all shadow-xl shadow-blue-900/20 active:scale-95">
            ← Back to Workspace
        </a>
    </div>
    @else
    <div class="grid gap-4">
        @foreach($trashedTasks as $task)
        <div class="bg-slate-800/40 border border-red-500/10 rounded-[2rem] p-6 hover:bg-slate-800 transition-all duration-300 group opacity-80 hover:opacity-100 relative overflow-hidden">
            
            {{-- Status Watermark --}}
            <div class="absolute top-1/2 -right-4 -translate-y-1/2 text-7xl font-black text-red-500/5 rotate-12 pointer-events-none select-none">DELETED</div>

            <div class="flex flex-col sm:flex-row items-start gap-6 relative z-10">
                {{-- Task Image --}}
                @if($task->image)
                <div class="w-20 h-20 sm:w-28 sm:h-28 flex-shrink-0 grayscale opacity-40 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-500">
                    <img src="{{ asset('storage/' . $task->image) }}" alt="Task" class="w-full h-full rounded-2xl object-cover border border-slate-700/50">
                </div>
                @endif

                {{-- Task Content --}}
                <div class="flex-1 min-w-0">
                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-slate-400 line-through group-hover:text-slate-200 transition-colors">
                            {{ $task->title }}
                        </h3>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-[10px] font-black text-red-500/60 uppercase tracking-widest italic">Removed {{ $task->deleted_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    @if($task->description)
                    <p class="text-slate-600 text-sm mb-5 italic line-through decoration-slate-700">
                        {{ $task->description }}
                    </p>
                    @endif

                    <div class="flex flex-wrap items-center justify-between gap-4 pt-5 border-t border-slate-700/30">
                        {{-- Meta Badges --}}
                        <div class="flex flex-wrap gap-2">
                            @if($task->priority == 'high')
                                <span class="bg-red-900/20 text-red-500 text-[10px] font-bold px-3 py-1 rounded-lg border border-red-900/30 grayscale">🔥 High</span>
                            @endif
                            @if($task->category)
                                <span class="bg-slate-900/40 text-slate-500 text-[10px] font-bold px-3 py-1 rounded-lg border border-slate-700/50">📁 {{ $task->category->name }}</span>
                            @endif
                        </div>

                        {{-- Action Controls --}}
                        <div class="flex items-center gap-3">
                            <form action="{{ route('trash.restore', $task->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="flex items-center gap-2 bg-emerald-500/10 text-emerald-500 hover:bg-emerald-500 hover:text-white px-5 py-2.5 rounded-xl text-xs font-bold transition-all active:scale-95">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                    Restore Task
                                </button>
                            </form>

                            <form action="{{ route('trash.forceDelete', $task->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('⚠️ Careful: This will permanently erase the task!')" class="flex items-center gap-2 bg-red-600/10 text-red-400 hover:bg-red-600 hover:text-white px-5 py-2.5 rounded-xl text-xs font-bold transition-all active:scale-95">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Wipe Forever
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection