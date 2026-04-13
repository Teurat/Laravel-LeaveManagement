@extends('layouts.app')
@section('title', 'Edit Leave')
@section('content')

<div class="mb-5">
    <nav class="flex items-center gap-1.5 text-sm text-slate-500">
        <a href="{{ route('leaves.index') }}" class="hover:text-indigo-600 transition-colors">Leaves</a>
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
        <span class="font-medium text-slate-900">Edit — {{ $leave->employee->Name ?? 'Leave' }}</span>
    </nav>
</div>

<div class="max-w-2xl">
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <h3 class="mb-5 text-sm font-semibold text-slate-900">Leave Details</h3>
        <form action="{{ route('leaves.update', $leave) }}" method="POST" class="space-y-5">
            @csrf @method('PUT')
            <div>
                <label for="employee_id" class="block text-sm font-medium text-slate-700">Employee <span class="text-red-500">*</span></label>
                <select name="employee_id" id="employee_id" required
                        class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900
                               shadow-sm ring-1 ring-inset ring-slate-300
                               focus:ring-2 focus:ring-inset focus:ring-indigo-600 transition-all">
                    <option value="">— Select employee —</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}" {{ old('employee_id', $leave->employee_id) == $employee->id ? 'selected' : '' }}>
                            {{ $employee->Name }}
                        </option>
                    @endforeach
                </select>
                @error('employee_id') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="leave_type_id" class="block text-sm font-medium text-slate-700">Leave type <span class="text-red-500">*</span></label>
                <select name="leave_type_id" id="leave_type_id" required
                        class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900
                               shadow-sm ring-1 ring-inset ring-slate-300
                               focus:ring-2 focus:ring-inset focus:ring-indigo-600 transition-all">
                    <option value="">— Select type —</option>
                    @foreach ($leavetypes as $leavetype)
                        <option value="{{ $leavetype->id }}" {{ old('leave_type_id', $leave->leave_type_id) == $leavetype->id ? 'selected' : '' }}>
                            {{ $leavetype->name }}
                        </option>
                    @endforeach
                </select>
                @error('leave_type_id') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="DateFrom" class="block text-sm font-medium text-slate-700">Date from <span class="text-red-500">*</span></label>
                    <input type="date" name="DateFrom" id="DateFrom"
                           value="{{ old('DateFrom', \Carbon\Carbon::parse($leave->DateFrom)->format('Y-m-d')) }}" required
                           class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900
                                  shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 transition-all">
                    @error('DateFrom') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="DateTo" class="block text-sm font-medium text-slate-700">Date to <span class="text-red-500">*</span></label>
                    <input type="date" name="DateTo" id="DateTo"
                           value="{{ old('DateTo', $leave->DateTo->format('Y-m-d')) }}" required
                           class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900
                                  shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 transition-all">
                    @error('DateTo') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
            <div>
                <label for="isApproved" class="block text-sm font-medium text-slate-700">Status</label>
                <select name="isApproved" id="isApproved"
                        class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900
                               shadow-sm ring-1 ring-inset ring-slate-300
                               focus:ring-2 focus:ring-inset focus:ring-indigo-600 transition-all">
                    <option value="0" {{ old('isApproved', $leave->isApproved) == 0 ? 'selected' : '' }}>Pending</option>
                    <option value="1" {{ old('isApproved', $leave->isApproved) == 1 ? 'selected' : '' }}>Approved</option>
                </select>
            </div>
            <div class="flex items-center gap-3 pt-1">
                <button type="submit"
                        class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition-colors">
                    Save Changes
                </button>
                <a href="{{ route('leaves.index') }}"
                   class="rounded-lg px-5 py-2.5 text-sm font-semibold text-slate-700 ring-1 ring-inset ring-slate-300 hover:bg-slate-50 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
