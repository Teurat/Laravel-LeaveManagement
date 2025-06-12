@extends('layouts.app')

@section('title', 'LeaveType Details')

@section('content')
    <div class="max-w-md bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold">{{ $leavetype->name }}</h2>
        <p class="mt-2"><strong>Leave Type that you choosed is:</strong> {{ $leavetype->name }}</p>

        <div class="mt-4 flex space-x-3">
            <a href="{{ route('leavetypes.edit', $leavetype) }}" class="text-yellow-600 hover:underline">Edit</a>
            <form action="{{ route('leavetypes.destroy', $leavetype) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button class="text-red-600 hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
    </div>
@endsection