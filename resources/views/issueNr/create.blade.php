@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Issue</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('issue_nr.index') }}">Back</a>
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

    <form method="POST" action="{{route('issue_nr.store')}}">
    	@csrf

         <div class="row mt-3">
            <input name="user_id" id="user_id" type="hidden" value="{{Auth::user()->id}}" >
            
            <div class="col-xs-12 col-sm-12 col-md-12 mb-2" id="divMedia">
		        <div class="form-group">
		            <strong>Media:</strong>
                    @php
                        $all_media = App\Models\Media::orderBy('name', 'asc')->get();
                    @endphp
                    @if (isset($all_media[0]))
                    <select class="form-select" aria-label="Media select" id="media" name="media">
                        <option selected disabled>Select media</option>
                            @foreach ($all_media as $media)
                                <option value="{{$media}}">{{$media->name}}</option>
                            @endforeach
                    </select>   
                        @else
                        <p>No Media added</p>
                    @endif
		            
		        </div>
		    </div>


            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary" id="add">Submit</button>
            </div>

        </div>
    </form>

    <table border="0" style="width: 67%; margin: 0 auto 2em auto;" class="mt-4">
        <div id="buttons"></div>
    <table class="table table-bordered data-table stripe compact" id="issueTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Media</th>
                <th>Issue Nr</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>






    <script>
        function issueTable(media){
            
            var table = $('#issueTable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                paging: true,
                pageLength: 20,
                "columnDefs":[
                    {
                        className:'dt-body-center',
                        targets: "_all"
                    }
                ],
                ajax: {
                    url: "{{ route('ajax.issueExist.get') }}",
                    data: function(d){
                        d.search = $('input[type="search"]').val();
                        d.media = media;
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'media', name: 'media'},
                    {data: 'final_issue', name: 'final_issue'},
                ],
                "fnDrawCallback": function() {
                    $('#media').change(function () {
                        table.draw();
                    });
                },
            });
        }

        $('#media').change(function(){
            $('#issueTable').dataTable().fnDestroy();

            $('#numeroDiv').remove();
            $('#yearDiv').remove();
            $('#monthDiv').remove();
            $('#weekDiv').remove();
            $('#deadlineDiv').remove();

            let media = $('#media').val();
            media = JSON.parse(media);
            
            issueTable(media.name);

            if (media.name == "Tempo Medical" || media.name == "BJP"){
                let numeroInput = '<div class="col-xs-12 col-sm-12 col-md-12 mb-2" id="numeroDiv"><div class="form-group"><strong>Numero:</strong><input type="text" name="numero" id="numero" class="form-control" placeholder="Numero"></div></div>'

                let yearInput = '<div class="col-xs-12 col-sm-12 col-md-12 mb-2" id="yearDiv"><div class="form-group"><strong>Year:</strong><input type="text" name="year" id="year" class="form-control" placeholder="Year"></div></div>';

                let monthInput = '<div class="col-xs-12 col-sm-12 col-md-12 mb-2" id="monthDiv"><div class="form-group"><strong>Month:</strong><input type="text" name="month" id="month" class="form-control" placeholder="Month"></div></div>';

                let deadlineInput = '<div class="col-xs-12 col-sm-12 col-md-12 mb-2" id="deadlineDiv"><div class="form-group"><strong>Deadline:</strong><input type="text" name="deadline" id="deadline" class="form-control" placeholder="Deadline"></div></div>';

                $('#divMedia').after(numeroInput);
                $('#numeroDiv').after(yearInput);
                $('#yearDiv').after(monthInput);
                $('#monthDiv').after(deadlineInput);

                // DISPLAY ONLY MONTH IN INPUT MONTH
                $("#month").datepicker({
                    format: "mm",
                    viewMode: "months", 
                    minViewMode: "months",
                    multidate: true,
                    multidateSeparator: "/",
                });

                // DISPLAY ONLY YEAR IN INPUT YEAR
                $("#year").datepicker({
                    format: "yyyy",
                    viewMode: "years", 
                    minViewMode: "years",
                    autoclose:true 
                });

                //DISPLAY CALENDAR FOR DEADLINE
                $("#deadline").datepicker({
                    format: "dd/mm/yyyy",
                    multidateSeparator: "/",
                    weekStart: 1,
                });

            } else if (media.name == "Tempo Focus"){
                let numero = media.numero;
                numero = numero.split(",");
                numero = numero.sort();

                let numeroInput = '<div class="col-xs-12 col-sm-12 col-md-12 mb-2" id="numeroDiv"><div class="form-group"><strong>Numero:</strong><select class="form-select" aria-label="Default select example" name="numero" id="numero"><option selected disabled>Select numero</option>';

                numero.forEach(element => {
                    numeroInput += "<option value='"+element.trim()+"'>"+element.trim()+"</option>";
                });

                numeroInput += '</select></div></div>'

                let yearInput = '<div class="col-xs-12 col-sm-12 col-md-12 mb-2" id="yearDiv"><div class="form-group"><strong>Year:</strong><input type="text" name="year" id="year" class="form-control" placeholder="Year"></div></div>';

                let monthInput = '<div class="col-xs-12 col-sm-12 col-md-12 mb-2" id="monthDiv"><div class="form-group"><strong>Month:</strong><input type="text" name="month" id="month" class="form-control" placeholder="Month"></div></div>';

                let deadlineInput = '<div class="col-xs-12 col-sm-12 col-md-12 mb-2" id="deadlineDiv"><div class="form-group"><strong>Deadline:</strong><input type="text" name="deadline" id="deadline" class="form-control" placeholder="Deadline"></div></div>';

                $('#divMedia').after(numeroInput);
                $('#numeroDiv').after(yearInput);
                $('#yearDiv').after(monthInput);
                $('#monthDiv').after(deadlineInput);

                // DISPLAY ONLY MONTH IN INPUT MONTH
                $("#month").datepicker({
                    format: "mm",
                    viewMode: "months", 
                    minViewMode: "months",
                    multidate: true,
                    multidateSeparator: "/",
                });

                // DISPLAY ONLY YEAR IN INPUT YEAR
                $("#year").datepicker({
                    format: "yyyy",
                    viewMode: "years", 
                    minViewMode: "years",
                    autoclose:true 
                });

                //DISPLAY CALENDAR FOR DEADLINE
                $("#deadline").datepicker({
                    format: "dd/mm/yyyy",
                    multidateSeparator: "/",
                    weekStart: 1,
                });
            } else if (media.name == "Tempo Congress"){
                let numero = media.numero;
                numero = numero.split(",");

                let numeroInput = '<div class="col-xs-12 col-sm-12 col-md-12 mb-2" id="numeroDiv"><div class="form-group"><strong>Numero:</strong><select class="form-select" aria-label="Default select example" name="numero" id="numero"><option selected disabled>Select numero</option>';

                numero.forEach(element => {
                    numeroInput += "<option value='"+element.trim()+"'>"+element.trim()+"</option>";
                });

                numeroInput += '</select></div></div>'

                let yearInput = '<div class="col-xs-12 col-sm-12 col-md-12 mb-2" id="yearDiv"><div class="form-group"><strong>Year:</strong><input type="text" name="year" id="year" class="form-control" placeholder="Year"></div></div>';

                let monthInput = '<div class="col-xs-12 col-sm-12 col-md-12 mb-2" id="monthDiv"><div class="form-group"><strong>Month:</strong><input type="text" name="month" id="month" class="form-control" placeholder="Month"></div></div>';

                let deadlineInput = '<div class="col-xs-12 col-sm-12 col-md-12 mb-2" id="deadlineDiv"><div class="form-group"><strong>Deadline:</strong><input type="text" name="deadline" id="deadline" class="form-control" placeholder="Deadline"></div></div>';

                $('#divMedia').after(numeroInput);
                $('#numeroDiv').after(yearInput);
                $('#yearDiv').after(monthInput);
                $('#monthDiv').after(deadlineInput);

                // DISPLAY ONLY MONTH IN INPUT MONTH
                $("#month").datepicker({
                    format: "mm",
                    viewMode: "months", 
                    minViewMode: "months",
                    multidate: true,
                    multidateSeparator: "/",
                });

                // DISPLAY ONLY YEAR IN INPUT YEAR
                $("#year").datepicker({
                    format: "yyyy",
                    viewMode: "years", 
                    minViewMode: "years",
                    autoclose:true 
                });

                //DISPLAY CALENDAR FOR DEADLINE
                $("#deadline").datepicker({
                    format: "dd/mm/yyyy",
                    multidateSeparator: "/",
                    weekStart: 1,
                });
            } else if (media.name == "Tempo Today" || media.name == "Tempo Week-end" || media.name == "eMail"){

                let weekInput = '<div class="col-xs-12 col-sm-12 col-md-12 mb-2" id="weekDiv"><div class="form-group"><strong>Week:</strong><input type="text" name="week" id="week" class="form-control" placeholder="Week"></div></div>';

                let deadlineInput = '<div class="col-xs-12 col-sm-12 col-md-12 mb-2" id="deadlineDiv"><div class="form-group"><strong>Deadline:</strong><input type="text" name="deadline" id="deadline" class="form-control" placeholder="Deadline"></div></div>';

                $('#divMedia').after(weekInput);
                $('#weekDiv').after(deadlineInput);
                
                // DISPLAY ONLY MONTH IN INPUT MONTH
                $("#month").datepicker({
                    format: "mm",
                    viewMode: "months", 
                    minViewMode: "months",
                    multidate: true,
                    multidateSeparator: "/",
                });

                // DISPLAY ONLY YEAR IN INPUT YEAR
                $("#year").datepicker({
                    format: "yyyy",
                    viewMode: "years", 
                    minViewMode: "years",
                    autoclose:true 
                });

                // DISPLAY WEEK
                $("#week").datepicker({
                    calendarWeeks: true,
                    weekStart: 1,
                    autoclose:true,
                    daysOfWeekDisabled: "0,2,3,4,5,6",
                });

                //DISPLAY CALENDAR FOR DEADLINE
                $("#deadline").datepicker({
                    format: "dd/mm/yyyy",
                    multidateSeparator: "/",
                    weekStart: 1,
                });
            } else {
                let yearInput = '<div class="col-xs-12 col-sm-12 col-md-12 mb-2" id="yearDiv"><div class="form-group"><strong>Year:</strong><input type="text" name="year" id="year" class="form-control" placeholder="Year"></div></div>';

                let monthInput = '<div class="col-xs-12 col-sm-12 col-md-12 mb-2" id="monthDiv"><div class="form-group"><strong>Month:</strong><input type="text" name="month" id="month" class="form-control" placeholder="Month"></div></div>';

                let deadlineInput = '<div class="col-xs-12 col-sm-12 col-md-12 mb-2" id="deadlineDiv"><div class="form-group"><strong>Deadline:</strong><input type="text" name="deadline" id="deadline" class="form-control" placeholder="Deadline"></div></div>';

                $('#divMedia').after(yearInput);
                $('#yearDiv').after(monthInput);
                $('#monthDiv').after(deadlineInput);

                // DISPLAY ONLY MONTH IN INPUT MONTH
                $("#month").datepicker({
                    format: "mm",
                    viewMode: "months", 
                    minViewMode: "months",
                    multidate: true,
                    multidateSeparator: "/",
                });

                // DISPLAY ONLY YEAR IN INPUT YEAR
                $("#year").datepicker({
                    format: "yyyy",
                    viewMode: "years", 
                    minViewMode: "years",
                    autoclose:true 
                });

                //DISPLAY CALENDAR FOR DEADLINE
                $("#deadline").datepicker({
                    format: "dd/mm/yyyy",
                    multidateSeparator: "/",
                    weekStart: 1,
                });
            }
        });

        $(document).ready(function(){
        issueTable("all");
    });

    </script>

@endsection