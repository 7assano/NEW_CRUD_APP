@extends('layouts.guest')

@section('content')
<div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700 rounded-2xl shadow-2xl p-8">
    {{-- Logo --}}
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center text-white font-bold text-3xl mx-auto mb-4">
            T
        </div>
        <h1 class="text-3xl font-bold text-white mb-2">Create Account</h1>
        <p class="text-slate-400">Start organizing your tasks today</p>
    </div>

    {{-- Error Messages --}}
    @if ($errors->any())
    <div class="bg-red-900/20 border border-red-900/50 text-red-400 p-4 rounded-xl mb-6 text-sm">
        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Register Form --}}
    <form action="{{ route('register') }}" method="POST" class="space-y-5">
        @csrf

        {{-- Name --}}
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                class="w-full bg-slate-900 border-slate-700 text-slate-100 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border outline-none transition"
                placeholder="John Doe">
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full bg-slate-900 border-slate-700 text-slate-100 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border outline-none transition"
                placeholder="your@email.com">
        </div>

        {{-- Password --}}
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Password</label>
            <input type="password" name="password" required
                class="w-full bg-slate-900 border-slate-700 text-slate-100 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border outline-none transition"
                placeholder="••••••••">
        </div>

        {{-- Confirm Password --}}
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Confirm Password</label>
            <input type="password" name="password_confirmation" required
                class="w-full bg-slate-900 border-slate-700 text-slate-100 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border outline-none transition"
                placeholder="••••••••">
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-3 rounded-xl transition shadow-lg">
            🚀 Create Account
        </button>
    </form>

    {{-- Login Link --}}
    <div class="mt-6 text-center">
        <p class="text-slate-400 text-sm">
            Already have an account?
            <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-semibold">
                Sign in
            </a>
        </p>
    </div>
</div>
@endsection