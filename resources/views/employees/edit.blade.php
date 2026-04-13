@extends('layouts.app')
@section('title', 'Edit Employee')
@section('content')

<div class="mb-5">
    <nav class="flex items-center gap-1.5 text-sm text-slate-500">
        <a href="{{ route('employees.index') }}" class="hover:text-indigo-600 transition-colors">Employees</a>
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
        <span class="font-medium text-slate-900">Edit — {{ $employee->Name }}</span>
    </nav>
</div>

<div class="max-w-2xl">
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <h3 class="mb-5 text-sm font-semibold text-slate-900">Employee Details</h3>
        <form action="{{ route('employees.update', $employee) }}" method="POST" class="space-y-5">
            @csrf @method('PUT')
            <div>
                <label for="Name" class="block text-sm font-medium text-slate-700">Full name <span class="text-red-500">*</span></label>
                <input type="text" name="Name" id="Name" value="{{ old('Name', $employee->Name) }}" required
                       class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900
                              shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 transition-all">
                @error('Name') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="company_id" class="block text-sm font-medium text-slate-700">Company <span class="text-red-500">*</span></label>
                <select name="company_id" id="company_id" required
                        class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900
                               shadow-sm ring-1 ring-inset ring-slate-300
                               focus:ring-2 focus:ring-inset focus:ring-indigo-600 transition-all">
                    <option value="">— Select company —</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" {{ old('company_id', $employee->company_id) == $company->id ? 'selected' : '' }}>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
                @error('company_id') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="EmployedInCompany" class="block text-sm font-medium text-slate-700">Employed since <span class="text-red-500">*</span></label>
                <input type="date" name="EmployedInCompany" id="EmployedInCompany"
                       value="{{ old('EmployedInCompany', \Carbon\Carbon::parse($employee->EmployedInCompany)->format('Y-m-d')) }}" required
                       class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900
                              shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 transition-all">
                @error('EmployedInCompany') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Read-only calculated fields --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Annual leave days</label>
                    <input type="number" value="{{ $employee->AnnualLeaveDays }}" readonly disabled
                           class="mt-1.5 block w-full rounded-lg border-0 bg-slate-100 px-3.5 py-2.5 text-sm font-semibold text-slate-500
                                  shadow-sm ring-1 ring-inset ring-slate-200 cursor-not-allowed">
                    <p class="mt-1 text-xs text-slate-400">Recalculated on save (28 + years worked).</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Days remaining</label>
                    <input type="number" value="{{ $employee->LeaveDaysLeft }}" readonly disabled
                           class="mt-1.5 block w-full rounded-lg border-0 bg-slate-100 px-3.5 py-2.5 text-sm font-semibold text-slate-500
                                  shadow-sm ring-1 ring-inset ring-slate-200 cursor-not-allowed">
                    <p class="mt-1 text-xs text-slate-400">Recalculated from approved leave records.</p>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-1">
                <button type="submit"
                        class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition-colors">
                    Save Changes
                </button>
                <a href="{{ route('employees.index') }}"
                   class="rounded-lg px-5 py-2.5 text-sm font-semibold text-slate-700 ring-1 ring-inset ring-slate-300 hover:bg-slate-50 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
