<?php
    
namespace App\Http\Controllers;

use DataTables;
use App\Models\User;
use App\Models\Brand;
use App\Models\Media;
use App\Models\Company;
use App\Models\IssueNrs;
use App\Models\Insertion;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\InvoiceStatus;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
    
class InsertionController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:insertions-list|insertions-create|insertions-edit|insertions-delete|insertions-export', ['only' => ['index','show']]);
         $this->middleware('permission:insertions-create', ['only' => ['create','store']]);
         $this->middleware('permission:insertions-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:insertions-delete', ['only' => ['destroy']]);
         $this->middleware('permission:insertions-export', ['only' => ['export']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            
            if ($request->get('check') == "false") {
                $data = Insertion::where('invoice_status', 'open')->orderBy('id', 'desc')->get();
            } else {
                $data = Insertion::orderBy('id', 'desc')->get();
            }
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('search'))) {
                            
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                
                                if (Str::contains(Str::lower($row['id']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['author']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['job_id']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['company']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['brand']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['comment']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['media']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['type']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['placement']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['issue_nr']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['quantity']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['fare']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['invoiced']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['invoice_nr']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['year']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['status']), Str::lower($request->get('search')))) {
                                    return true;
                                }
                                return false;
                            });
                        }
                    })
                    ->addColumn('action', function($row){
                        $siteEdit= route('insertions.edit',$row->id);
                        $siteDelete = route('insertions.destroy', $row->id);
                       
                        $btn = '
                        <a href="'. $siteEdit .'" class="edit btn btn-primary btn-sm" target="_blank">Edit</a>
                        <form action="' . $siteDelete. '" method="POST">
                        '.csrf_field().'
                        '.method_field("DELETE").'
                        <button type="submit" class="btn btn-danger delete-confirm">Delete</button>
                        </form>';

                        

                        $insertion = Insertion::where('id', $row->id)->first();

                        if($insertion->user_id == Auth::user()->id || Str::lower(Auth::user()->role) == "admin"){
                            return $btn;
                        }
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('home');
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
            'media' => 'required',
            'issue_nr' => 'required',
            'type' => 'nullable',
            'placement' => 'nullable',
            'brand' => 'nullable',
            'comment' => 'nullable',
            'quantity' => 'required|integer',
            'fare' => 'required',
            'invoice_nr' => 'nullable',
            'invoiced' => 'nullable',
            'year' => 'required',
            'rcvd' => 'nullable',
        ]);

        $media = json_decode($request->media);
        $mediaId = $media->id;
        
        
        try {
            $insertion = new Insertion;
            $insertion->user_id = $request->user_id;
            $insertion->job_id = $request->job_id;
            $insertion->company = $request->company;
            $insertion->media = $mediaId;
            $insertion->issue_nr = $request->issue_nr;
            $insertion->type = $request->type;
            $insertion->placement = $request->placement;
            $insertion->brand = Str::ucfirst($request->brand);
            if (!(Brand::where('name', $request->brand))->exists() && $request->brand != null){
                $brand = new Brand;
                $brand->name = Str::ucfirst($request->brand);
                $brand->save();
            }
            $insertion->comment = $request->comment;
            $insertion->quantity = $request->quantity;
            $insertion->fare = $request->fare;
            $insertion->invoice_nr = $request->invoice_nr;

            if($request->invoice_nr != null){
                $insertion->invoiced = 2;
                $insertion->invoice_status = "CLOSE";
            } else {
                // A MODIF SI ON GENRE LE STATUS EN BACK -> $insertion->invoiced = "NO";
                $insertion->invoiced = $request->invoiced;
                $insertion->invoice_status = "OPEN";
            }

            $insertion->year = $request->year;

            if($request->checkRCVD != null){
                $insertion->rcvd = "YES";
            }
            
            $insertion->save();

            Alert::success('Success','Insertion successfully created.');

            return redirect()->route('insertions.index');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());

            return back()->withInput();
        }
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
            'media' => 'required',
            'issue_nr' => 'required',
            'type' => 'nullable',
            'placement' => 'nullable',
            'brand' => 'nullable',
            'comment' => 'nullable',
            'quantity' => 'required|integer',
            'fare' => 'required',
            'invoice_nr' => 'nullable',
            'invoiced' => 'nullable',
            'rcvd' => 'nullable',
            'year' => 'required',
        ]);

        $media = json_decode($request->media);
        $mediaId = $media->id;

        try {
            $insertion->user_id = $request->user_id;
            $insertion->job_id = $request->job_id;
            $insertion->company = $request->company;
            $insertion->media = $mediaId;
            $insertion->issue_nr = $request->issue_nr;
            $insertion->type = $request->type;
            $insertion->placement = $request->placement;
            $insertion->brand = Str::ucfirst($request->brand);
            if (!(Brand::where('name', $request->brand))->exists() && $request->brand != null){
                $brand = new Brand;
                $brand->name = Str::ucfirst($request->brand);
                $brand->save();
            }
            $insertion->comment = $request->comment;
            $insertion->quantity = $request->quantity;
            $insertion->fare = $request->fare;
            $insertion->invoice_nr = $request->invoice_nr;

            if($request->invoice_nr != null){
                $insertion->invoiced = 2;
                $insertion->invoice_status = "CLOSE";
            } else {
                // A MODIF SI ON GENRE LE STATUS EN BACK -> $insertion->invoiced = "NO";
                $insertion->invoiced = $request->invoiced;
                $insertion->invoice_status = "OPEN";
            }

            $insertion->year = $request->year;

            if($request->checkRCVD != null){
                $insertion->rcvd = "YES";
            }

            $insertion->update();

            Alert::success('Success','Insertion successfully updated.');

            return redirect()->route('insertions.index');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());

            return back()->withInput();
        }
        
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Insertion  $insertion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Insertion $insertion)
    {   
        try {
            $insertion->delete();
            
            Alert::success('Success','Insertion successfully deleted.');

            return redirect()->route('insertions.index');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());

            return back()->withInput();
        }
    }

    public function myInsertions(Request $request){
        $user_id = Auth::user()->id;
        
        if ($request->ajax()) {
           
            if ($request->get('check') == "false") {
                $data = Insertion::where('user_id', $user_id)->whereNot('invoice_status', 'CLOSE')->orderBy('id', 'desc')->get();
            } else {
                $data = Insertion::where('user_id', $user_id)->orderBy('id', 'desc')->get();
            }

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('search'))) {
                            
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                
                                if (Str::contains(Str::lower($row['id']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['author']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['job_id']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['company']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['brand']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['comment']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['media']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['type']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['placement']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['issue_nr']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['quantity']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['fare']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['invoiced']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['invoice_nr']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['year']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['status']), Str::lower($request->get('search')))) {
                                    return true;
                                }
                                return false;
                            });
                        }

                        if (!empty($request->get('search_job_id'))) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                if (Str::contains(Str::lower($row['job_id']), Str::lower($request->get('search_job_id')))){
                                    return true;
                                }
                                return false;
                            });
                        }
                        if (!empty($request->get('search_company'))) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                if (Str::contains(Str::lower($row['company']), Str::lower($request->get('search_company')))){
                                    return true;
                                }
                                return false;
                            });
                        }
                        if (!empty($request->get('search_brand'))) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                if (Str::contains(Str::lower($row['brand']), Str::lower($request->get('search_brand')))){
                                    return true;
                                }
                                return false;
                            });
                        }
                        if (!empty($request->get('search_media'))) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                if (Str::contains(Str::lower($row['media']), Str::lower($request->get('search_media')))){
                                    return true;
                                }
                                return false;
                            });
                        }
                        if (!empty($request->get('search_issue_nr'))) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                if (Str::contains(Str::lower($row['issue_nr']), Str::lower($request->get('search_issue_nr')))){
                                    return true;
                                }
                                return false;
                            });
                        }
                        if (!empty($request->get('search_status'))) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                if (Str::contains(Str::lower($row['invoice_status']), Str::lower($request->get('search_status')))){
                                    return true;
                                }
                                return false;
                            });
                        }
                    })
                    ->addColumn('author', function($row){
                        $insertion = Insertion::where('id', $row->id)->first();
                        $user_id = $insertion->user_id;

                        $user = User::where('id', $user_id)->first();
                        $user_name = $user->name;
                        
                        return $user_name;
                    })
                    ->addColumn('company', function($row){
                        $insertion = Insertion::where('id', $row->id)->first();
                        $company_id = $insertion->company;

                        $company = Company::where('id', $company_id)->first();
                        $company_abbr = $company->abbreviation;
                        
                        return $company_abbr;
                    })
                    ->addColumn('media', function($row){
                        $insertion = Insertion::where('id', $row->id)->first();
                        $media_id = $insertion->media;

                        $media = Media::where('id', $media_id)->first();
                        $media_abbr = $media->abbreviation;
                        
                        return $media_abbr;
                    })
                    ->addColumn('issue_nr', function($row){
                        $insertion = Insertion::where('id', $row->id)->first();
                        $issue_id = $insertion->issue_nr;

                        $issue = IssueNrs::where('id', $issue_id)->first();
                        $issue_final = $issue->final_issue;
                        
                        return $issue_final;
                    })
                    ->addColumn('invoiced', function($row){
                        $insertion = Insertion::where('id', $row->id)->first();
                        $invoiced_id = $insertion->invoiced;

                        $invoice_status = InvoiceStatus::where('id', $invoiced_id)->first();
                        $invoice_name = $invoice_status->name;
                        
                        return $invoice_name;
                    })
                    ->addColumn('action', function($row){
                        $siteEdit= route('insertions.edit',$row->id);
                        $siteDelete = route('insertions.destroy', $row->id);
                       
                        $btn = '
                        <a href="'. $siteEdit .'" class="btn btn-primary edit" target="_blank"><i class="fa-regular fa-pen-to-square"></i></a>
                        <form action="' . $siteDelete. '" method="POST">
                        '.csrf_field().'
                        '.method_field("DELETE").'
                        <button type="submit" class="btn btn-danger delete-confirm mt-2"><i class="fa-solid fa-trash"></i></button>
                        </form>';

                        $insertion = Insertion::where('id', $row->id)->first();

                        if($insertion->user_id == Auth::user()->id || Str::lower(Auth::user()->role) == "admin"){
                            return $btn;
                        }
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('insertions.personalIns');
    }
}