@extends('layouts.guest')

@section('content')
<div class="relative animate-in fade-in slide-in-from-bottom-8 duration-700">
    {{-- Decorative Background Glows --}}
    <div class="absolute -top-24 -right-24 w-48 h-48 bg-purple-600/20 rounded-full blur-[90px]"></div>
    <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-blue-600/20 rounded-full blur-[90px]"></div>

    <div class="bg-slate-800/40 backdrop-blur-2xl border border-slate-700/50 rounded-[2.5rem] shadow-2xl p-10 relative overflow-hidden">
        
        {{-- Header Section --}}
        <div class="text-center mb-10">
            <div class="w-20 h-20 bg-gradient-to-tr from-purple-600 via-blue-600 to-indigo-500 rounded-3xl flex items-center justify-center text-white font-black text-4xl mx-auto mb-6 shadow-2xl shadow-purple-900/40 -rotate-6 hover:rotate-0 transition-transform duration-500">
                T
            </div>
            <h1 class="text-3xl font-black text-white tracking-tight mb-2 uppercase italic">Join Taskly</h1>
            <p class="text-slate-500 font-bold text-sm tracking-wide">Create your workspace and start producing</p>
        </div>

        {{-- Error Messages --}}
        @if ($errors->any())
        <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-2xl mb-8 flex gap-3 items-center animate-in zoom-in duration-300">
            <span class="text-xl">⚠️</span>
            <ul class="text-xs font-black uppercase tracking-wider list-none space-y-1">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Registration Form --}}
        <form action="{{ route('register') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Name Field --}}
            <div class="group">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2.5 ml-1 group-focus-within:text-purple-400 transition-colors">Full Name</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-600 group-focus-within:text-purple-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full bg-slate-900/50 border border-slate-700/50 text-white rounded-2xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all outline-none font-bold placeholder:text-slate-700"
                        placeholder="e.g. Hassan Ahmed">
                </div>
            </div>

            {{-- Email Field --}}
            <div class="group">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2.5 ml-1 group-focus-within:text-blue-400 transition-colors">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-600 group-focus-within:text-blue-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full bg-slate-900/50 border border-slate-700/50 text-white rounded-2xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none font-bold placeholder:text-slate-700"
                        placeholder="name@workspace.com">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Password --}}
                <div class="group">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2.5 ml-1 group-focus-within:text-blue-400 transition-colors">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-600 group-focus-within:text-blue-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input type="password" name="password" required
                            class="w-full bg-slate-900/50 border border-slate-700/50 text-white rounded-2xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none font-bold placeholder:text-slate-700"
                            placeholder="••••••••">
                    </div>
                </div>

                {{-- Confirm Password --}}
                <div class="group">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2.5 ml-1 group-focus-within:text-emerald-400 transition-colors">Confirm</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-600 group-focus-within:text-emerald-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <input type="password" name="password_confirmation" required
                            class="w-full bg-slate-900/50 border border-slate-700/50 text-white rounded-2xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all outline-none font-bold placeholder:text-slate-700"
                            placeholder="••••••••">
                    </div>
                </div>
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 hover:scale-[1.02] active:scale-95 text-white font-black uppercase tracking-[0.2em] py-4 rounded-2xl transition-all shadow-xl shadow-blue-900/40 flex items-center justify-center gap-3 mt-4">
                🚀 Create My Account
            </button>
        </form>

        {{-- Footer Link --}}
        <div class="mt-10 text-center border-t border-slate-700/30 pt-8">
            <p class="text-slate-500 text-[11px] font-bold uppercase tracking-widest">
                Already part of the team?
                <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 ml-2 transition-colors">
                    Login Securely
                </a>
            </p>
        </div>
    </div>
</div>
@endsection