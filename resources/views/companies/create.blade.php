{{-- @extends('layouts.app')

@section('title', 'Create Company')

@section('content')
    <form action="{{ route('companies.store') }}" method="POST" class="max-w-md bg-white p-6 rounded shadow">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Name</label>
            <input type="text" name="name" class="w-full border-gray-300 rounded mt-1" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Number of Employees</label>
            <input type="number" name="NrEmployees" class="w-full border-gray-300 rounded mt-1" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Foundation Year</label>
            <input type="number" name="FoundationYear" class="w-full border-gray-300 rounded mt-1" required>
        </div>
        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create</button>
    </form>
@endsection --}}
@extends('layouts.app')

@section('title', 'Create Company')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <form action="{{ route('companies.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Company Name</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
            </div>
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Number of Employees</label>
                <input type="number" name="NrEmployees" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
            </div>
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Foundation Year</label>
                <input type="number" name="FoundationYear" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Save</button>
        </form>

        <hr class="my-6">

        <h2 class="text-lg font-semibold mb-2">Import Companies from CSV</h2>

        <form action="{{ route('companies.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="csv_file" class="block w-full text-sm text-gray-500 mb-4">
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                Import CSV
            </button>
        </form>
    </div>
@endsection
