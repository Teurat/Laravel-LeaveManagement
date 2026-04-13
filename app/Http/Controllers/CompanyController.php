<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = auth()->user()->companies()->withCount('employees')->paginate(10);
        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'NrEmployees'   => 'required|integer|min:0',
            'FoundationYear' => 'required|integer|min:1800|max:' . now()->year,
        ]);

        $company = auth()->user()->companies()->create(
            $request->only('name', 'NrEmployees', 'FoundationYear')
        );

        // Start onboarding wizard if a target headcount was provided
        if ($company->NrEmployees > 0) {
            session([
                'onboarding' => [
                    'company_id'   => $company->id,
                    'company_name' => $company->name,
                    'target'       => $company->NrEmployees,
                    'added'        => 0,
                ],
            ]);

            return redirect()
                ->route('employees.create', ['company_id' => $company->id])
                ->with('info', "Company \"{$company->name}\" created! Register its {$company->NrEmployees} employees below.");
        }

        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }

    public function show(Company $company)
    {
        abort_unless($company->user_id === auth()->id(), 403);
        $company->loadCount('employees');
        return view('companies.show', compact('company'));
    }

    public function edit(Company $company)
    {
        abort_unless($company->user_id === auth()->id(), 403);
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        abort_unless($company->user_id === auth()->id(), 403);

        $request->validate([
            'name' => 'required|string|max:255',
            'NrEmployees' => 'required|integer',
            'FoundationYear' => 'required|integer|min:1800|max:' . now()->year,
        ]);

        $company->update($request->only('name', 'NrEmployees', 'FoundationYear'));

        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        abort_unless($company->user_id === auth()->id(), 403);

        $company->delete();
        return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $data = array_map('str_getcsv', file($file));

        foreach ($data as $index => $row) {
            if ($index === 0) continue;

            auth()->user()->companies()->create([
                'name' => $row[0] ?? '',
                'NrEmployees' => $row[1] ?? 0,
                'FoundationYear' => $row[2] ?? now()->year,
            ]);
        }

        return redirect()->route('companies.index')->with('success', 'Companies imported successfully.');
    }
}

