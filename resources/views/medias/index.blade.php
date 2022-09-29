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

    <table class="table table-bordered">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Abbreviation</th>
            <th>Type</th>
            <th>Placement</th>
            <th>Numero</th>
            <th width="160px">Action</th>
        </tr>
	    @foreach ($all_media as $media)
	    <tr>
	        <td>{{ $loop->index+1 }}</td>
	        <td>{{ $media->name }}</td>
	        <td>{{ $media->abbreviation }}</td>
            <td>{{ $media->type }}</td>
            <td>{{ $media->placement }}</td>
            <td>{{ $media->numero }}</td>
	        <td>
                <form action="{{ route('medias.destroy',$media->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('medias.show',$media->id) }}"><i class="fa-solid fa-eye"></i></a>
                    @can('media-edit')
                    <a class="btn btn-primary" href="{{ route('medias.edit',$media->id) }}"><i class="fa-regular fa-pen-to-square"></i></a>
                    @endcan


                    @csrf
                    @method('DELETE')
                    @can('media-delete')
                        <button type="submit" class="btn btn-danger delete-confirm"><i class="fa-solid fa-trash"></i></button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>

    <script>
        $('.delete-confirm').on('click', function (event) {
            var form =  $(this).closest("form");
            event.preventDefault();
            swal({
                title: 'Are you sure?',
                text: 'This record and it`s details will be permanantly deleted!',
                icon: 'warning',
                buttons: ["Cancel", "Yes!"],
            }).then(function(value) {
                if (value) {
                    form.submit();
                }
            });
        });
        </script>

@endsection