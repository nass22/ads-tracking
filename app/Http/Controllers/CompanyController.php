<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:company-list|company-create|company-edit|company-delete|company-export', ['only' => ['index','show']]);
         $this->middleware('permission:company-create', ['only' => ['create','store']]);
         $this->middleware('permission:company-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:company-delete', ['only' => ['destroy']]);
         $this->middleware('permission:company-export', ['only' => ['export']]);
    }

    public function index()
    {
        $companies = Company::latest()->paginate(5);
        return view('companies.index',compact('companies'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'abbreviation' => 'required'
        ]);
        
        Company::create($request->all());
    
        return redirect()->route('companies.index')
                        ->with('success','Company created successfully.');
    }

    
    public function edit(Company $company)
    {
        return view('companies.edit',compact('company'));
    }

    public function update(Request $request, Company $company)
    {
         request()->validate([
            'name' => 'required',
            'abbreviation' => 'required',
        ]);
    
        $company->update($request->all());
    
        return redirect()->route('companies.index')
                        ->with('success','Company updated successfully');
    }

    public function destroy(Company $company)
    {
        $company->delete();
    
        return redirect()->route('companies.index')
                        ->with('success','Company deleted successfully');
    }    

}
