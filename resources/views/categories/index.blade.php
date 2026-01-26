@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-100">📁 Categories</h1>
            <p class="text-slate-400">Manage your task categories.</p>
        </div>

        <a href="{{ route('categories.create') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            New Category
        </a>
    </div>

    @if(session('success'))
    <div class="bg-emerald-900/20 border border-emerald-800/50 text-emerald-400 px-4 py-3 rounded-xl flex items-center gap-3">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if($categories->isEmpty())
    <div class="bg-slate-800 border border-slate-700 rounded-2xl p-12 text-center">
        <div class="text-slate-500 mb-4">
            <svg class="w-20 h-20 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
            </svg>
        </div>
        <h3 class="text-xl font-semibold text-slate-300 mb-2">No categories yet</h3>
        <p class="text-slate-500 mb-6">Create your first category to organize your tasks!</p>
        <a href="{{ route('categories.create') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Create Category
        </a>
    </div>
    @else
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($categories as $category)
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 hover:border-slate-600 transition-all">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-purple-600/20 border border-purple-600/50 rounded-xl flex items-center justify-center text-2xl">
                        📁
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-100">{{ $category->name }}</h3>
                        <p class="text-sm text-slate-400">{{ $category->tasks_count }} tasks</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2 text-sm pt-4 border-t border-slate-700">
                <a href="{{ route('categories.edit', $category) }}" class="text-blue-400 hover:text-blue-300 font-medium">
                    ✏️ Edit
                </a>
                <span class="text-slate-600">•</span>
                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this category? Tasks will not be deleted.')" class="text-red-400 hover:text-red-300 font-medium">
                        🗑️ Delete
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection