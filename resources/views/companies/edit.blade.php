@extends('layouts.app')

@section('title', 'Edit Company')

@section('content')
    <form action="{{ route('companies.update', $company) }}" method="POST" class="max-w-md bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700">Name</label>
            <input type="text" name="name" value="{{ $company->name }}" class="w-full border-gray-300 rounded mt-1" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Number of Employees</label>
            <input type="number" name="NrEmployees" value="{{ $company->NrEmployees }}" class="w-full border-gray-300 rounded mt-1" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Foundation Year</label>
            <input type="number" name="FoundationYear" value="{{ $company->FoundationYear }}" class="w-full border-gray-300 rounded mt-1" required>
        </div>
        <button class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">Update</button>
    </form>
@endsection