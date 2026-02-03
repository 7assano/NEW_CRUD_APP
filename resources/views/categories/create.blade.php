@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto animate-in fade-in slide-in-from-bottom-6 duration-700">
    
    <div class="mb-8">
        <a href="{{ route('categories.index') }}" class="inline-flex items-center text-slate-500 hover:text-purple-400 transition-colors font-bold text-sm group">
            <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            Back to Collections
        </a>
    </div>

    <div class="bg-slate-800/40 backdrop-blur-xl shadow-2xl rounded-[2.5rem] p-10 md:p-14 border border-slate-700/50 relative overflow-hidden">
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-purple-600/10 rounded-full blur-[80px]"></div>
        
        <div class="relative z-10">
            <div class="mb-12">
                <h1 class="text-3xl font-black text-white tracking-tight">New Category</h1>
                <p class="text-slate-500 mt-2 font-medium">Create a label to organize your workflow better.</p>
            </div>

            <form action="{{ route('categories.store') }}" method="POST" class="space-y-10">
                @csrf
                <div class="group">
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4 ml-1 group-focus-within:text-purple-400 transition-colors">Category Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full bg-slate-900/50 border border-slate-700/50 text-slate-100 rounded-2xl py-5 px-6 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all outline-none font-bold text-lg placeholder:text-slate-700"
                        placeholder="e.g., Personal, Urgent, Work...">
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-6 pt-4">
                    <button type="submit" class="w-full sm:w-auto bg-purple-600 hover:bg-purple-500 text-white px-12 py-4 rounded-2xl font-black uppercase tracking-widest transition-all shadow-xl shadow-purple-900/40 active:scale-95 flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                        Create Category
                    </button>
                    <a href="{{ route('categories.index') }}" class="text-slate-500 hover:text-slate-200 text-sm font-black uppercase tracking-[0.2em] transition-colors">
                        Discard
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection