<?php

namespace App\Http\Controllers;

use App\Models\InvoiceStatus;
use Illuminate\Http\Request;

class InvoiceStatusController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:invoice_status-list|invoice_status-create|invoice_status-edit|invoice_status-delete|invoice_status-export', ['only' => ['index','show']]);
         $this->middleware('permission:invoice_status-create', ['only' => ['create','store']]);
         $this->middleware('permission:invoice_status-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:invoice_status-delete', ['only' => ['destroy']]);
         $this->middleware('permission:invoice_status-export', ['only' => ['export']]);
    }

    public function index()
    {
        $status = InvoiceStatus::latest()->paginate(5);
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
            'name' => 'required',
        ]);
        
        InvoiceStatus::create($request->all());
    
        return redirect()->route('invoice_status.index')
                        ->with('success','Invoice Status created successfully.');
    }

    
    public function edit(InvoiceStatus $invoice_status)
    {
        return view('invoiceStatus.edit',compact('invoice_status'));
    }

    public function update(Request $request, InvoiceStatus $status)
    {
         request()->validate([
            'name' => 'required',
        ]);
    
        $status->update($request->all());
    
        return redirect()->route('invoiceStatus.index')
                        ->with('success','Invoice Status updated successfully');
    }

    public function destroy(InvoiceStatus $invoice_status)
    {
        $invoice_status->delete();
    
        return redirect()->route('invoice_status.index')
                        ->with('success','Invoice Status deleted successfully');
    } 
}
