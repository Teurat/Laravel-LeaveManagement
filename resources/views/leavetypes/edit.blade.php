@extends('layouts.app')
@section('title', 'Edit Leave Type')
@section('content')

<div class="mb-5">
    <nav class="flex items-center gap-1.5 text-sm text-slate-500">
        <a href="{{ route('leavetypes.index') }}" class="hover:text-indigo-600 transition-colors">Leave Types</a>
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
        <span class="font-medium text-slate-900">Edit — {{ $leavetype->name }}</span>
    </nav>
</div>

<div class="max-w-2xl">
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <h3 class="mb-5 text-sm font-semibold text-slate-900">Leave Type Details</h3>
        <form action="{{ route('leavetypes.update', $leavetype) }}" method="POST" class="space-y-5">
            @csrf @method('PUT')
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700">Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $leavetype->name) }}" required
                       class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900
                              shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 transition-all">
                @error('name') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="flex items-center gap-3 pt-1">
                <button type="submit"
                        class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition-colors">
                    Save Changes
                </button>
                <a href="{{ route('leavetypes.index') }}"
                   class="rounded-lg px-5 py-2.5 text-sm font-semibold text-slate-700 ring-1 ring-inset ring-slate-300 hover:bg-slate-50 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
