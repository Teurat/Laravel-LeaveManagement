<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Leave;
use App\Models\Company;
use App\Models\Employee;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    private function ownedCompanyIds()
    {
        return auth()->user()->companies()->pluck('id');
    }

    private function ownsEmployee(Employee $employee): bool
    {
        return $this->ownedCompanyIds()->contains($employee->company_id);
    }

    private function calculateAnnualLeaveDays(string $employedSince): int
    {
        return 28 + Carbon::parse($employedSince)->diffInYears(Carbon::now());
    }

    public function index()
    {
        $employees = Employee::whereIn('company_id', $this->ownedCompanyIds())->paginate(10);
        return view('employees.index', compact('employees'));
    }

    public function create(Request $request)
    {
        $companies = auth()->user()->companies()->get();
        $preselectedCompanyId = $request->query('company_id');
        $onboarding = session('onboarding');
        return view('employees.create', compact('companies', 'preselectedCompanyId', 'onboarding'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Name'              => 'required|string|max:255',
            'company_id'        => ['required', Rule::exists('companies', 'id')->where('user_id', auth()->id())],
            'EmployedInCompany' => 'required|date',
        ]);

        $annualLeaveDays = $this->calculateAnnualLeaveDays($request->EmployedInCompany);

        Employee::create([
            'Name'             => $request->Name,
            'company_id'       => $request->company_id,
            'EmployedInCompany' => $request->EmployedInCompany,
            'AnnualLeaveDays'  => $annualLeaveDays,
            'LeaveDaysLeft'    => $annualLeaveDays,
        ]);

        // Handle onboarding wizard
        $onboarding = session('onboarding');

        if ($onboarding && (int) $onboarding['company_id'] === (int) $request->company_id) {
            $onboarding['added']++;
            $remaining = $onboarding['target'] - $onboarding['added'];

            if ($remaining > 0) {
                session(['onboarding' => $onboarding]);

                return redirect()
                    ->route('employees.create', ['company_id' => $request->company_id])
                    ->with('success', "Employee {$onboarding['added']} of {$onboarding['target']} added. {$remaining} remaining.");
            }

            // All employees registered — finish wizard
            $companyId   = $onboarding['company_id'];
            $companyName = $onboarding['company_name'];
            $total       = $onboarding['target'];
            session()->forget('onboarding');

            return redirect()
                ->route('companies.show', $companyId)
                ->with('success', "All {$total} employees registered for \"{$companyName}\"!");
        }

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        abort_unless($this->ownsEmployee($employee), 403);
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        abort_unless($this->ownsEmployee($employee), 403);
        $companies = auth()->user()->companies()->get();
        return view('employees.edit', compact('employee', 'companies'));
    }

    public function update(Request $request, Employee $employee)
    {
        abort_unless($this->ownsEmployee($employee), 403);

        $request->validate([
            'Name' => 'required|string|max:255',
            'company_id' => ['required', Rule::exists('companies', 'id')->where('user_id', auth()->id())],
            'EmployedInCompany' => 'required|date',
        ]);

        $annualLeaveDays = $this->calculateAnnualLeaveDays($request->EmployedInCompany);

        $employee->update([
            'Name' => $request->Name,
            'company_id' => $request->company_id,
            'EmployedInCompany' => $request->EmployedInCompany,
            'AnnualLeaveDays' => $annualLeaveDays,
        ]);

        // Recalculate leave balance now that AnnualLeaveDays may have changed
        $this->recalculateLeaveDaysLeft($employee->id);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        abort_unless($this->ownsEmployee($employee), 403);

        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    public function skipOnboarding()
    {
        $onboarding = session('onboarding');
        $companyId  = $onboarding['company_id'] ?? null;
        $added      = $onboarding['added'] ?? 0;
        $target     = $onboarding['target'] ?? 0;
        session()->forget('onboarding');

        if ($companyId) {
            return redirect()
                ->route('companies.show', $companyId)
                ->with('info', "{$added} of {$target} employees registered. You can add the rest anytime from the Employees section.");
        }

        return redirect()->route('companies.index');
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $data = array_map('str_getcsv', file($file));
        $ownedCompanyIds = $this->ownedCompanyIds();

        foreach ($data as $index => $row) {
            if ($index === 0) continue;

            $company = auth()->user()->companies()->where('name', $row[1] ?? '')->first();

            if ($company) {
                $annualLeaveDays = isset($row[2]) ? $this->calculateAnnualLeaveDays($row[2]) : 28;
                Employee::create([
                    'Name' => $row[0] ?? '',
                    'company_id' => $company->id,
                    'EmployedInCompany' => $row[2] ?? now()->toDateString(),
                    'AnnualLeaveDays' => $annualLeaveDays,
                    'LeaveDaysLeft' => $annualLeaveDays,
                ]);
            } else {
                \Log::warning('Company not found (or not owned) for import row: ' . json_encode($row));
            }
        }

        return redirect()->route('employees.index')->with('success', 'Employees imported successfully.');
    }

    private function recalculateLeaveDaysLeft(int $employeeId): void
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
}
