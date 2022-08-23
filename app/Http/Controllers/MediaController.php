<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:media-list|media-create|media-edit|media-delete|media-export', ['only' => ['index','show']]);
         $this->middleware('permission:media-create', ['only' => ['create','store']]);
         $this->middleware('permission:media-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:media-delete', ['only' => ['destroy']]);
         $this->middleware('permission:media-export', ['only' => ['export']]);
    }

    public function index(){
        $all_media = Media::latest()->paginate(5);
        return view('medias.index',compact('all_media'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create(){
        return view('medias.create');
    }

    public function show(Media $media)
    {
        return view('medias.show',compact('media'));
    }

    public function store(Request $request){
        request()->validate([
            'name' => 'required',
            'abbreviation' => 'required',
            'type' => 'nullable',
            'placement' => 'nullable',
        ]);

        $media = new Media;
        $media->name = $request->name;
        $media->abbreviation = $request->abbreviation;
        $media->type = $request->type;
        $media->placement = $request->placement;
        $media->save();
    
        return redirect()->route('medias.index')
                        ->with('success','Media created successfully.');
    }

    public function edit(Media $media)
    {
        return view('medias.edit',compact('media'));
    }

    public function update(Request $request, Media $media)
    {
         request()->validate([
            'name' => 'required',
            'abbreviation' => 'required',
            'type' => 'nullable',
            'placement' => 'nullable'
        ]);
    
        $media->update($request->all());
    
        return redirect()->route('medias.index')
                        ->with('success','Media updated successfully');
    }

    public function destroy(Media $media)
    {
        $media->delete();
    
        return redirect()->route('medias.index')
                        ->with('success','Media deleted successfully');
    } 
}
