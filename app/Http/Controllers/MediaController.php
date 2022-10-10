<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

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
        $all_media = Media::latest()->simplePaginate(10);
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
            'name' => 'required|unique:media',
            'abbreviation' => 'required',
            'type' => 'nullable',
            'placement' => 'nullable',
            'numero' => 'nullable',
        ]);

        $stringType = $request->type;
        $arrayType = explode(',', $stringType);
        $newArrayType = array();
        foreach ($arrayType as $type) {
            array_push($newArrayType, trim($type));
        }
        
        $stringPlacement = $request->placement;
        $arrayPlacement = explode(',', $stringPlacement);
        $newArrayPlacement = array();
        foreach ($arrayPlacement as $type) {
            array_push($newArrayPlacement, trim($type));
        }

        $stringNumero = $request->numero;
        $arrayNumero = explode(',', $stringNumero);
        $newArrayNumero = array();
        foreach ($arrayNumero as $numero) {
            array_push($newArrayNumero, strtoupper(trim($numero)));
        }

        try {
            $media = new Media;
            $media->name = $request->name;
            $media->abbreviation = strtoupper($request->abbreviation);
            $media->type = implode(",",$newArrayType);
            $media->placement = implode(",",$newArrayPlacement);
            $media->numero = implode(",", $newArrayNumero);
            $media->save();
        
            // Alert::success('Success', 'Media successfully created.');
            // return redirect()->route('medias.index');
            return redirect()->route('medias.index')->with('success', 'Media successfully created.');

        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());

            return back()->withInput();
        }
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
            'placement' => 'nullable',
            'numero' => 'nullable'
        ]);

        $stringType = $request->type;
        $arrayType = explode(',', $stringType);
        $newArrayType = array();
        foreach ($arrayType as $type) {
            array_push($newArrayType, trim($type));
        }
        
        $stringPlacement = $request->placement;
        $arrayPlacement = explode(',', $stringPlacement);
        $newArrayPlacement = array();
        foreach ($arrayPlacement as $type) {
            array_push($newArrayPlacement, trim($type));
        }

        $stringNumero = $request->numero;
        $arrayNumero = explode(',', $stringNumero);
        $newArrayNumero = array();
        foreach ($arrayNumero as $numero) {
            array_push($newArrayNumero, strtoupper(trim($numero)));
        }
        
        try {
            $media->name = $request->name;
            $media->abbreviation = strtoupper($request->abbreviation);
            $media->type = implode(",",$newArrayType);
            $media->placement = implode(",",$newArrayPlacement);
            $media->numero = implode(",", $newArrayNumero);
            $media->update();
            
            // Alert::success('Success', 'Media successfully updated.');
            // return redirect()->route('medias.index');
            return redirect()->route('medias.index')->with('success', 'Media successfully updated.');

        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());

            return back()->withInput();
        }

    }

    public function destroy(Media $media)
    {
        try {
            $media->delete();
            // Alert::success('Success', 'Media successfully deleted.');
            // return redirect()->route('medias.index');
            return redirect()->route('medias.index')->with('success', 'Media successfully deleted.');

        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());

            return back()->withInput();
        }
    } 
}
