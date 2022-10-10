<?php

namespace App\Http\Controllers;

use DataTables;
use DateTime;
use App\Models\Media;
use App\Models\IssueNrs;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class IssueNrsController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:issue_nrs-list|issue_nrs-create|issue_nrs-edit|issue_nrs-delete|issue_nrs-export', ['only' => ['index','show']]);
         $this->middleware('permission:issue_nrs-create', ['only' => ['create','store']]);
         $this->middleware('permission:issue_nrs-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:issue_nrs-delete', ['only' => ['destroy']]);
         $this->middleware('permission:issue_nrs-export', ['only' => ['export']]);
    }

    public function index(Request $request){
        // $all_issue = IssueNrs::latest()->simplePaginate(10);
        // return view('issueNr.index', compact('all_issue'));

        if ($request->ajax()) {
            $data = IssueNrs::orderBy('media', 'asc')->get();
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        
                        if (!empty($request->get('search'))) {
                            
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                
                                if (Str::contains(Str::lower($row['id']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['media']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['final_issue']), Str::lower($request->get('search')))) {
                                    return true;
                                } else if (Str::contains(Str::lower($row['deadline']), Str::lower($request->get('search')))) {
                                    return true;
                                } 
                                return false;
                            });
                        }
                        if (!empty($request->get('search_issue_nr'))) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                if (Str::contains(Str::lower($row['final_issue']), Str::lower($request->get('search_issue_nr')))){
                                    return true;
                                }
                                return false;
                            });
                        }
                    })
                    ->addColumn('action', function($row){
                        $siteEdit= route('issue_nr.edit',$row->id);
                        $siteDelete = route('issue_nr.destroy', $row->id);
                       
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

                       return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('issueNr.index');
    }

    public function create(){
        return view('issueNr.create');
    }
    
    public function store(Request $request, IssueNrs $issue){
        request()->validate([
            'media' => 'required',
            'numero' => 'nullable',
            'month' => 'nullable',
            'year' => 'nullable',
            'day' => 'nullable',
            'week' => 'nullable',
            'deadline' => 'nullable'
        ]);

        $mediaInput = json_decode($request->media);
        $mediaName = $mediaInput->name;
        $media = Media::where('name', $mediaName)->first();
        
        $media_id = $media->id;
        $media_abbre = $media->abbreviation;
        
        try {
            if ($mediaName == "Tempo Focus" || $mediaName == "Tempo Congress"){
                $issue->user_id = $request->user_id;
                $issue->media_id = $media_id;
                $issue->media = $mediaName;
                $issue->numero = strtoupper($request->numero);
                $issue->year = $request->year;
                $issue->month = $request->month;
                $issue->final_issue = $media_abbre . "-" . strtoupper($request->numero) . "_" .  substr($request->year, -2) . $request->month;
                $issue->deadline = $request->deadline;

                $issue->save();
            } elseif ($mediaName == "Tempo Medical" || $mediaName == "BJP"){
                $issue->user_id = $request->user_id;
                $issue->media_id = $media_id;
                $issue->media = $mediaName;
                $issue->numero = $request->numero;
                $issue->year = $request->year;
                $issue->month = $request->month;
                $issue->final_issue = $media_abbre . $request->numero . "_" . substr($request->year, -2) . $request->month;
                $issue->deadline = $request->deadline;
    
                $issue->save();
            } elseif ($mediaName == "Tempo Today" || $mediaName == "Tempo Week-end" || $mediaName == "eMail"){
                $date = $request->week;
                $newDate = new DateTime($date);
                $week = $newDate->format('W');
                
                $dateParse =date_parse($date);
                if($dateParse['month'] < 10){
                    $dateParse['month'] = "0" . $dateParse['month'];
                }
    
                if($dateParse['day'] < 10){
                    $dateParse['day'] = "0" . $dateParse['day'];
                }
                
                $issue->user_id = $request->user_id;
                $issue->media_id = $media_id;
                $issue->media = $mediaName;
                $issue->year = $dateParse['year'];
                $issue->month = $dateParse['month'];
                $issue->day = $dateParse['day'];
                $issue->week = $week;
                $issue->final_issue = $media_abbre . "_" . substr($dateParse['year'], -2) . $dateParse['month'] . $dateParse['day'] . "_" . $week;
                $issue->deadline = $request->deadline;
    
                $issue->save();
            } else {
                $issue->user_id = $request->user_id;
                $issue->media_id = $media_id;
                $issue->media = $mediaName;
                $issue->year = $request->year;
                $issue->month = $request->month;
                $issue->final_issue = $media_abbre . "_" . substr($request->year, -2) . $request->month;
                $issue->deadline = $request->deadline;
    
                $issue->save();
            }

            // Alert::success('Success', 'Issue Nr successfully created');
            // return redirect()->route('issue_nr.index');

            return redirect()->route('issue_nr.index')->with('success', 'Issue successfully created.');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());

            return back()->withInput();
        }
    }

    public function edit(IssueNrs $issue_nr){
        return view('issueNr.edit',compact('issue_nr'));
    }

    public function update(Request $request, IssueNrs $issue_nr){
        request()->validate([
            'media' => 'required',
            'numero' => 'nullable',
            'month' => 'nullable',
            'year' => 'nullable',
            'day' => 'nullable',
            'week' => 'nullable',
            'deadline' => 'nullable'
        ]);

        $media = json_decode($request->media);
        
        $mediaName = $media->name;
        
        $media_id = $media->id;
        $media_abbre = $media->abbreviation;
        
        try {
            if ($mediaName == "Tempo Focus" || $mediaName == "Tempo Congress"){
                $issue_nr->user_id = $request->user_id;
                $issue_nr->media_id = $media_id;
                $issue_nr->media = $mediaName;
                $issue_nr->numero = strtoupper($request->numero);
                $issue_nr->year = $request->year;
                $issue_nr->month = $request->month;
                $issue_nr->final_issue = $media_abbre . "-" . strtoupper($request->numero) . "_" .  substr($request->year, -2) . $request->month;
                $issue_nr->deadline = $request->deadline;
    
                $issue_nr->update();
            } elseif ($mediaName == "Tempo Medical" || $mediaName == "BJP"){
                $issue_nr->user_id = $request->user_id;
                $issue_nr->media_id = $media_id;
                $issue_nr->media = $mediaName;
                $issue_nr->numero = $request->numero;
                $issue_nr->year = $request->year;
                $issue_nr->month = $request->month;
                $issue_nr->final_issue = $media_abbre . $request->numero . "_" . substr($request->year, -2) . $request->month;
                $issue_nr->deadline = $request->deadline;
    
                $issue_nr->update();
            } elseif ($mediaName == "Tempo Today" || $mediaName == "Tempo Week-end" || $mediaName == "eMail"){
                $date = $request->week;
                $newDate = new DateTime($date);
                $week = $newDate->format('W');
                
                $dateParse =date_parse($date);
                if($dateParse['month'] < 10){
                    $dateParse['month'] = "0" . $dateParse['month'];
                }
    
                if($dateParse['day'] < 10){
                    $dateParse['day'] = "0" . $dateParse['day'];
                }
                
                $issue_nr->user_id = $request->user_id;
                $issue_nr->media_id = $media_id;
                $issue_nr->media = $mediaName;
                $issue_nr->year = $dateParse['year'];
                $issue_nr->month = $dateParse['month'];
                $issue_nr->day = $dateParse['day'];
                $issue_nr->week = $week;
                $issue_nr->final_issue = $media_abbre . "_" . substr($dateParse['year'], -2) . $dateParse['month'] . $dateParse['day'] . "_" . $week;
                $issue_nr->deadline = $request->deadline;
    
                $issue_nr->update();
            } else {
                $issue_nr->user_id = $request->user_id;
                $issue_nr->media_id = $media_id;
                $issue_nr->media = $mediaName;
                $issue_nr->year = $request->year;
                $issue_nr->month = $request->month;
                $issue_nr->final_issue = $media_abbre . "_" . substr($request->year, -2) . $request->month;
                $issue_nr->deadline = $request->deadline;
    
                $issue_nr->update();
            }
            
            // Alert::success('Success', 'Issue Nr successfully updated');
            // return redirect()->route('issue_nr.index');

            return redirect()->route('issue_nr.index')->with('success', 'Issue successfully updated.');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());

            return back()->withInput();
        }
    }

    public function destroy(IssueNrs $issue_nr)
    {
        try {
            $issue_nr->delete();
            // Alert::success('success','Issue Nr successfully deleted');
    
            // return redirect()->route('issue_nr.index');

            return redirect()->route('issue_nr.index')->with('success', 'Issue successfully deleted.');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());

            return back()->withInput();
        }

    } 
}
