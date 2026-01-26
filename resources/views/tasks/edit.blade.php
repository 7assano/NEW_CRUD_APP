@extends('layouts.app')

@section('content')
<div class="bg-slate-800 shadow-xl rounded-2xl p-6 border border-slate-700">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-100">Edit Task</h1>
        <p class="text-slate-400 text-sm">Update the details of your task.</p>
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

    <form action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-1">Task Title *</label>
            <input type="text" name="title" value="{{ old('title', $task->title) }}" required
                class="w-full bg-slate-900 border-slate-700 text-slate-100 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border outline-none transition"
                placeholder="e.g., Buy household supplies">
        </div>

        {{-- Description --}}
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-1">Description (Optional)</label>
            <textarea name="description" rows="3"
                class="w-full bg-slate-900 border-slate-700 text-slate-100 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border outline-none transition"
                placeholder="Add more details here...">{{ old('description', $task->description) }}</textarea>
        </div>

        {{-- Priority --}}
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-1">Priority *</label>
            <select name="priority" required class="w-full bg-slate-900 border-slate-700 text-slate-100 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border outline-none transition">
                <option value="">Select Priority</option>
                <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>🟢 Low</option>
                <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>🔴 High</option>
            </select>
        </div>

        {{-- Category --}}
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-1">Category (Optional)</label>
            <select name="category_id" class="w-full bg-slate-900 border-slate-700 text-slate-100 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border outline-none transition">
                <option value="">No Category</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $task->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- Current Image --}}
        @if($task->image)
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Current Image</label>
            <div class="relative inline-block">
                <img src="{{ asset('storage/' . $task->image) }}" alt="Task Image" class="w-32 h-32 rounded-xl object-cover border-2 border-slate-700">
                <div class="absolute -top-2 -right-2 bg-red-600 text-white text-xs px-2 py-1 rounded-full">
                    Current
                </div>
            </div>
        </div>
        @endif

        {{-- Image Upload --}}
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-1">
                {{ $task->image ? 'Change Image (Optional)' : 'Add Image (Optional)' }}
            </label>
            <input type="file" name="image" accept="image/*"
                class="w-full bg-slate-900 border-slate-700 text-slate-100 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border outline-none transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
            <p class="text-xs text-slate-500 mt-1">Max size: 2MB. Supported: JPG, PNG, GIF</p>
        </div>

        {{-- Completed Checkbox --}}
        <div class="flex items-center gap-3 bg-slate-900 p-4 rounded-xl">
            <input type="checkbox" name="is_completed" id="is_completed" {{ $task->is_completed ? 'checked' : '' }}
                class="h-5 w-5 text-emerald-600 border-slate-600 rounded focus:ring-emerald-500 bg-slate-800">
            <label for="is_completed" class="text-slate-300 font-medium">
                Mark as completed ✅
            </label>
        </div>

        {{-- Buttons --}}
        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-xl font-bold transition shadow-lg shadow-green-900/20">
                💾 Update Task
            </button>
            <a href="{{ route('tasks.index') }}" class="text-slate-400 hover:text-slate-200 text-sm font-medium transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection