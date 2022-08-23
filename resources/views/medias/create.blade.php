@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Media</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('medias.index') }}"> Back</a>
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

    <div class="alert alert-success" style="display:none"></div>

    <form method="POST">
        @csrf

        <div class="row mt-3">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Media name</label>
                <input type="text" class="form-control" placeholder="Media" name="name" id="name">
            </div>

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Abbreviation</label>
                <input type="text" class="form-control" placeholder="Abbreviation" name="abbreviation" id="abbreviation">
            </div>

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Type (If more than one, separate with a comma!)</label>
                <input type="text" class="form-control" placeholder="Type" name="type" id="type">
            </div>

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Placement (If more than one, separate with a comma!)</label>
                <input type="text" class="form-control" placeholder="Placement" name="placement" id="placement">
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button class="btn btn-primary" id="add">Submit</button>
            </div>
        </div>
    </form>

    <script>
        // STORE 
        $(document).ready(function(){
            $('#add').on('click', function(e){
                e.preventDefault();

                const type = $('#type').val();
                const placement = $('#placement').val();
                
                const typeArray = type.split(",");
                const placementArray = placement.split(",");


                $.ajax({
                    url: "{{ route('medias.store') }}",
                    type: 'post',
                    data: {
                        "_token" : "{{ csrf_token() }}",
                        name : $('#name').val(),
                        abbreviation : $('#abbreviation').val(),
                        type : JSON.stringify(typeArray),
                        placement : JSON.stringify(placementArray)
                    },
                    success: function(result){
                        console.log(result);
                        $('.alert').show();
                        $('.alert').html('<p>'+ result.success + '</p>');
                    }
                });
            });
        });
    </script>


@endsection