@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Companies</h2>
        </div>
        <div class="pull-right">
            @can('insertion-create')
            <a class="btn btn-success" href="{{ route('companies.create') }}"> Create New company</a>
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
        <th>Abbreviation</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($companies as $company)
    <tr>
        <td>{{ $loop->index }}</td>
        <td>{{ $company->name }}</td>
        <td>{{ $company->abbreviation }}</td>
        <td>

            <form action="{{ route('companies.destroy',$company->id) }}" method="POST">
                
                @can('company-edit')
                <a class="btn btn-primary" href="{{ route('companies.edit',$company->id) }}">Edit</a>
                @endcan


                @csrf
                @method('DELETE')
                @can('company-delete')
                <button type="submit" class="btn btn-danger">Delete</button>
                @endcan
            </form>
        </td>
    </tr>
    @endforeach
</table>


{!! $companies->links() !!}
@endsection