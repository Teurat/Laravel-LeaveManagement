@extends('layouts.app')

@section('title', 'Employee Details')

@section('content')
    <div class="max-w-md bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold">{{ $leave->employee->Name ?? '-'}}</h2>
        <p class="mt-2"><strong>Company:</strong> {{ $leave->company->name ?? '-' }}</p>
        <p class="mt-1"><strong>Date From:</strong> {{ $leave->DateFrom }}</p>
        <p class="mt-1"><strong>Date To:</strong> {{ $leave->DateTo }}</p>
        <p class="mt-1"><strong>Leave Days:</strong> {{ $leave->LeaveDays }}</p>
        <p class="mt-1"><strong>Is Approved:</strong> {{ $leave->isApproved }}</p>
        <div class="mt-4 flex space-x-3">
            <a href="{{ route('leaves.edit', $leave) }}" class="text-yellow-600 hover:underline">Edit</a>
            <form action="{{ route('leaves.destroy', $leave) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button class="text-red-600 hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
    </div>
@endsection