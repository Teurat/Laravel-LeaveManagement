@extends('layouts.app')
@section('title', 'Leave Types')
@section('content')

<div class="mb-5 flex items-center justify-between">
    <div>
        <h2 class="text-base font-semibold text-slate-900">Leave Types</h2>
        <p class="mt-0.5 text-sm text-slate-500">{{ $leavetypes->total() }} {{ Str::plural('type', $leavetypes->total()) }} configured</p>
    </div>
    <a href="{{ route('leavetypes.create') }}"
       class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition-colors">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Add Leave Type
    </a>
</div>

<div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-slate-200 bg-slate-50">
                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Name</th>
                <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($leavetypes as $leavetype)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-violet-50">
                                <svg class="h-4 w-4 text-violet-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"/>
                                </svg>
                            </div>
                            <span class="font-medium text-slate-900">{{ $leavetype->name }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-right">
                        <div class="inline-flex items-center gap-1">
                            <a href="{{ route('leavetypes.show', $leavetype) }}"
                               class="rounded-md px-2.5 py-1.5 text-xs font-medium text-slate-600 hover:bg-slate-100 transition-colors">View</a>
                            <a href="{{ route('leavetypes.edit', $leavetype) }}"
                               class="rounded-md px-2.5 py-1.5 text-xs font-medium text-amber-700 hover:bg-amber-50 transition-colors">Edit</a>
                            <form action="{{ route('leavetypes.destroy', $leavetype) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this leave type? This cannot be undone.')"
                                        class="rounded-md px-2.5 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50 transition-colors">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="px-5 py-12 text-center">
                        <svg class="mx-auto h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z"/>
                        </svg>
                        <p class="mt-2 text-sm font-medium text-slate-500">No leave types yet</p>
                        <a href="{{ route('leavetypes.create') }}" class="mt-1 text-sm text-indigo-600 hover:text-indigo-500">
                            Create your first leave type →
                        </a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @if($leavetypes->hasPages())
        <div class="border-t border-slate-100 px-5 py-3">
            {{ $leavetypes->links('pagination::tailwind') }}
        </div>
    @endif
</div>
@endsection
