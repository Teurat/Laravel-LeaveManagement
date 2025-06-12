@extends('layouts.app')

@section('title', 'Edit Employee')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <form action="{{ route('employees.update', $employee->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="Name" class="block text-sm font-medium text-gray-700">Employee Name</label>
                <input 
                    type="text" 
                    name="Name" 
                    id="Name" 
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm"
                    value="{{ old('Name', $employee->Name) }}"
                    required
                >
            </div>

            <div class="mb-4">
                <label for="company_id" class="block text-sm font-medium text-gray-700">Company</label>
                <select 
                    name="company_id" 
                    id="company_id" 
                    class="border w-full p-2 rounded" 
                    required
                >
                    <option value="">-- Select Company --</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" {{ old('company_id', $employee->company_id) == $company->id ? 'selected' : '' }}>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="EmployedInCompany" class="block text-sm font-medium text-gray-700">Employed Since</label>
                <input 
                    type="date" 
                    name="EmployedInCompany" 
                    id="EmployedInCompany" 
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm"
                    value="{{ old('EmployedInCompany', \Carbon\Carbon::parse($employee->EmployedInCompany)->format('Y-m-d')) }}"
                    required
                >
            </div>

            <div class="mb-4">
                <label for="AnnualLeaveDays" class="block text-sm font-medium text-gray-700">Annual Days</label>
                <input 
                    type="number" 
                    id="AnnualLeaveDays" 
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm bg-gray-100" 
                    value="{{ $employee->AnnualLeaveDays }}" 
                    readonly
                    disabled
                >
            </div>

            <div class="mb-4">
                <label for="LeaveDaysLeft" class="block text-sm font-medium text-gray-700">Days Left</label>
                <input 
                    type="number" 
                    name="LeaveDaysLeft" 
                    id="LeaveDaysLeft" 
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm"
                    value="{{ old('LeaveDaysLeft', $employee->LeaveDaysLeft) }}"
                    min="0"
                    required
                >
            </div>

            <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">Update</button>
        </form>
    </div>
@endsection
