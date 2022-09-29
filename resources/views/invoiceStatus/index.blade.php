@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Invoice Status</h2>
        </div>
        <div class="pull-right">
            @can('insertions-create')
                <a class="btn btn-success" href="{{ route('invoice_status.create') }}"> Create New Invoice Status</a>
            @endcan
        </div>
    </div>
</div>

<table class="table table-bordered mt-3">
    <tr>
        <th>No</th>
        <th>Name</th>
        <th width="105px">Action</th>
    </tr>
    @foreach ($status as $one_status)
    <tr>
        <td>{{ $loop->index }}</td>
        <td>{{ $one_status->name }}</td>
        <td>

            <form action="{{ route('invoice_status.destroy',$one_status->id) }}" method="POST">
                
                @can('companies-edit')
                <a class="btn btn-primary" href="{{ route('invoice_status.edit',$one_status->id) }}"><i class="fa-regular fa-pen-to-square"></i></a>
                @endcan


                @csrf
                @method('DELETE')
                @can('invoice_statuses-delete')
                    <button type="submit" class="btn btn-danger delete-confirm"><i class="fa-solid fa-trash"></i></button>
                @endcan
            </form>
        </td>
    </tr>
    @endforeach
</table>


{{-- {!! $status->links() !!} --}}

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