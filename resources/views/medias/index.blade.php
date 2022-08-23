@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Media</h2>
            </div>
            <div class="pull-right">
                @can('media-create')
                <a class="btn btn-success mb-3" href="{{ route('medias.create') }}"> Create New media</a>
                @endcan
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Abbreviation</th>
            <th>Type</th>
            <th>Placement</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($all_media as $media)
	    <tr>
	        <td>{{ $loop->index }}</td>
	        <td>{{ $media->name }}</td>
	        <td>{{ $media->abbreviation }}</td>
            <td>{{ $media->type }}</td>
            <td>{{ $media->placement }}</td>
	        <td>
                <form action="{{ route('medias.destroy',$media->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('medias.show',$media->id) }}">Show</a>
                    @can('media-edit')
                    <a class="btn btn-primary" href="{{ route('medias.edit',$media->id) }}">Edit</a>
                    @endcan


                    @csrf
                    @method('DELETE')
                    @can('media-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>


    {{-- {!! $media->links() !!} --}}

@endsection