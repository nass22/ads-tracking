<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Brand;
use App\Models\Media;
use App\Models\Company;
use App\Models\IssueNrs;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function indexCompany(){
        $companies = Company::orderBy('name', 'asc')->get();
        return $companies;
    }

    public function storeCompany(Request $request){
        request()->validate([
            'name' => 'required',
            'abbreviation' => 'required'
        ]);
        
        $company = new Company;
        $company->name = $request->name;
        $company->abbreviation = $request->abbreviation;
        $company->save();
    }

    public function getIssue(Request $request){
        $mediaId = $request->media;
        $year = date("Y");
        
        $all_issue = IssueNrs::where('media_id', $mediaId)->where('year', '>=', $year)->get();
        return $all_issue;
    }

    public function liveSearch(Request $request){
        if($request->ajax()){
            $brands = Brand::where('name', 'LIKE', '%'.$request->brand.'%')->get();

            if($brands){
                return $brands;
            }

        }
    }

    public function issueExist(Request $request){
        
        if ($request->ajax()) {
            $media = $request->get('media');
            
            if($media == "all"){
                $data = IssueNrs::all();
            } else {
                $data = IssueNrs::where('media', $media)->get();
            }
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        
                        if (!empty($request->get('search'))) {
                            
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                
                                if (Str::contains(Str::lower($row['final_issue']), Str::lower($request->get('search')))) {
                                    return true;
                                }
                                return false;
                            });
                        }
                    })
                    ->make(true);
        }
        return view('issueNr.create');
    }
}
