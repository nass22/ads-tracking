@extends('layouts.app')


@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Insertions</h2>
            </div>
            <div class="pull-right">
                @can('insertions-create')
                    <a class="btn btn-success" href="{{ route('insertions.create') }}"> Create New insertion</a>
                @endcan
            </div>
        </div>
    </div>

    <table class="table table-bordered mt-3">
        <tr>
            <th>No</th>
            <th>Job ID</th>
            <th>Company</th>
            <th>Issue Nr</th>
            <th>Fare</th>
            <th>Invoiced</th>
            <th>Year</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($insertions as $insertion)
        
	    <tr>
	        <td>{{ $loop->index }}</td>
            <td>{{ $insertion->job_id }}</td>
	        <td>{{ $insertion->company }}</td>
            <td>{{ $insertion->issue_nr }}</td>
            <td>{{ $insertion->fare . "€"}}</td>
            <td>{{ $insertion->invoiced }}</td>
	        <td>{{ $insertion->year }}</td>
	        <td>
                
                <form action="{{ route('insertions.destroy',$insertion->id) }}" method="POST">
                    
                    <a class="btn btn-info" href="{{ route('insertions.show',$insertion->id) }}">Show</a>

                    @can('insertions-edit')
                        <a class="btn btn-primary" href="{{ route('insertions.edit',$insertion->id) }}">Edit</a>
                    @endcan

                    @csrf
                    @method('DELETE')

                    {{-- @can('insertions-delete') --}}
                    
                    @if ($insertion->user_id == Auth::user()->id || Auth::user()->role == "Admin")
                        <button type="submit" class="btn btn-danger delete-confirm">Delete</button>
                    @endif
                        
                    {{-- @endcan --}}
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