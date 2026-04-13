@extends('layouts.app')
@section('title', $onboarding ? 'Register Employee — ' . $onboarding['company_name'] : 'Add Employee')
@section('content')

<div class="mb-5">
    <nav class="flex items-center gap-1.5 text-sm text-slate-500">
        <a href="{{ route('employees.index') }}" class="hover:text-indigo-600 transition-colors">Employees</a>
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
        <span class="font-medium text-slate-900">
            @if($onboarding) Register Employee — {{ $onboarding['company_name'] }}
            @else Add Employee
            @endif
        </span>
    </nav>
</div>

{{-- Onboarding progress banner --}}
@if($onboarding)
    @php
        $added     = $onboarding['added'];
        $target    = $onboarding['target'];
        $current   = $added + 1;           // the one they're about to add
        $pct       = round(($added / $target) * 100);
    @endphp
    <div class="mb-5 overflow-hidden rounded-xl border border-indigo-200 bg-indigo-50 shadow-sm">
        <div class="flex items-center justify-between px-5 py-4">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-indigo-600 text-sm font-bold text-white">
                    {{ $current }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-indigo-900">
                        Adding employee {{ $current }} of {{ $target }} for <span class="italic">{{ $onboarding['company_name'] }}</span>
                    </p>
                    <p class="text-xs text-indigo-600">{{ $target - $added }} remaining after this one</p>
                </div>
            </div>
            <a href="{{ route('employees.onboarding.skip') }}"
               class="shrink-0 rounded-lg px-3 py-1.5 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-300 hover:bg-indigo-100 transition-colors">
                Skip remaining →
            </a>
        </div>
        {{-- Progress bar --}}
        <div class="h-1.5 bg-indigo-200">
            <div class="h-1.5 bg-indigo-600 transition-all" style="width: {{ $pct }}%"></div>
        </div>
    </div>
@endif

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <div class="lg:col-span-2">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-5 text-sm font-semibold text-slate-900">Employee Details</h3>
            <form action="{{ route('employees.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="Name" class="block text-sm font-medium text-slate-700">Full name <span class="text-red-500">*</span></label>
                    <input type="text" name="Name" id="Name" value="{{ old('Name') }}" required
                           placeholder="e.g. Jane Smith"
                           class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900
                                  shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400
                                  focus:ring-2 focus:ring-inset focus:ring-indigo-600 transition-all">
                    @error('Name') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="company_id" class="block text-sm font-medium text-slate-700">Company <span class="text-red-500">*</span></label>
                    <select name="company_id" id="company_id" required
                            {{ $onboarding ? 'disabled' : '' }}
                            class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900
                                   shadow-sm ring-1 ring-inset ring-slate-300
                                   focus:ring-2 focus:ring-inset focus:ring-indigo-600 transition-all
                                   {{ $onboarding ? 'cursor-not-allowed opacity-60' : '' }}">
                        <option value="">— Select company —</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}"
                                {{ (old('company_id', $preselectedCompanyId) == $company->id) ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                    {{-- When select is disabled, its value is not submitted — use a hidden input --}}
                    @if($onboarding)
                        <input type="hidden" name="company_id" value="{{ $onboarding['company_id'] }}">
                    @endif
                    @error('company_id') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="EmployedInCompany" class="block text-sm font-medium text-slate-700">Employed since <span class="text-red-500">*</span></label>
                    <input type="date" name="EmployedInCompany" id="EmployedInCompany" value="{{ old('EmployedInCompany') }}" required
                           class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900
                                  shadow-sm ring-1 ring-inset ring-slate-300
                                  focus:ring-2 focus:ring-inset focus:ring-indigo-600 transition-all">
                    @error('EmployedInCompany') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <p class="rounded-lg bg-indigo-50 px-4 py-3 text-xs text-indigo-700">
                    Annual leave days and remaining balance are calculated automatically (base 28 days + 1 per completed year).
                </p>
                <div class="flex items-center gap-3 pt-1">
                    <button type="submit"
                            class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition-colors">
                        @if($onboarding) Save &amp; Add Next @else Save Employee @endif
                    </button>
                    @if($onboarding)
                        <a href="{{ route('employees.onboarding.skip') }}"
                           class="rounded-lg px-5 py-2.5 text-sm font-semibold text-slate-700 ring-1 ring-inset ring-slate-300 hover:bg-slate-50 transition-colors">
                            Skip Remaining
                        </a>
                    @else
                        <a href="{{ route('employees.index') }}"
                           class="rounded-lg px-5 py-2.5 text-sm font-semibold text-slate-700 ring-1 ring-inset ring-slate-300 hover:bg-slate-50 transition-colors">
                            Cancel
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div>
        @if(!$onboarding)
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-sm font-semibold text-slate-900">Import from CSV</h3>
            <p class="mb-4 text-xs text-slate-500">Upload a CSV file with columns: <code class="rounded bg-slate-100 px-1 py-0.5 font-mono">name, company_id, employed_since</code></p>
            <form action="{{ route('employees.import') }}" method="POST" enctype="multipart/form-data">
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
        @else
        <div class="rounded-xl border border-indigo-100 bg-indigo-50 p-5">
            <h3 class="mb-2 text-sm font-semibold text-indigo-900">Onboarding in progress</h3>
            <p class="text-xs text-indigo-700 leading-relaxed">
                You're registering employees for <strong>{{ $onboarding['company_name'] }}</strong>.
                Complete all {{ $onboarding['target'] }} or click "Skip Remaining" to finish later.
                Skipped employees can be added anytime from the Employees section.
            </p>
            <div class="mt-4 space-y-1.5 text-xs text-indigo-600">
                <div class="flex justify-between">
                    <span>Target headcount</span>
                    <span class="font-semibold">{{ $onboarding['target'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Registered so far</span>
                    <span class="font-semibold">{{ $onboarding['added'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Remaining</span>
                    <span class="font-semibold text-indigo-800">{{ $onboarding['target'] - $onboarding['added'] }}</span>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
