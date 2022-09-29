@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Media</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('medias.index') }}">Back</a>
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

    <form method="POST" action="{{route('medias.store')}}">
        @csrf

        <div class="row mt-3">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label"><b>Media name</b></label>
                <input type="text" class="form-control" placeholder="Ex: Tempo Medical" name="name" id="name">
            </div>

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label"><b>Abbreviation</b></label>
                <input type="text" class="form-control" placeholder="Ex: TM" name="abbreviation" id="abbreviation">
            </div>

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label"><b>Type</b> (If more than one, separate with a comma!)</label>
                <input type="text" class="form-control" placeholder="Ex: AD 1/1, AD 1/2, ..." name="type" id="type">
            </div>

            <div class="mb-3" id="placementDiv">
                <label for="exampleFormControlInput1" class="form-label"><b>Placement</b> (If more than one, separate with a comma!)</label>
                <input type="text" class="form-control" placeholder="Ex: OverCover, UnderCover, ..." name="placement" id="placement">
            </div>

            <div class="mb-3 pt-3" id="placementDiv">
                <p>(Only for Tempo Focus & Tempo Congress)</p>
                <button class="btn btn-primary" id="numeroBtn" type="button"><i class="fa-solid fa-plus"></i> Add Numero</button> 
            </div>



            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button class="btn btn-primary" id="add" type="submit">Submit</button>
            </div>
        </div>
    </form>

    <script>
        // ADD NUMERO INPUT
        // $('#name').keyup(function(){
        //     $('#numeroDiv').remove()
            
        //     let input = $('#name').val().toLowerCase()
        //     input = input.trim()
            
        //     if (input == "tempo focus" || input == "tempo congress"){
                
        //         let numero = '<div class="mb-3" id="numeroDiv"><label for="exampleFormControlInput1" class="form-label pt-2" ><b>Numero</b> (If more than one, separate with a comma!)</label><input type="text" class="form-control" placeholder="Ex: NeuroPsy, Cardio, ..." name="numero" id="numero"></div>'

        //         $('#placementDiv').after(numero);
        //     }
        // })

        $('#numeroBtn').click(function (){
            $('#numeroDiv').remove()
            
            let numero = '<div class="mb-3" id="numeroDiv"><label for="exampleFormControlInput1" class="form-label" ><b>Numero</b> (If more than one, separate with a comma!)</label><input type="text" class="form-control" placeholder="Ex: NeuroPsy, Cardio, ..." name="numero" id="numero"></div>'

            $('#placementDiv').after(numero);
        })

        // STORE 
        // $(document).ready(function(){
        //     $('#add').on('click', function(e){
        //         e.preventDefault();

        //         const type = $('#type').val();
        //         const placement = $('#placement').val();
                
        //         const typeArray = type.split(",");
        //         const placementArray = placement.split(",");


        //         $.ajax({
        //             url: "{{ route('medias.store') }}",
        //             type: 'post',
        //             data: {
        //                 "_token" : "{{ csrf_token() }}",
        //                 name : $('#name').val(),
        //                 abbreviation : $('#abbreviation').val(),
        //                 type : JSON.stringify(typeArray),
        //                 placement : JSON.stringify(placementArray)
        //             },
        //             success: function(result){
        //                 console.log(result);
        //                 $('.alert').show();
        //                 $('.alert').html('<p>'+ result.success + '</p>');
        //             }
        //         });
        //     });
        // });
    </script>


@endsection