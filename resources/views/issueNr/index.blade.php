@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Issue Nr</h2>
            </div>
            <div class="pull-right">
                {{-- @can('insertion-create') --}}
                    <a class="btn btn-success" href="{{ route('issue_nr.create') }}"> Create New Issue</a>
                {{-- @endcan --}}
            </div>
        </div>
    </div>


    <table class="table table-bordered mt-3">
        <tr>
            <th>No</th>
            <th>Media</th>
            <th>Issue Nr</th>
            <th>Deadline</th>
            <th width="105px">Action</th>
        </tr>
	    @foreach ($all_issue as $issue)
	    <tr>
	        <td>{{ $loop->index }}</td>
            <td>{{ $issue->media }}</td>
	        <td>{{ $issue->final_issue }}</td>
            <td>{{ $issue->deadline }}</td>
	        <td>
                <form action="{{ route('issue_nr.destroy',$issue->id) }}" method="POST">

                    @can('issue_nrs-edit')
                        <a class="btn btn-primary" href="{{ route('issue_nr.edit',$issue->id) }}"><i class="fa-regular fa-pen-to-square"></i></a>
                    @endcan

                    @csrf
                    @method('DELETE')
                    @can('issue_nrs-delete')
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