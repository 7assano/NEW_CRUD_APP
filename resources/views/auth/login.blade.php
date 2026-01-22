@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-slate-800 p-8 rounded-2xl shadow-xl border border-slate-700">
    <h2 class="text-2xl font-bold mb-6 text-center text-slate-100">Login</h2>

    @if ($errors->any())
        <div class="bg-red-900/20 border border-red-900/50 text-red-400 p-3 rounded-xl mb-4 text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-slate-300">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required 
                   class="w-full mt-1 bg-slate-900 border border-slate-700 text-slate-100 rounded-lg shadow-sm p-2.5 focus:border-blue-500 focus:ring-blue-500 outline-none transition">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-slate-300">Password</label>
            <input type="password" name="password" required 
            class="w-full mt-1 bg-slate-900 border border-slate-700 text-slate-100 rounded-lg shadow-sm p-2.5 focus:border-blue-500 focus:ring-blue-500 outline-none transition">
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-lg font-bold hover:bg-blue-700 transition duration-200 shadow-lg shadow-blue-900/20">
            Login
        </button>
    </form>
    
    <p class="mt-6 text-center text-sm text-slate-400">
        Don't have an account? <a href="{{ route('register') }}" class="text-blue-400 font-semibold hover:text-blue-300 transition">Register now</a>
    </p>
</div>
@endsection