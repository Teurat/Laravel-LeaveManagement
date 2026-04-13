@extends('layouts.app')
@section('title', 'Companies')
@section('content')

<div class="mb-5 flex items-center justify-between">
    <div>
        <h2 class="text-base font-semibold text-slate-900">All Companies</h2>
        <p class="mt-0.5 text-sm text-slate-500">{{ $companies->total() }} {{ Str::plural('company', $companies->total()) }} in your account</p>
    </div>
    <a href="{{ route('companies.create') }}"
       class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition-colors">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Add Company
    </a>
</div>

<div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-slate-200 bg-slate-50">
                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Company</th>
                <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Registered / Target</th>
                <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Founded</th>
                <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($companies as $company)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-indigo-50">
                                <svg class="h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
                                </svg>
                            </div>
                            <span class="font-medium text-slate-900">{{ $company->name }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-center">
                        <span class="font-semibold text-slate-900">{{ $company->employees_count }}</span>
                        <span class="text-slate-400"> / {{ $company->NrEmployees }}</span>
                    </td>
                    <td class="px-5 py-3.5 text-center text-slate-600">{{ $company->FoundationYear }}</td>
                    <td class="px-5 py-3.5 text-right">
                        <div class="inline-flex items-center gap-1">
                            <a href="{{ route('companies.show', $company) }}"
                               class="rounded-md px-2.5 py-1.5 text-xs font-medium text-slate-600 hover:bg-slate-100 transition-colors">View</a>
                            <a href="{{ route('companies.edit', $company) }}"
                               class="rounded-md px-2.5 py-1.5 text-xs font-medium text-amber-700 hover:bg-amber-50 transition-colors">Edit</a>
                            <form action="{{ route('companies.destroy', $company) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this company? This cannot be undone.')"
                                        class="rounded-md px-2.5 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50 transition-colors">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-5 py-12 text-center">
                        <svg class="mx-auto h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18"/>
                        </svg>
                        <p class="mt-2 text-sm font-medium text-slate-500">No companies yet</p>
                        <a href="{{ route('companies.create') }}" class="mt-1 text-sm text-indigo-600 hover:text-indigo-500">
                            Create your first company →
                        </a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @if($companies->hasPages())
        <div class="border-t border-slate-100 px-5 py-3">
            {{ $companies->links('pagination::tailwind') }}
        </div>
    @endif
</div>
@endsection
