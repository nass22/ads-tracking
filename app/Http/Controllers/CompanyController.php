<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use RealRashid\SweetAlert\Facades\Alert;

class CompanyController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:companies-list|companies-create|companies-edit|companies-delete|companies-export', ['only' => ['index','show']]);
         $this->middleware('permission:companies-create', ['only' => ['create','store']]);
         $this->middleware('permission:companies-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:companies-delete', ['only' => ['destroy']]);
         $this->middleware('permission:companies-export', ['only' => ['export']]);
    }

    public function index()
    {
        $companies = Company::orderBy('name', 'asc')->simplePaginate(10);
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

        try {
            Company::create([
                'name' => $request->name,
                'abbreviation' => Str::upper($request->abbreviation)
            ]);

            // Alert::success('Success','Company successfully created.');
            // return redirect()->route('companies.index');
            return redirect()->route('companies.index')->with('success', 'Company successfully created.');

        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());

            return back()->withInput();
        }
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

        try {
            $company->name = $request->name;
            $company->abbreviation = Str::upper($request->abbreviation);
            $company->update();

            // Alert::success('Success','Company successfully updated.');
            // return redirect()->route('companies.index');
            return redirect()->route('companies.index')->with('success', 'Company successfully updated.');
            
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());

            return back()->withInput();
        }
        
    }

    public function destroy(Company $company)
    {
        try {
            $company->delete();

            // Alert::success('Success','Company successfully deleted.');
            // return redirect()->route('companies.index');
            return redirect()->route('companies.index')->with('success', 'Company successfully deleted.');

        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());

            return back()->withInput();
        }
        
    }

}
