@extends('layouts.app')
@section('title', 'Employees')
@section('content')

<div class="mb-5 flex items-center justify-between">
    <div>
        <h2 class="text-base font-semibold text-slate-900">All Employees</h2>
        <p class="mt-0.5 text-sm text-slate-500">{{ $employees->total() }} {{ Str::plural('employee', $employees->total()) }} across your companies</p>
    </div>
    <a href="{{ route('employees.create') }}"
       class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition-colors">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Add Employee
    </a>
</div>

<div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-slate-200 bg-slate-50">
                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Employee</th>
                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Company</th>
                <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Employed Since</th>
                <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Annual Days</th>
                <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Days Left</th>
                <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($employees as $employee)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-xs font-semibold text-indigo-700">
                                {{ strtoupper(substr($employee->Name, 0, 1)) }}
                            </div>
                            <span class="font-medium text-slate-900">{{ $employee->Name }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-slate-600">{{ $employee->company->name ?? '—' }}</td>
                    <td class="px-5 py-3.5 text-center text-slate-600">
                        {{ $employee->EmployedInCompany ? $employee->EmployedInCompany->format('Y-m-d') : '—' }}
                    </td>
                    <td class="px-5 py-3.5 text-center text-slate-600">{{ $employee->AnnualLeaveDays }}</td>
                    <td class="px-5 py-3.5 text-center">
                        @php $pct = $employee->AnnualLeaveDays > 0 ? ($employee->LeaveDaysLeft / $employee->AnnualLeaveDays) : 1; @endphp
                        <span class="font-semibold {{ $pct <= 0.25 ? 'text-red-600' : ($pct <= 0.5 ? 'text-amber-600' : 'text-emerald-600') }}">
                            {{ $employee->LeaveDaysLeft }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-right">
                        <div class="inline-flex items-center gap-1">
                            <a href="{{ route('employees.show', $employee) }}"
                               class="rounded-md px-2.5 py-1.5 text-xs font-medium text-slate-600 hover:bg-slate-100 transition-colors">View</a>
                            <a href="{{ route('employees.edit', $employee) }}"
                               class="rounded-md px-2.5 py-1.5 text-xs font-medium text-amber-700 hover:bg-amber-50 transition-colors">Edit</a>
                            <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete {{ $employee->Name }}? All leave records will also be deleted.')"
                                        class="rounded-md px-2.5 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50 transition-colors">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center">
                        <svg class="mx-auto h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                        </svg>
                        <p class="mt-2 text-sm font-medium text-slate-500">No employees yet</p>
                        <a href="{{ route('employees.create') }}" class="mt-1 text-sm text-indigo-600 hover:text-indigo-500">
                            Add your first employee →
                        </a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @if($employees->hasPages())
        <div class="border-t border-slate-100 px-5 py-3">
            {{ $employees->links('pagination::tailwind') }}
        </div>
    @endif
</div>
@endsection
