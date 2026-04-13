@extends('layouts.app')
@section('title', 'Add Leave Type')
@section('content')

<div class="mb-5">
    <nav class="flex items-center gap-1.5 text-sm text-slate-500">
        <a href="{{ route('leavetypes.index') }}" class="hover:text-indigo-600 transition-colors">Leave Types</a>
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
        <span class="font-medium text-slate-900">Add Leave Type</span>
    </nav>
</div>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <div class="lg:col-span-2">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-5 text-sm font-semibold text-slate-900">Leave Type Details</h3>
            <form action="{{ route('leavetypes.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700">Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           placeholder="e.g. Annual Leave"
                           class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900
                                  shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400
                                  focus:ring-2 focus:ring-inset focus:ring-indigo-600 transition-all">
                    @error('name') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="flex items-center gap-3 pt-1">
                    <button type="submit"
                            class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition-colors">
                        Save Leave Type
                    </button>
                    <a href="{{ route('leavetypes.index') }}"
                       class="rounded-lg px-5 py-2.5 text-sm font-semibold text-slate-700 ring-1 ring-inset ring-slate-300 hover:bg-slate-50 transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div>
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-sm font-semibold text-slate-900">Import from CSV</h3>
            <p class="mb-4 text-xs text-slate-500">Upload a CSV file with column: <code class="rounded bg-slate-100 px-1 py-0.5 font-mono">name</code></p>
            <form action="{{ route('leavetypes.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label class="flex cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-slate-300 px-4 py-6 text-center hover:border-indigo-400 hover:bg-indigo-50/50 transition-all">
                    <svg class="mb-2 h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/>
                    </svg>
                    <span class="text-sm font-medium text-slate-600">Click to upload CSV</span>
                    <span class="mt-0.5 text-xs text-slate-400">.csv or .txt files only</span>
                    <input type="file" name="csv_file" accept=".csv,.txt" required class="hidden">
                </label>
                <button type="submit"
                        class="mt-3 w-full rounded-lg bg-slate-800 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700 transition-colors">
                    Import
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
