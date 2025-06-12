<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the companies.
     */
    public function index()
    {
        $companies = Company::paginate(3);
        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new company.
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created company in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'NrEmployees' => 'required|integer',
            'FoundationYear' => 'required|integer|min:1800|max:' . now()->year,
        ]);

        Company::create($request->only('name', 'NrEmployees', 'FoundationYear'));

        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }

    /**
     * Display the specified company.
     */
    public function show(Company $company)
    {
        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified company.
     */
    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified company in the database.
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'NrEmployees' => 'required|integer',
            'FoundationYear' => 'required|integer|min:1800|max:' . now()->year,
        ]);

        $company->update($request->all());

        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }

   
    public function destroy(Company $company)
    {
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
        if ($index === 0) continue; // skip header row

        Company::create([
            'name' => $row[0] ?? '',
            'NrEmployees' => $row[1] ?? '',
            'FoundationYear' => $row[2] ?? ''
        ]);
    }

    return redirect()->route('companies.index')->with('success', 'Companies imported successfully.');
    }

}

