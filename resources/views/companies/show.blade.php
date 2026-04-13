@extends('layouts.app')
@section('title', $company->name)
@section('content')

<div class="mb-5">
    <nav class="flex items-center gap-1.5 text-sm text-slate-500">
        <a href="{{ route('companies.index') }}" class="hover:text-indigo-600 transition-colors">Companies</a>
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
        <span class="font-medium text-slate-900">{{ $company->name }}</span>
    </nav>
</div>

<div class="max-w-xl">
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        {{-- Header --}}
        <div class="flex items-center gap-4 border-b border-slate-100 bg-slate-50 px-6 py-5">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100">
                <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
                </svg>
            </div>
            <div>
                <h2 class="text-base font-semibold text-slate-900">{{ $company->name }}</h2>
                <p class="text-sm text-slate-500">{{ $company->employees_count }} {{ Str::plural('employee', $company->employees_count) }} · Founded {{ $company->FoundationYear }}</p>
            </div>
        </div>

        {{-- Details --}}
        <dl class="divide-y divide-slate-100">
            <div class="flex items-center justify-between px-6 py-4">
                <dt class="text-sm text-slate-500">Registered Employees</dt>
                <dd class="flex items-center gap-2">
                    <span class="text-sm font-bold text-slate-900">{{ $company->employees_count }}</span>
                    @if($company->NrEmployees > 0)
                        @php $pct = min(100, round(($company->employees_count / $company->NrEmployees) * 100)); @endphp
                        <span class="text-xs text-slate-400">of {{ $company->NrEmployees }} target</span>
                        <span class="rounded-full px-2 py-0.5 text-xs font-semibold
                            {{ $pct >= 100 ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                            {{ $pct }}%
                        </span>
                    @endif
                </dd>
            </div>
            <div class="flex items-center justify-between px-6 py-4">
                <dt class="text-sm text-slate-500">Target Headcount</dt>
                <dd class="text-sm font-semibold text-slate-900">{{ $company->NrEmployees }}</dd>
            </div>
            <div class="flex items-center justify-between px-6 py-4">
                <dt class="text-sm text-slate-500">Foundation Year</dt>
                <dd class="text-sm font-semibold text-slate-900">{{ $company->FoundationYear }}</dd>
            </div>
        </dl>

        {{-- Actions --}}
        <div class="flex items-center gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4">
            <a href="{{ route('companies.edit', $company) }}"
               class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500 transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/>
                </svg>
                Edit
            </a>
            <form action="{{ route('companies.destroy', $company) }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button type="submit" onclick="return confirm('Delete this company? All employees and leaves will also be deleted.')"
                        class="inline-flex items-center gap-1.5 rounded-lg px-4 py-2 text-sm font-semibold text-red-600 ring-1 ring-inset ring-red-200 hover:bg-red-50 transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                    </svg>
                    Delete
                </button>
            </form>
            <a href="{{ route('companies.index') }}" class="ml-auto text-sm text-slate-500 hover:text-slate-700">
                ← Back to Companies
            </a>
        </div>
    </div>
</div>
@endsection
