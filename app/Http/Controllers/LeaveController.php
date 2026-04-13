<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LeaveController extends Controller
{
    private function ownedCompanyIds()
    {
        return auth()->user()->companies()->pluck('id');
    }

    private function ownedEmployeeIds()
    {
        return Employee::whereIn('company_id', $this->ownedCompanyIds())->pluck('id');
    }

    private function ownsLeave(Leave $leave): bool
    {
        return $this->ownedEmployeeIds()->contains($leave->employee_id);
    }

    private function updateEmployeeLeaveDaysLeft(int $employeeId): void
    {
        $employee = Employee::find($employeeId);
        if (!$employee) return;

        $annualLeaveType = LeaveType::where('name', 'Annual Leave')->first();

        $taken = $annualLeaveType
            ? Leave::where('employee_id', $employeeId)
                ->where('leave_type_id', $annualLeaveType->id)
                ->where('isApproved', true)
                ->sum('LeaveDays')
            : 0;

        $employee->LeaveDaysLeft = $employee->AnnualLeaveDays - $taken;
        $employee->save();
    }

    public function index()
    {
        $leaves = Leave::whereIn('employee_id', $this->ownedEmployeeIds())->paginate(10);
        return view('leaves.index', compact('leaves'));
    }

    public function create()
    {
        $employees = Employee::whereIn('company_id', $this->ownedCompanyIds())->get();
        $leavetypes = LeaveType::all();
        return view('leaves.create', compact('employees', 'leavetypes'));
    }

    public function store(Request $request)
    {
        $ownedEmployeeIds = $this->ownedEmployeeIds();

        $request->validate([
            'employee_id' => ['required', Rule::exists('employees', 'id')->whereIn('id', $ownedEmployeeIds->toArray())],
            'leave_type_id' => 'required|exists:leave_types,id',
            'DateFrom' => 'required|date',
            'DateTo' => 'required|date|after_or_equal:DateFrom',
            'isApproved' => 'required|boolean',
        ]);

        $leaveDays = Carbon::parse($request->DateFrom)->diffInDays(Carbon::parse($request->DateTo)) + 1;

        Leave::create([
            'employee_id' => $request->employee_id,
            'leave_type_id' => $request->leave_type_id,
            'DateFrom' => $request->DateFrom,
            'DateTo' => $request->DateTo,
            'LeaveDays' => $leaveDays,
            'isApproved' => $request->isApproved,
        ]);

        $this->updateEmployeeLeaveDaysLeft($request->employee_id);

        return redirect()->route('leaves.index')->with('success', 'Leave created successfully.');
    }

    public function show(Leave $leave)
    {
        abort_unless($this->ownsLeave($leave), 403);
        return view('leaves.show', compact('leave'));
    }

    public function edit(Leave $leave)
    {
        abort_unless($this->ownsLeave($leave), 403);
        $employees = Employee::whereIn('company_id', $this->ownedCompanyIds())->get();
        $leavetypes = LeaveType::all();
        return view('leaves.edit', compact('leave', 'employees', 'leavetypes'));
    }

    public function update(Request $request, Leave $leave)
    {
        abort_unless($this->ownsLeave($leave), 403);

        $ownedEmployeeIds = $this->ownedEmployeeIds();

        $request->validate([
            'employee_id' => ['required', Rule::exists('employees', 'id')->whereIn('id', $ownedEmployeeIds->toArray())],
            'leave_type_id' => 'required|exists:leave_types,id',
            'DateFrom' => 'required|date',
            'DateTo' => 'required|date|after_or_equal:DateFrom',
            'isApproved' => 'required|boolean',
        ]);

        $leaveDays = Carbon::parse($request->DateFrom)->diffInDays(Carbon::parse($request->DateTo)) + 1;

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

    public function destroy(Leave $leave)
    {
        abort_unless($this->ownsLeave($leave), 403);

        $employeeId = $leave->employee_id;
        $leave->delete();
        $this->updateEmployeeLeaveDaysLeft($employeeId);

        return redirect()->route('leaves.index')->with('success', 'Leave deleted successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $data = array_map('str_getcsv', file($file));
        $ownedEmployeeIds = $this->ownedEmployeeIds();

        foreach ($data as $index => $row) {
            if ($index === 0) continue;

            $employee = Employee::whereIn('company_id', $this->ownedCompanyIds())
                ->where('Name', $row[0] ?? '')
                ->first();
            $leavetype = LeaveType::where('name', $row[1] ?? '')->first();

            if ($employee && $leavetype) {
                try {
                    Leave::create([
                        'employee_id' => $employee->id,
                        'leave_type_id' => $leavetype->id,
                        'DateFrom' => $row[2] ?? now()->toDateString(),
                        'DateTo' => $row[3] ?? now()->toDateString(),
                        'LeaveDays' => isset($row[4]) && is_numeric($row[4]) ? (int) $row[4] : 0,
                        'isApproved' => isset($row[5]) && in_array(strtolower($row[5]), ['1', 'true', 'yes']),
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Failed to import leave row: ' . json_encode($row) . ' — ' . $e->getMessage());
                }
            } else {
                \Log::warning('Employee or LeaveType not found (or not owned) for leave import row: ' . json_encode($row));
            }
        }

        return redirect()->route('leaves.index')->with('success', 'Leaves imported successfully.');
    }
}
