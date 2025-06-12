<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leavetypes = LeaveType::paginate(3);
        return view('leavetypes.index', compact('leavetypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('leavetypes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|string|max:255'
        ]);
        LeaveType::create($request->only('name'));

        return redirect()->route('leavetypes.index')->with('success', 'LeaveType created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LeaveType $leavetype)
    {
        return view('leavetypes.show', compact('leavetype'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeaveType $leavetype)
    {
        return view('leavetypes.edit', compact('leavetype'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeaveType $leavetype)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $leavetype->update($request->all());
        return redirect()->route('leavetypes.index')->with('success', 'LeaveType updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeaveType $leavetype)
    {
        $leavetype->delete();
        return redirect()->route('leavetypes.index')->with('success', 'LeaveType deleted successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
        'csv_file' => 'required|file|mimes:csv,txt',
    ]);

    $file = $request->file('csv_file');
    $data = array_map('str_getcsv', file($file));

    foreach ($data as $index => $row) {
        if ($index === 0) continue; // skip header row

        LeaveType::create([
            'name' => $row[0] ?? ''
        ]);
    }

    return redirect()->route('leavetypes.index')->with('success', 'LeaveTypes imported successfully.');
    }
}
