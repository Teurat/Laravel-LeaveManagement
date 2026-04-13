@extends('layouts.guest')
@section('title', 'Sign In')
@section('content')

<div>
    <h2 class="text-2xl font-bold text-slate-900">Welcome back</h2>
    <p class="mt-1.5 text-sm text-slate-500">Sign in to your LeaveTrack account</p>
</div>

@if (session('status'))
    <div class="mt-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
    @csrf

    <div>
        <label for="email" class="block text-sm font-medium text-slate-700">Email address</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}"
               required autofocus autocomplete="username"
               placeholder="you@company.com"
               class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900
                      shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400
                      focus:ring-2 focus:ring-inset focus:ring-indigo-600 transition-all
                      @error('email') ring-red-400 focus:ring-red-500 @enderror">
        @error('email')
            <p class="mt-1.5 flex items-center gap-1 text-xs text-red-600">
                <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    <div>
        <div class="flex items-center justify-between">
            <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-500">
                    Forgot password?
                </a>
            @endif
        </div>
        <input id="password" type="password" name="password"
               required autocomplete="current-password"
               placeholder="••••••••"
               class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900
                      shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400
                      focus:ring-2 focus:ring-inset focus:ring-indigo-600 transition-all
                      @error('password') ring-red-400 focus:ring-red-500 @enderror">
        @error('password')
            <p class="mt-1.5 flex items-center gap-1 text-xs text-red-600">
                <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    <label class="flex cursor-pointer items-center gap-2">
        <input type="checkbox" name="remember"
               class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-600">
        <span class="text-sm text-slate-600">Remember me for 30 days</span>
    </label>

    <button type="submit"
            class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white
                   shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2
                   focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-colors">
        Sign in
    </button>
</form>

<p class="mt-6 text-center text-sm text-slate-500">
    Don't have an account?
    <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">Create one free</a>
</p>

@endsection
