<?php
    
namespace App\Http\Controllers;

use App\Models\Insertion;
use Illuminate\Http\Request;
    
class InsertionController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:insertion-list|insertion-create|insertion-edit|insertion-delete|insertion-export', ['only' => ['index','show']]);
         $this->middleware('permission:insertion-create', ['only' => ['create','store']]);
         $this->middleware('permission:insertion-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:insertion-delete', ['only' => ['destroy']]);
         $this->middleware('permission:insertion-export', ['only' => ['export']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $insertions = Insertion::latest()->paginate(5);
        return view('insertions.index',compact('insertions'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('insertions.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'job_id' => 'required',
            'company' => 'required',
            'brand' => 'nullable',
            'comment' => 'nullable',
            'media' => 'required',
            'type' => 'nullable',
            'placement' => 'nullable',
            'month' => 'required',
            'issue_nr' => 'required',
            'number_of_pages' => 'required|integer',
            'quantity' => 'required|integer',
            'fare' => 'required',
            'invoiced' => 'required',
            'year' => 'required',
        ]);
        
        Insertion::create($request->all());
    
        return redirect()->route('insertions.index')
                        ->with('success','Insertion created successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Insertion  $insertion
     * @return \Illuminate\Http\Response
     */
    public function show(Insertion $insertion)
    {
        return view('insertions.show',compact('insertion'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Insertion  $insertion
     * @return \Illuminate\Http\Response
     */
    public function edit(Insertion $insertion)
    {
        return view('insertions.edit',compact('insertion'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Insertion  $insertion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Insertion $insertion)
    {
         request()->validate([
            'job_id' => 'required',
            'company' => 'required',
            'brand' => 'nullable',
            'comment' => 'nullable',
            'media' => 'required',
            'type' => 'nullable',
            'placement' => 'nullable',
            'month' => 'required',
            'issue_nr' => 'required',
            'number_of_pages' => 'required|integer',
            'quantity' => 'required|integer',
            'fare' => 'required',
            'invoiced' => 'required',
            'year' => 'required',
        ]);
    
        $insertion->update($request->all());
    
        return redirect()->route('insertions.index')
                        ->with('success','Insertion updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Insertion  $insertion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Insertion $insertion)
    {
        $insertion->delete();
    
        return redirect()->route('insertions.index')
                        ->with('success','Insertion deleted successfully');
    }
}