@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Companies</h2>
        </div>
        <div class="pull-right">
            @can('companies-create')
            <a class="btn btn-success" href="{{ route('companies.create') }}">Create New company</a>
            @endcan
        </div>
    </div>
</div>


<table class="table table-bordered mt-3">
    <tr>
        <th>No</th>
        <th>Name</th>
        <th>Abbreviation</th>
        <th width="105px">Action</th>
    </tr>
    @foreach ($companies as $company)
    <tr>
        <td>{{ $loop->index+1 }}</td>
        <td>{{ $company->name }}</td>
        <td>{{ $company->abbreviation }}</td>
        <td>

            <form action="{{ route('companies.destroy',$company->id) }}" method="POST">
                
                @can('companies-edit')
                <a class="btn btn-primary" href="{{ route('companies.edit',$company->id) }}"><i class="fa-regular fa-pen-to-square"></i></a>
                @endcan


                @csrf
                @method('DELETE')
                @can('companies-delete')
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
        new swal({
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