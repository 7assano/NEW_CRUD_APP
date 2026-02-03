@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">الملف الشخصي</h2>

        <div class="flex items-center mb-8 pb-6 border-b">
            <div class="relative">
                <img src="{{ $user->avatar_url }}" alt="Avatar" class="w-24 h-24 rounded-full object-cover border-4 border-indigo-100">
                <form action="{{ route('profile.avatar.upload') }}" method="POST" enctype="multipart/form-data" class="mt-2">
                    @csrf
                    <input type="file" name="avatar" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" onchange="this.form.submit()">
                </form>
            </div>
            <div class="mr-6">
                <h3 class="text-xl font-semibold">{{ $user->name }}</h3>
                <p class="text-gray-600">{{ $user->email }}</p>
            </div>
        </div>

        <form action="{{ route('profile.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">السيرة الذاتية (Bio)</label>
                <textarea name="bio" rows="3" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">رقم الهاتف</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->profile->phone ?? '') }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">العنوان</label>
                    <input type="text" name="address" value="{{ old('address', $user->profile->address ?? '') }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                    حفظ التغييرات
                </button>
            </div>
        </form>
    </div>
</div>
@endsection