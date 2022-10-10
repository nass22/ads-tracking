<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\User;
use App\Models\Media;
use App\Models\Company;
use App\Models\Insertion;
use App\Models\InvoiceStatus;
use App\Models\IssueNrs;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {   
        if ($request->ajax()) {
            
            if ($request->get('check') == "false") {

                $data = Insertion::where('invoice_status', 'OPEN')->orderBy('id', 'desc')->get();
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
                                } else if (Str::contains(Str::lower($row['deadline']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['rcvd']), Str::lower($request->get('search')))) {
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
                    ->addColumn('deadline', function($row){
                        $insertion = Insertion::where('id', $row->id)->first();
                        $issue_id = $insertion->issue_nr;

                        $issue = IssueNrs::where('id', $issue_id)->first();
                        $issue_deadline = $issue->deadline;
                        
                        return $issue_deadline;
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
                        </form>
                        <script>
                        $(".delete-confirm").on("click", function (event) {
                            var form =  $(this).closest("form");
                            event.preventDefault();
                            new swal({
                                title: "Are you sure?",
                                text: "This record and it`s details will be permanantly deleted!",
                                icon: "warning",
                                buttons: {
                                    cancel: true,
                                    confirm: true,
                                  },
                            }).then(function(value) {
                                if (value) {
                                    form.submit();
                                }
                            });
                        });
                        </script>
                        ';

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
}