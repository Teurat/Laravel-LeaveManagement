@extends('layouts.app')

@section('title', 'Create Employee')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <form action="{{ route('employees.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="Name" class="block text-sm font-medium text-gray-700">Employee Name</label>
                <input 
                    type="text" 
                    name="Name" 
                    id="Name" 
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm"
                    value="{{ old('Name') }}"
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
                        <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
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
                    value="{{ old('EmployedInCompany') }}"
                    required
                >
            </div>

            <!-- Remove AnnualLeaveDays input from create form -->

            <div class="mb-4">
                <label for="LeaveDaysLeft" class="block text-sm font-medium text-gray-700">Days Left</label>
                <input 
                    type="number" 
                    name="LeaveDaysLeft" 
                    id="LeaveDaysLeft" 
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm"
                    value="{{ old('LeaveDaysLeft') }}"
                    min="0"
                    required
                >
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Save</button>
        </form>

        <hr class="my-6">

        <h2 class="text-lg font-semibold mb-2">Import Employees from CSV</h2>

        <form action="{{ route('employees.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="csv_file" class="block w-full text-sm text-gray-500 mb-4" required>
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                Import CSV
            </button>
        </form>
    </div>
@endsection
