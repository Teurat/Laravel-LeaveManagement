@extends('layouts.app')

@section('title', 'Employees')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Employees</h1>
        <a href="{{ route('employees.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
            + Add New Employee
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg shadow">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase">Name</th>
                    <th class="px-6 py-3 text-center text-sm font-bold text-gray-700 uppercase">Company</th>
                    <th class="px-6 py-3 text-center text-sm font-bold text-gray-700 uppercase">Employed Since</th>
                    <th class="px-6 py-3 text-center text-sm font-bold text-gray-700 uppercase">Annual Days</th>
                    <th class="px-6 py-3 text-center text-sm font-bold text-gray-700 uppercase">Days Left</th>
                    <th class="px-6 py-3 text-center text-sm font-bold text-gray-700 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($employees as $employee)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">{{ $employee->Name }}</td>
                        <td class="px-6 py-4 text-center">{{ $employee->company->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            {{ $employee->EmployedInCompany ? $employee->EmployedInCompany->format('Y-m-d') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">{{ $employee->AnnualLeaveDays }}</td>
                        <td class="px-6 py-4 text-center">{{ $employee->LeaveDaysLeft }}</td>
                        <td class="px-6 py-4 text-center space-x-2">
                            <a href="{{ route('employees.show', $employee) }}"
                               class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm hover:bg-blue-200">
                                View
                            </a>
                            <a href="{{ route('employees.edit', $employee) }}"
                               class="inline-block px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm hover:bg-yellow-200">
                                Edit
                            </a>
                            <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Are you sure?')"
                                        class="inline-block px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm hover:bg-red-200">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $employees->links('pagination::tailwind') }}
    </div>
@endsection
