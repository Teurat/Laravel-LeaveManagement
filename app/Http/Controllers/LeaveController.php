<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Employee;
use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveController extends Controller
{

    private function updateEmployeeLeaveDaysLeft($employeeId)
    {
        $employee = Employee::find($employeeId);

        if ($employee) {
            $annualLeaveType = LeaveType::where('name', 'Annual Leave')->first();

            $totalAnnualLeaveDaysTaken = 0;
            if ($annualLeaveType) {
                $totalAnnualLeaveDaysTaken = Leave::where('employee_id', $employeeId)
                    ->where('leave_type_id', $annualLeaveType->id)
                    ->where('isApproved', true)
                    ->sum('LeaveDays');
            }

            $employee->LeaveDaysLeft = $employee->AnnualLeaveDays - $totalAnnualLeaveDaysTaken;

            $employee->save();
        }
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leaves = Leave::paginate(3);
        return view('leaves.index', compact('leaves'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all();
        $leavetypes = LeaveType::all();
        return view('leaves.create', compact('employees', 'leavetypes'));

    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'DateFrom' => 'required|date',
            'DateTo' => 'required|date',
            'isApproved' => 'required|boolean'
        ]);

        $leaveDays = (new \DateTime($request->DateFrom))->diff(new \DateTime($request->DateTo))->days + 1;

        Leave::create([
            'employee_id' => $request->employee_id,
            'leave_type_id' => $request->leave_type_id,
            'DateFrom' => $request->DateFrom,
            'DateTo' => $request->DateTo,
            'LeaveDays' => $leaveDays,
            'isApproved' => $request->isApproved
        ]);
        $this->updateEmployeeLeaveDaysLeft($request->employee_id);


        return redirect()->route('leaves.index')->with('succes', 'Leave created successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(Leave $leave)
    {
        return view('leaves.show', compact('leave'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leave $leave)
    {
        $employees = Employee::all();        
        $leavetypes = LeaveType::all();
        return view('leaves.edit', compact('leave', 'employees', 'leavetypes'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Leave $leave)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'DateFrom' => 'required|date',
            'DateTo' => 'required|date',
            'isApproved' => 'required|boolean'
        ]);

        $leaveDays = \Carbon\Carbon::parse($request->DateFrom)->diffInDays(\Carbon\Carbon::parse($request->DateTo)) + 1;

        $leave->update([
            'employee_id' => $request->employee_id,
            'leave_type_id' => $request->leave_type_id,
            'DateFrom' => $request->DateFrom,
            'DateTo' => $request->DateTo,
            'LeaveDays' => $leaveDays,
            'isApproved' => $request->isApproved,
        ]);
        $this->updateEmployeeLeaveDaysLeft($request->employee_id);
        return redirect()->route('leaves.index')->with('success', 'Leave updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leave $leave)
    {   
        $leave->delete();
        $this->updateEmployeeLeaveDaysLeft($leave->employee_id);
        return redirect()->route('leaves.index')->with('succes', 'Leave deleted succesfully');
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

            $employee = Employee::where('Name', $row[0])->first();
            $leavetype = LeaveType::where('name', $row[1])->first();

            if ($employee && $leavetype) {
                try {
                    Leave::create([
                        'employee_id' => $employee->id,
                        'leave_type_id' => $leavetype->id,
                        'DateFrom' => $row[2] ?? now()->toDateString(),
                        'DateTo' => $row[3] ?? now()->toDateString(),
                        'LeaveDays' => isset($row[4]) && is_numeric($row[4]) ? (int)$row[4] : 0,
                        'isApproved' => isset($row[5]) && (strtolower($row[5]) === '1' || strtolower($row[5]) === 'true' || strtolower($row[5]) === 'yes'),
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Failed to import row: ' . json_encode($row) . ' Error: ' . $e->getMessage());
                    continue;
                }
            } else {
                \Log::warning('Employee or LeaveType not found for row: ' . json_encode($row));
                continue;
            }
        }

        return redirect()->route('leaves.index')->with('success', 'Leaves imported successfully.');
    }

    
}
