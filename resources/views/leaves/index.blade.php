@extends('layouts.app')
@section('title', 'Leaves')
@section('content')

<div class="mb-5 flex items-center justify-between">
    <div>
        <h2 class="text-base font-semibold text-slate-900">All Leaves</h2>
        <p class="mt-0.5 text-sm text-slate-500">{{ $leaves->total() }} {{ Str::plural('record', $leaves->total()) }} total</p>
    </div>
    <a href="{{ route('leaves.create') }}"
       class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition-colors">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Add Leave
    </a>
</div>

<div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-slate-200 bg-slate-50">
                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Employee</th>
                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Type</th>
                <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">From</th>
                <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">To</th>
                <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Days</th>
                <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($leaves as $leave)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-xs font-semibold text-indigo-700">
                                {{ strtoupper(substr($leave->employee->Name ?? '?', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-medium text-slate-900">{{ $leave->employee->Name ?? '—' }}</p>
                                <p class="text-xs text-slate-400">{{ $leave->employee->company->name ?? '' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-slate-600">{{ $leave->leavetype->name ?? '—' }}</td>
                    <td class="px-5 py-3.5 text-center text-slate-600">
                        {{ $leave->DateFrom ? $leave->DateFrom->format('d M Y') : '—' }}
                    </td>
                    <td class="px-5 py-3.5 text-center text-slate-600">
                        {{ $leave->DateTo ? $leave->DateTo->format('d M Y') : '—' }}
                    </td>
                    <td class="px-5 py-3.5 text-center font-semibold text-slate-700">{{ $leave->LeaveDays }}</td>
                    <td class="px-5 py-3.5 text-center">
                        @if($leave->isApproved)
                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Approved
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-amber-400"></span>
                                Pending
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5 text-right">
                        <div class="inline-flex items-center gap-1">
                            <a href="{{ route('leaves.show', $leave) }}"
                               class="rounded-md px-2.5 py-1.5 text-xs font-medium text-slate-600 hover:bg-slate-100 transition-colors">View</a>
                            <a href="{{ route('leaves.edit', $leave) }}"
                               class="rounded-md px-2.5 py-1.5 text-xs font-medium text-amber-700 hover:bg-amber-50 transition-colors">Edit</a>
                            <form action="{{ route('leaves.destroy', $leave) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this leave record? This cannot be undone.')"
                                        class="rounded-md px-2.5 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50 transition-colors">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-5 py-12 text-center">
                        <svg class="mx-auto h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                        </svg>
                        <p class="mt-2 text-sm font-medium text-slate-500">No leave records yet</p>
                        <a href="{{ route('leaves.create') }}" class="mt-1 text-sm text-indigo-600 hover:text-indigo-500">
                            Create your first leave record →
                        </a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @if($leaves->hasPages())
        <div class="border-t border-slate-100 px-5 py-3">
            {{ $leaves->links('pagination::tailwind') }}
        </div>
    @endif
</div>
@endsection
