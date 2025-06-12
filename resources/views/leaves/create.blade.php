    @extends('layouts.app')

    @section('title', 'Create Leave')

    @section('content')
        <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
            <form action="{{ route('leaves.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label>Name</label>
                        <select name="employee_id" class="border w-full p-2 rounded" required>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->Name }}</option>
                            @endforeach
                        </select>
                </div>
                <div class="mb-4">
                    <label>Leave Type</label>
                        <select name="leave_type_id" class="border w-full p-2 rounded" required>
                            @foreach ($leavetypes as $leavetype)
                                <option value="{{ $leavetype->id }}">{{ $leavetype->name }}</option>
                            @endforeach
                        </select>
                </div>

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Date From</label>
                    <input type="date" name="DateFrom" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                </div>
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Date To</label>
                    <input type="date" name="DateTo" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                </div>
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Leave Days</label>
                    <input type="number" name="LeaveDays" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                </div>
                <div class="mb-4">
                    <label>Is Approved</label>
                    <select name="isApproved" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Save</button>
            </form>

            <hr class="my-6">

            <h2 class="text-lg font-semibold mb-2">Import Leaves from CSV</h2>

            <form action="{{ route('leaves.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="csv_file" class="block w-full text-sm text-gray-500 mb-4">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                    Import CSV
                </button>
            </form>
        </div>
    @endsection 
