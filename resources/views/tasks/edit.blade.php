@extends('layouts.app')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Task</h1>
    </div>

    <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Task Title</label>
            <input type="text" name="title" value="{{ $task->title }}" 
                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="3" 
                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">{{ $task->description }}</textarea>
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="is_completed" id="is_completed" {{ $task->is_completed ? 'checked' : '' }}
                   class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
            <label for="is_completed" class="mr-2 block text-sm text-gray-900">
                Mark as completed
            </label>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md font-medium transition">
                Update Task
            </button>
            <a href="{{ route('tasks.index') }}" class="text-gray-600 hover:text-gray-800 text-sm">
                Back
            </a>
        </div>
    </form>
</div>
@endsection