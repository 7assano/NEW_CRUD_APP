@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto animate-in fade-in slide-in-from-bottom-6 duration-700">
    
    {{-- Breadcrumb / Back Link --}}
    <div class="mb-8 flex items-center justify-between">
        <a href="{{ route('tasks.index') }}" class="inline-flex items-center text-slate-500 hover:text-blue-400 transition-colors font-bold text-sm group">
            <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            Back to Workspace
        </a>
        <span class="text-[10px] font-black text-slate-600 uppercase tracking-[0.3em]">Task Editor #{{ $task->id }}</span>
    </div>

    <div class="bg-slate-800/40 backdrop-blur-xl shadow-2xl rounded-[2.5rem] p-8 md:p-12 border border-slate-700/50 relative overflow-hidden">
        {{-- Background Decoration --}}
        <div class="absolute -top-24 -left-24 w-64 h-64 bg-emerald-600/10 rounded-full blur-[80px]"></div>
        
        <div class="relative z-10">
            <div class="mb-10 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-black text-white tracking-tight">Update Task</h1>
                    <p class="text-slate-500 mt-2 font-medium">Refine your task details and track your progress.</p>
                </div>
                @if($task->is_completed)
                    <div class="bg-emerald-500/10 text-emerald-400 px-4 py-2 rounded-xl border border-emerald-500/20 text-xs font-black uppercase tracking-widest">
                        Completed ✅
                    </div>
                @endif
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

            <form action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Title --}}
                    <div class="md:col-span-2 group">
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-[0.2em] mb-3 ml-1 group-focus-within:text-blue-400 transition-colors">Task Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $task->title) }}" required
                            class="w-full bg-slate-900/50 border border-slate-700/50 text-slate-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none font-bold placeholder:text-slate-600"
                            placeholder="e.g., Buy household supplies">
                    </div>

                    {{-- Description --}}
                    <div class="md:col-span-2 group">
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-[0.2em] mb-3 ml-1 group-focus-within:text-blue-400 transition-colors">Description (Optional)</label>
                        <textarea name="description" rows="4"
                            class="w-full bg-slate-900/50 border border-slate-700/50 text-slate-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none font-medium placeholder:text-slate-600"
                            placeholder="Add more details here...">{{ old('description', $task->description) }}</textarea>
                    </div>

                    {{-- Priority --}}
                    <div class="group">
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-[0.2em] mb-3 ml-1 group-focus-within:text-blue-400 transition-colors">Priority Level <span class="text-red-500">*</span></label>
                        <select name="priority" required class="w-full bg-slate-900/50 border border-slate-700/50 text-slate-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-blue-500 outline-none appearance-none transition-all font-bold">
                            <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }} class="bg-slate-900">🟢 Low Priority</option>
                            <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }} class="bg-slate-900">🟡 Medium Priority</option>
                            <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }} class="bg-slate-900">🔴 High Priority</option>
                        </select>
                    </div>

                    {{-- Category --}}
                    <div class="group">
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-[0.2em] mb-3 ml-1 group-focus-within:text-blue-400 transition-colors">Category</label>
                        <select name="category_id" class="w-full bg-slate-900/50 border border-slate-700/50 text-slate-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-blue-500 outline-none appearance-none transition-all font-bold">
                            <option value="" class="bg-slate-900">No Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $task->category_id) == $category->id ? 'selected' : '' }} class="bg-slate-900">
                                📁 {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Current & New Image Section --}}
                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-6 items-center bg-slate-900/30 p-6 rounded-[2rem] border border-slate-700/30">
                        @if($task->image)
                        <div class="text-center md:text-left">
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3">Current Image</label>
                            <div class="relative inline-block group">
                                <img src="{{ asset('storage/' . $task->image) }}" alt="Current" class="w-24 h-24 rounded-2xl object-cover ring-4 ring-slate-800 shadow-2xl transition-transform group-hover:scale-110 duration-500">
                                <div class="absolute -top-2 -right-2 bg-blue-600 text-[8px] font-black px-2 py-1 rounded-full uppercase text-white shadow-lg">Active</div>
                            </div>
                        </div>
                        @endif

                        <div class="{{ $task->image ? 'md:col-span-2' : 'md:col-span-3' }} group">
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-[0.2em] mb-3 group-focus-within:text-blue-400 transition-colors">
                                {{ $task->image ? 'Replace Image' : 'Add Attachment' }}
                            </label>
                            <input type="file" name="image" accept="image/*"
                                class="w-full bg-slate-800/50 border border-slate-700/50 text-slate-400 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-blue-500 transition-all outline-none file:mr-6 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-blue-600 file:text-white hover:file:bg-blue-500 cursor-pointer">
                        </div>
                    </div>

                    {{-- Status Switch --}}
                    <div class="md:col-span-2">
                        <label for="is_completed" class="flex items-center gap-4 bg-slate-900/50 p-5 rounded-2xl border border-slate-700/50 hover:border-emerald-500/30 transition-all cursor-pointer group">
                            <div class="relative">
                                <input type="checkbox" name="is_completed" id="is_completed" {{ $task->is_completed ? 'checked' : '' }}
                                    class="w-6 h-6 rounded-lg border-slate-700 bg-slate-800 text-emerald-500 focus:ring-emerald-500 focus:ring-offset-slate-900 transition-all cursor-pointer">
                            </div>
                            <div class="flex-1">
                                <span class="block text-sm font-black text-slate-200 group-hover:text-white transition-colors">Mark as Completed</span>
                                <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Turn this on if you've finished the task</span>
                            </div>
                            @if($task->is_completed)
                                <span class="text-2xl animate-bounce">✨</span>
                            @endif
                        </label>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row items-center gap-6 pt-10 border-t border-slate-700/30">
                    <button type="submit" class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-500 text-white px-12 py-4 rounded-2xl font-black uppercase tracking-widest transition-all shadow-xl shadow-emerald-900/40 active:scale-95 flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 4h16v16H4V4z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v8m-4-4h8"></path></svg>
                        Save Changes
                    </button>
                    <a href="{{ route('tasks.index') }}" class="text-slate-500 hover:text-slate-200 text-sm font-black uppercase tracking-[0.2em] transition-colors">
                        Discard Edits
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection