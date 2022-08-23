@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Invoice Status</h2>
        </div>
        <div class="pull-right">
            @can('insertion-create')
            <a class="btn btn-success" href="{{ route('invoice_status.create') }}"> Create New Invoice Status</a>
            @endcan
        </div>
    </div>
</div>


@if ($message = Session::get('success'))
    <div class="alert alert-success mt-2">
        <p>{{ $message }}</p>
    </div>
@endif


<table class="table table-bordered mt-3">
    <tr>
        <th>No</th>
        <th>Name</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($status as $one_status)
    <tr>
        <td>{{ $loop->index }}</td>
        <td>{{ $one_status->name }}</td>
        <td>

            <form action="{{ route('invoice_status.destroy',$one_status->id) }}" method="POST">
                
                @can('company-edit')
                <a class="btn btn-primary" href="{{ route('invoice_status.edit',$one_status->id) }}">Edit</a>
                @endcan


                @csrf
                @method('DELETE')
                @can('invoice_status-delete')
                <button type="submit" class="btn btn-danger">Delete</button>
                @endcan
            </form>
        </td>
    </tr>
    @endforeach
</table>


{!! $status->links() !!}
@endsection