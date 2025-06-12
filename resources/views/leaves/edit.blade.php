@extends('layouts.app')

@section('title', 'Edit Leave')

@section('content')
    <form action="{{ route('leaves.update', $leave->id ) }}" method="POST" class="max-w-md bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="employee_id" class="block text-sm font-medium">Employee</label>
                <select name="employee_id" id="employee_id"
                        class="mt-1 block w-full border border-gray-300 rounded p-2">
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ $leave->employee_id == $employee->id ? 'selected' : '' }}>
                            {{ $employee->Name }}
                        </option>
                    @endforeach
                </select>
        </div>

        <div class="mb-4">
            <label for="leave_type_id" class="block text-sm font-medium">Company</label>
                <select name="leave_type_id" id="leave_type_id"
                        class="mt-1 block w-full border border-gray-300 rounded p-2">
                    @foreach($leavetypes as $leavetype)
                        <option value="{{ $leavetype->id }}" {{ $leave->leave_type_id == $leavetype->id ? 'selected' : '' }}>
                            {{ $leavetype->name }}
                        </option>
                    @endforeach
                </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Date From</label>
            <input type="date" name="DateFrom" id="DateFrom" value="{{ old('DateFrom', \Carbon\Carbon::parse($leave->DateFrom)->format('Y-m-d')) }}" class="w-full border-gray-300 rounded mt-1" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Date To</label>
            <input type="date" name="DateTo" id="DateTo" value="{{old ('DateTo', $leave->DateTo->format('Y-m-d')) }}" class="w-full border-gray-300 rounded mt-1" required>
        </div>

        <div class="mb-4">
            <label for="isApproved" class="block text-sm font-medium">Is Approved</label>
            <select name="isApproved">
                <option value="1" {{ old('isApproved', $leave->isApproved) == 1 ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ old('isApproved', $leave->isApproved) == 0 ? 'selected' : '' }}>No</option>
            </select>
        </div>

        
        <button class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">Update</button>
    </form>
@endsection