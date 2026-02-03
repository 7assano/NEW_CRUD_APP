@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto animate-in fade-in slide-in-from-bottom-6 duration-700">
    
    {{-- Breadcrumb / Back Link --}}
    <div class="mb-8">
        <a href="{{ route('tasks.index') }}" class="inline-flex items-center text-slate-500 hover:text-blue-400 transition-colors font-bold text-sm group">
            <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            Back to Dashboard
        </a>
    </div>

    <div class="bg-slate-800/40 backdrop-blur-xl shadow-2xl rounded-[2.5rem] p-8 md:p-12 border border-slate-700/50 relative overflow-hidden">
        {{-- Decoration --}}
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-blue-600/10 rounded-full blur-[80px]"></div>
        
        <div class="relative z-10">
            <div class="mb-10">
                <h1 class="text-3xl font-black text-white tracking-tight">Create New Task</h1>
                <p class="text-slate-500 mt-2 font-medium">Define your goals and set your priorities for a productive day.</p>
            </div>

            {{-- Error Notifications --}}
            @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-5 rounded-2xl mb-8 flex gap-4">
                <div class="shrink-0 text-2xl">⚠️</div>
                <ul class="text-sm font-bold list-none space-y-1">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Title --}}
                    <div class="md:col-span-2 group">
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-[0.2em] mb-3 ml-1 group-focus-within:text-blue-400 transition-colors">Task Title <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="text" name="title" value="{{ old('title') }}" required
                                class="w-full bg-slate-900/50 border border-slate-700/50 text-slate-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none font-bold placeholder:text-slate-600"
                                placeholder="What needs to be done?">
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="md:col-span-2 group">
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-[0.2em] mb-3 ml-1 group-focus-within:text-blue-400 transition-colors">Description (Optional)</label>
                        <textarea name="description" rows="4"
                            class="w-full bg-slate-900/50 border border-slate-700/50 text-slate-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none font-medium placeholder:text-slate-600"
                            placeholder="Add more context or details...">{{ old('description') }}</textarea>
                    </div>

                    {{-- Priority --}}
                    <div class="group">
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-[0.2em] mb-3 ml-1 group-focus-within:text-blue-400 transition-colors">Priority Level <span class="text-red-500">*</span></label>
                        <select name="priority" required class="w-full bg-slate-900/50 border border-slate-700/50 text-slate-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-blue-500 outline-none appearance-none transition-all font-bold">
                            <option value="" class="bg-slate-900">Choose Importance</option>
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }} class="bg-slate-900">🟢 Low Priority</option>
                            <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }} class="bg-slate-900">🟡 Medium Priority</option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }} class="bg-slate-900">🔴 High Priority</option>
                        </select>
                    </div>

                    {{-- Category --}}
                    <div class="group">
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-[0.2em] mb-3 ml-1 group-focus-within:text-blue-400 transition-colors">Category (Optional)</label>
                        <select name="category_id" class="w-full bg-slate-900/50 border border-slate-700/50 text-slate-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-blue-500 outline-none appearance-none transition-all font-bold">
                            <option value="" class="bg-slate-900">General</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }} class="bg-slate-900">
                                📁 {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Image Upload --}}
                    <div class="md:col-span-2 group">
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-[0.2em] mb-3 ml-1 group-focus-within:text-blue-400 transition-colors">Attachment (Image)</label>
                        <div class="relative">
                            <input type="file" name="image" accept="image/*"
                                class="w-full bg-slate-900/50 border border-slate-700/50 text-slate-400 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-blue-500 transition-all outline-none file:mr-6 file:py-2.5 file:px-6 file:rounded-xl file:border-0 file:text-[11px] file:font-black file:uppercase file:bg-blue-600 file:text-white hover:file:bg-blue-500 file:transition-all cursor-pointer">
                        </div>
                        <p class="text-[10px] text-slate-600 mt-3 font-bold uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"></path></svg>
                            JPG, PNG, GIF (Max 2MB)
                        </p>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row items-center gap-6 pt-10 border-t border-slate-700/30">
                    <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-500 text-white px-12 py-4 rounded-2xl font-black uppercase tracking-widest transition-all shadow-xl shadow-blue-900/40 active:scale-95 flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        Confirm & Save
                    </button>
                    <a href="{{ route('tasks.index') }}" class="text-slate-500 hover:text-slate-200 text-sm font-black uppercase tracking-[0.2em] transition-colors">
                        Discard Changes
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection