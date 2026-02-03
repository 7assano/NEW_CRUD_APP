@extends('layouts.guest')

@section('content')
<div class="relative animate-in fade-in zoom-in duration-700">
    {{-- Decorative Background Glows --}}
    <div class="absolute -top-20 -left-20 w-40 h-40 bg-blue-600/20 rounded-full blur-[80px]"></div>
    <div class="absolute -bottom-20 -right-20 w-40 h-40 bg-purple-600/20 rounded-full blur-[80px]"></div>

    <div class="bg-slate-800/40 backdrop-blur-2xl border border-slate-700/50 rounded-[2.5rem] shadow-2xl p-10 relative overflow-hidden">
        
        {{-- Header Section --}}
        <div class="text-center mb-10">
            <div class="w-20 h-20 bg-gradient-to-tr from-blue-600 via-indigo-600 to-purple-500 rounded-3xl flex items-center justify-center text-white font-black text-4xl mx-auto mb-6 shadow-2xl shadow-blue-900/40 rotate-6 hover:rotate-0 transition-transform duration-500">
                T
            </div>
            <h1 class="text-3xl font-black text-white tracking-tight mb-2 uppercase italic">Welcome Back</h1>
            <p class="text-slate-500 font-bold text-sm tracking-wide">Enter your credentials to continue</p>
        </div>

        {{-- Error Messages --}}
        @if ($errors->any())
        <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-2xl mb-8 flex gap-3 items-center animate-in slide-in-from-top duration-300">
            <span class="text-xl">⚠️</span>
            <ul class="text-xs font-black uppercase tracking-wider list-none space-y-1">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Login Form --}}
        <form action="{{ route('login') }}" method="POST" class="space-y-8">
            @csrf

            {{-- Email Field --}}
            <div class="group">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 ml-1 group-focus-within:text-blue-400 transition-colors">Registered Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-600 group-focus-within:text-blue-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                    </div>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full bg-slate-900/50 border border-slate-700/50 text-white rounded-2xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none font-bold placeholder:text-slate-700"
                        placeholder="name@example.com">
                </div>
            </div>

            {{-- Password Field --}}
            <div class="group">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3 ml-1 group-focus-within:text-blue-400 transition-colors">Secure Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-600 group-focus-within:text-blue-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <input type="password" name="password" required
                        class="w-full bg-slate-900/50 border border-slate-700/50 text-white rounded-2xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none font-bold placeholder:text-slate-700"
                        placeholder="••••••••">
                </div>
            </div>

            {{-- Remember & Forgot Section --}}
            <div class="flex items-center justify-between px-1">
                <label class="flex items-center cursor-pointer group/check">
                    <input type="checkbox" name="remember" id="remember"
                        class="h-5 w-5 bg-slate-900 border-slate-700 rounded text-blue-600 focus:ring-blue-500 focus:ring-offset-slate-800 transition-all cursor-pointer">
                    <span class="ml-3 text-xs font-bold text-slate-500 group-hover/check:text-slate-300 transition-colors">Remember Session</span>
                </label>
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 hover:scale-[1.02] active:scale-95 text-white font-black uppercase tracking-[0.2em] py-4 rounded-2xl transition-all shadow-xl shadow-blue-900/40 flex items-center justify-center gap-3">
                🔓 Secure Sign In
            </button>
        </form>

        {{-- Footer Link --}}
        <div class="mt-10 text-center border-t border-slate-700/30 pt-8">
            <p class="text-slate-500 text-[11px] font-bold uppercase tracking-widest">
                New to Taskly?
                <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 ml-2 transition-colors">
                    Create Workspace
                </a>
            </p>
        </div>
    </div>
</div>
@endsection