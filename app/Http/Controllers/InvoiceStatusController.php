<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\InvoiceStatus;
use RealRashid\SweetAlert\Facades\Alert;

class InvoiceStatusController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:invoice_statuses-list|invoice_statuses-create|invoice_statuses-edit|invoice_statuses-delete|invoice_statuses-export', ['only' => ['index','show']]);
         $this->middleware('permission:invoice_statuses-create', ['only' => ['create','store']]);
         $this->middleware('permission:invoice_statuses-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:invoice_statuses-delete', ['only' => ['destroy']]);
         $this->middleware('permission:invoice_statuses-export', ['only' => ['export']]);
    }

    public function index()
    {
        $status = InvoiceStatus::latest()->simplePaginate(10);
        return view('invoiceStatus.index',compact('status'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('invoiceStatus.create');
    }

    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required|unique:App\Models\invoiceStatus,name',
        ]);
        
        try {
            InvoiceStatus::create([
                'name' => Str::upper($request->name)
            ]);
            Alert::success('Success','Invoice Status successfully created.');

            return redirect()->route('invoice_status.index');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());

            return back()->withInput();
        }
    }

    
    public function edit(InvoiceStatus $invoice_status)
    {
        return view('invoiceStatus.edit',compact('invoice_status'));
    }

    public function update(Request $request, InvoiceStatus $invoice_status)
    {
         request()->validate([
            'name' => 'required|unique:App\Models\invoiceStatus,name',
        ]);
        
        try {
            $invoice_status->name = Str::upper($request->name);
            
            $invoice_status->update();
            
            Alert::success('Success','Invoice Status successfully updated.');

            return redirect()->route('invoice_status.index');
        } catch (\Throwable $th) {
            Alert::error('error', $th->getMessage());
            
            return back()->withInput();
        }
        
    }

    public function destroy(InvoiceStatus $invoice_status)
    {
        try {
            $invoice_status->delete();
            Alert::success('Success','Invoice Status successfully deleted.');

            return redirect()->route('invoice_status.index');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            
            return back()->withInput();
        } 
    } 
}
