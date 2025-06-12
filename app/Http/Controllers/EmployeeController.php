<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Leave;
use App\Models\Company;
use App\Models\Employee;
use App\Models\LeaveType;
use Illuminate\Http\Request;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::paginate(3);
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
        return view('employees.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'Name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'EmployedInCompany' => 'required|date',
            // 'AnnualLeaveDays' => 'required|integer',  // we will calculate this automatically
            'LeaveDaysLeft' => 'required|integer'
        ]);

        $employedSince = Carbon::parse($request->EmployedInCompany);
        $yearsWorked = $employedSince->diffInYears(Carbon::now());

        $annualLeaveDays = 29 + $yearsWorked;

        $annualLeaveType = LeaveType::where('name', 'Annual Leave')->first();

        $totalAnnualLeaveDays = 0;
        if ($annualLeaveType) {
            $totalAnnualLeaveDays = Leave::where('employee_id', $request->employee_id)
                ->where('leave_type_id', $annualLeaveType->id)
                ->sum('LeaveDays');
        }

        $leaveDaysLeft = $annualLeaveDays - $totalAnnualLeaveDays;


        Employee::create([
            'Name' => $request->Name,
            'company_id' => $request->company_id,
            'EmployedInCompany' => $request->EmployedInCompany,
            'AnnualLeaveDays' => $annualLeaveDays,
            'LeaveDaysLeft' => $leaveDaysLeft,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $companies = Company::all();
        return view('employees.edit', compact('employee', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Employee $employee)
{
    $request->validate([
        'Name' => 'required|string|max:255',
        'company_id' => 'required|exists:companies,id',
        'EmployedInCompany' => 'required|date',
        'LeaveDaysLeft' => 'required|integer'
    ]);

    $employedSince = Carbon::parse($request->EmployedInCompany);
    $yearsWorked = $employedSince->diffInYears(Carbon::now());

    $annualLeaveDays = 29 + $yearsWorked;


    $annualLeaveType = LeaveType::where('name', 'Annual Leave')->first();

    $totalAnnualLeaveDays = 0;
    if ($annualLeaveType) {
        $totalAnnualLeaveDays = Leave::where('employee_id', $request->employee_id)
            ->where('leave_type_id', $annualLeaveType->id)
            ->sum('LeaveDays');
    }

    $leaveDaysLeft = $annualLeaveDays - $totalAnnualLeaveDays;


    $employee->update([
        'Name' => $request->Name,
        'company_id' => $request->company_id,
        'EmployedInCompany' => $request->EmployedInCompany,
        'AnnualLeaveDays' => $annualLeaveDays,
        'LeaveDaysLeft' => $leaveDaysLeft,
    ]);

    return redirect()->route('employees.index')->with('success', 'Employee updated successfully');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('succes', 'Employee deleted succesfully');
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

    $company = Company::where('name', $row[1])->first();

    if ($company) {
        Employee::create([
            'Name' => $row[0] ?? '',
            'company_id' => $company->id,
            'EmployedInCompany' => $row[2] ?? '',
            'AnnualLeaveDays' => $row[3] ?? '',
            'LeaveDaysLeft' => $row[4] ?? ''
        ]);
    } else {
        \Log::warning('Company not found for row: ' . json_encode($row));
        continue;
    }
}


    return redirect()->route('employees.index')->with('success', 'Employees imported successfully.');
    }

}
