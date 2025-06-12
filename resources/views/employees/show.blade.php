@extends('layouts.app')

@section('title', 'Employee Details')

@section('content')
    <div class="max-w-md bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold">{{ $employee->name }}</h2>
        <p class="mt-2"><strong>Company:</strong> {{ $employee->company->name ?? '-' }}</p>
        <p class="mt-1"><strong>Employed Since:</strong> {{ $employee->EmployedInCompany }}</p>
        <p class="mt-1"><strong>Annual Days:</strong> {{ $employee->AnnualLeaveDays }}</p>
        <p class="mt-1"><strong>Days Left:</strong> {{ $employee->LeaveDaysLeft }}</p>
        <div class="mt-4 flex space-x-3">
            <a href="{{ route('employees.edit', $employee) }}" class="text-yellow-600 hover:underline">Edit</a>
            <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button class="text-red-600 hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
    </div>
@endsection