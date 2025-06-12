<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Company;
use App\Models\Leave;

class DashboardController extends Controller
{
    public function index()
    {
        // Total employees
        $totalEmployees = Employee::count();

        $totalCompanies = Company::count();

        // Employees per company
        $employeesPerCompany = Company::withCount('employees')->get()
            ->pluck('employees_count', 'name');

        // Total annual leave days accumulated
        $totalAnnualLeaveDays = Employee::sum('AnnualLeaveDays');

        // Employees currently on leave (today between DateFrom and DateTo)
        $today = now()->toDateString();
        $employeesOnLeave = Leave::where('isApproved', true)
            ->where('DateFrom', '<=', $today)
            ->where('DateTo', '>=', $today)
            ->distinct('employee_id')
            ->count('employee_id');

        $pendingApprovals = Leave::where('isApproved', false)->count();

        // Employees hired per year (for chart)
        $hiredPerYear = Employee::selectRaw('YEAR(EmployedInCompany) as year, COUNT(*) as count')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();


        return view('dashboard', [
            'totalEmployees' => $totalEmployees,
            'totalCompanies' => $totalCompanies,
            'employeesPerCompany' => $employeesPerCompany,
            'totalAnnualLeaveDays' => $totalAnnualLeaveDays,
            'employeesOnLeave' => $employeesOnLeave,
            'pendingApprovals' => $pendingApprovals,
            'hiredPerYear' => $hiredPerYear,
        ]);
    }
}
