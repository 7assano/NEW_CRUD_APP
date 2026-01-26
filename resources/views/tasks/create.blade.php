@extends('layouts.app')

@section('content')
<div class="bg-slate-800 shadow-xl rounded-2xl p-6 border border-slate-700">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-100">Add New Task</h1>
        <p class="text-slate-400 text-sm">Enter the details of the task you want to accomplish.</p>
    </div>

    @if ($errors->any())
    <div class="bg-red-900/20 border border-red-900/50 text-red-400 p-4 rounded-xl mb-6 text-sm">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        {{-- Title --}}
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-1">Task Title *</label>
            <input type="text" name="title" value="{{ old('title') }}" required
                class="w-full bg-slate-900 border-slate-700 text-slate-100 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border outline-none transition"
                placeholder="e.g., Buy household supplies">
        </div>

        {{-- Description --}}
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-1">Description (Optional)</label>
            <textarea name="description" rows="3"
                class="w-full bg-slate-900 border-slate-700 text-slate-100 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border outline-none transition"
                placeholder="Add more details here...">{{ old('description') }}</textarea>
        </div>

        {{-- Priority --}}
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-1">Priority *</label>
            <select name="priority" required class="w-full bg-slate-900 border-slate-700 text-slate-100 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border outline-none transition">
                <option value="">Select Priority</option>
                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>🟢 Low</option>
                <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>🔴 High</option>
            </select>
        </div>

        {{-- Category --}}
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-1">Category (Optional)</label>
            <select name="category_id" class="w-full bg-slate-900 border-slate-700 text-slate-100 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border outline-none transition">
                <option value="">No Category</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- Image Upload --}}
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-1">Image (Optional)</label>
            <input type="file" name="image" accept="image/*"
                class="w-full bg-slate-900 border-slate-700 text-slate-100 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border outline-none transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
            <p class="text-xs text-slate-500 mt-1">Max size: 2MB. Supported: JPG, PNG, GIF</p>
        </div>

        {{-- Buttons --}}
        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold transition shadow-lg shadow-blue-900/20">
                💾 Save Task
            </button>
            <a href="{{ route('tasks.index') }}" class="text-slate-400 hover:text-slate-200 text-sm font-medium transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection