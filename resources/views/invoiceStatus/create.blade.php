@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New Invoice Status</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('invoice_status.index') }}">Back</a>
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


<form method="POST">
    @csrf


     <div class="row mt-3">
        
        <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" id="name" class="form-control" placeholder="Invoice Status">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary" id="add">Submit</button>
        </div>
     </div>
</form>

<script>
          // STORE 
          $(document).ready(function(){
            $('#add').on('click', function(e){
                e.preventDefault();
                $.ajax({
                    url: "/invoice_status",
                    type: 'post',
                    data: {
                        "_token" : "{{ csrf_token() }}",
                        name : $('#name').val(),
                    },
                    success: function(result){
                        console.log(result);
                    },
                    error: function(result){
                        console.log(result);
                    }
                });
            });
        });
</script>
@endsection