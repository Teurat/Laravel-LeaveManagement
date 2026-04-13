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
        $companyIds = auth()->user()->companies()->pluck('id');
        $employeeIds = Employee::whereIn('company_id', $companyIds)->pluck('id');

        $totalEmployees = Employee::whereIn('company_id', $companyIds)->count();
        $totalCompanies = auth()->user()->companies()->count();

        $employeesPerCompany = auth()->user()->companies()
            ->withCount('employees')
            ->get()
            ->pluck('employees_count', 'name');

        $totalAnnualLeaveDays = Employee::whereIn('company_id', $companyIds)->sum('AnnualLeaveDays');

        $today = now()->toDateString();
        $employeesOnLeave = Leave::whereIn('employee_id', $employeeIds)
            ->where('isApproved', true)
            ->where('DateFrom', '<=', $today)
            ->where('DateTo', '>=', $today)
            ->distinct('employee_id')
            ->count('employee_id');

        $pendingApprovals = Leave::whereIn('employee_id', $employeeIds)
            ->where('isApproved', false)
            ->count();

        $hiredPerYear = Employee::whereIn('company_id', $companyIds)
            ->selectRaw('YEAR(EmployedInCompany) as year, COUNT(*) as count')
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
