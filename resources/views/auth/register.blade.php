@extends('layouts.guest')
@section('title', 'Create Account')
@section('content')

<div>
    <h2 class="text-2xl font-bold text-slate-900">Create your account</h2>
    <p class="mt-1.5 text-sm text-slate-500">Start managing your team's leave today — it's free</p>
</div>

<form method="POST" action="{{ route('register') }}" class="mt-8 space-y-5">
    @csrf

    <div>
        <label for="name" class="block text-sm font-medium text-slate-700">Full name</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}"
               required autofocus autocomplete="name" placeholder="John Smith"
               class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900
                      shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400
                      focus:ring-2 focus:ring-inset focus:ring-indigo-600 transition-all">
        @error('name')
            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-slate-700">Email address</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}"
               required autocomplete="username" placeholder="you@company.com"
               class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900
                      shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400
                      focus:ring-2 focus:ring-inset focus:ring-indigo-600 transition-all">
        @error('email')
            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
        <input id="password" type="password" name="password"
               required autocomplete="new-password" placeholder="Min. 8 characters"
               class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900
                      shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400
                      focus:ring-2 focus:ring-inset focus:ring-indigo-600 transition-all">
        @error('password')
            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Confirm password</label>
        <input id="password_confirmation" type="password" name="password_confirmation"
               required autocomplete="new-password" placeholder="••••••••"
               class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900
                      shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400
                      focus:ring-2 focus:ring-inset focus:ring-indigo-600 transition-all">
        @error('password_confirmation')
            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit"
            class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white
                   shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2
                   focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-colors">
        Create account
    </button>
</form>

<p class="mt-6 text-center text-sm text-slate-500">
    Already have an account?
    <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">Sign in</a>
</p>

@endsection
