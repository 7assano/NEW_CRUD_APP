@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-slate-800 p-8 rounded-2xl shadow-xl border border-slate-700">
    <h2 class="text-2xl font-bold mb-6 text-center text-slate-100">Create Account</h2>

    @if ($errors->any())
    <div class="bg-red-900/20 border border-red-900/50 text-red-400 p-3 rounded-xl mb-4 text-sm">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('register') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-slate-300">Name</label>
            <input type="text" name="name" value="{{ old('name') }}"
                class="w-full mt-1 bg-slate-900 border-slate-700 text-slate-100 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 outline-none p-2 border">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-300">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                class="w-full mt-1 bg-slate-900 border-slate-700 text-slate-100 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 outline-none p-2 border">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-300">Password</label>
            <input type="password" name="password" 
                class="w-full mt-1 bg-slate-900 border-slate-700 text-slate-100 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 outline-none p-2 border">
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-900/20">
            Register
        </button>
    </form>
        
    <p class="mt-6 text-center text-sm text-slate-400">
        Already have an account? <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-medium">Login</a>
    </p>
</div>
@endsection