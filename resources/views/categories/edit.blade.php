@extends('layouts.app')

@section('content')
<div class="bg-slate-800 shadow-xl rounded-2xl p-6 border border-slate-700 max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-100">✏️ Edit Category</h1>
        <p class="text-slate-400 text-sm">Update the category name.</p>
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

    <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-slate-300 mb-1">Category Name *</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                class="w-full bg-slate-900 border-slate-700 text-slate-100 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border outline-none transition"
                placeholder="e.g., Work, Personal, Shopping">
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-xl font-bold transition shadow-lg shadow-green-900/20">
                💾 Update Category
            </button>
            <a href="{{ route('categories.index') }}" class="text-slate-400 hover:text-slate-200 text-sm font-medium transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection