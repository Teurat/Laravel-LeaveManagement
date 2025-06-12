@extends('layouts.app')

@section('title', 'Company Details')

@section('content')
    <div class="max-w-md bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold">{{ $company->name }}</h2>
        <p class="mt-2"><strong>Number of Employees:</strong> {{ $company->NrEmployees }}</p>
        <p class="mt-1"><strong>Founded:</strong> {{ $company->FoundationYear }}</p>

        <div class="mt-4 flex space-x-3">
            <a href="{{ route('companies.edit', $company) }}" class="text-yellow-600 hover:underline">Edit</a>
            <form action="{{ route('companies.destroy', $company) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button class="text-red-600 hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
    </div>
@endsection