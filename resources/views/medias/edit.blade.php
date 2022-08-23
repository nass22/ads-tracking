@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Media</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('medias.index') }}">Back</a>
        </div>
    </div>
</div>


@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<form action="{{ route('medias.update',$media->id) }}" method="POST">
    @csrf
    @method('PUT')


     <div class="row mt-3">

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" value="{{ $media->name }}" class="form-control" placeholder="Media name">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Abbreviation:</strong>
                <input type="text" name="abbreviation" value="{{ $media->abbreviation }}" class="form-control" placeholder="Media abbreviation">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Type:</strong>
                <input type="text" name="type" value="{{ $media->type }}" class="form-control" placeholder="Media type">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Placement:</strong>
                <input type="text" name="placement" value="{{ $media->placement }}" class="form-control" placeholder="Media placement">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
            <button type="submit" class="btn btn-primary" id='add'>Submit</button>
        </div>

@endsection