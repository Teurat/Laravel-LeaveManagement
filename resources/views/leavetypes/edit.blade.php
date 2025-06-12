@extends('layouts.app')

@section('title', 'Edit LeaveType')

@section('content')
    <form action="{{ route('leavetypes.update', $leavetype) }}" method="POST" class="max-w-md bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700">LeaveType</label>
            <input type="text" name="name" id="name" value="{{old ('name', $leavetype->name) }}" class="w-full border-gray-300 rounded mt-1" required>
        </div>
        <button class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">Update</button>
    </form>
@endsection