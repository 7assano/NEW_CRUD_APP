@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 animate-in fade-in duration-700">
    
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-purple-500/10 rounded-xl flex items-center justify-center text-purple-500 border border-purple-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Collections</h1>
            </div>
            <p class="text-slate-500 text-sm font-medium">Organize your tasks into meaningful groups and categories.</p>
        </div>

        <a href="{{ route('categories.create') }}" class="group bg-purple-600 hover:bg-purple-500 text-white px-6 py-3.5 rounded-2xl font-bold transition-all duration-300 flex items-center gap-2 shadow-xl shadow-purple-900/40 active:scale-95">
            <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Category
        </a>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
    <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-6 py-4 rounded-2xl flex items-center gap-3 animate-in zoom-in duration-300">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
        <span class="font-bold">{{ session('success') }}</span>
    </div>
    @endif

    {{-- Categories Grid --}}
    @if($categories->isEmpty())
    <div class="bg-slate-800/30 border-2 border-dashed border-slate-700/50 rounded-[2.5rem] p-24 text-center">
        <div class="w-24 h-24 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6 shadow-2xl">
            <span class="text-4xl">📁</span>
        </div>
        <h3 class="text-2xl font-black text-slate-400 mb-2">No Categories Yet</h3>
        <p class="text-slate-600 max-w-xs mx-auto mb-10 text-lg font-medium">Create categories to group your tasks by work, home, or hobbies.</p>
        <a href="{{ route('categories.create') }}" class="bg-purple-600 text-white px-10 py-4 rounded-2xl font-bold hover:bg-purple-500 transition-all shadow-xl shadow-purple-900/20 active:scale-95">Start Organizing</a>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $category)
        <div class="bg-slate-800/40 border border-slate-700/50 rounded-[2rem] p-6 hover:bg-slate-800 hover:border-purple-500/30 transition-all duration-300 group shadow-lg hover:shadow-purple-900/10 relative overflow-hidden">
            
            <div class="flex items-start justify-between relative z-10">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-purple-600/10 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform duration-500">
                        📁
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white group-hover:text-purple-400 transition-colors">{{ $category->name }}</h3>
                        <p class="text-slate-500 text-xs font-black uppercase tracking-widest mt-1">{{ $category->tasks_count ?? 0 }} Tasks Linked</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 mt-8 pt-4 border-t border-slate-700/30 relative z-10">
                <a href="{{ route('categories.edit', $category) }}" class="p-2.5 bg-slate-900/50 text-blue-400 hover:bg-blue-600 hover:text-white rounded-xl transition-all shadow-lg" title="Edit Category">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </a>
                <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('⚠️ Careful: Deleting this category will un-categorize its tasks. Continue?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="p-2.5 bg-slate-900/50 text-red-400 hover:bg-red-600 hover:text-white rounded-xl transition-all shadow-lg" title="Delete Category">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
            </div>

            {{-- Background Decoration --}}
            <div class="absolute top-0 right-0 w-32 h-32 bg-purple-600/5 rounded-full -mr-16 -mt-16 group-hover:bg-purple-600/10 transition-all"></div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection