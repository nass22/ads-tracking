@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Insertion</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('insertions.index') }}"> Back</a>
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
            <input name="user_id" id="user_id" type="hidden" value="{{Auth::user()->id}}" >
            
            <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
		        <div class="form-group">
		            <strong>Job ID:</strong>
		            <input type="text" name="job_id" id="job_id" class="form-control" placeholder="Job ID">
		        </div>
		    </div>

            <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
		        <div class="form-group">
		            <strong>Company:</strong>
                    @php
                        $companies = App\Models\Company::all();
                    @endphp
                    @if (isset($companies[0]))
                        <select class="form-select" aria-label="Company select" id="company">
                            <option selected>Select the company</option>
                            
                                @foreach ($companies as $company)
                                    <option value="{{$company}}">{{$company->abbreviation}}</option>
                                @endforeach
                        </select>
                    @else
                        <p>Add a new company pls!</p>
                    @endif
                        
                        
                      
		        </div>
		    </div>

		    <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
		        <div class="form-group">
		            <strong>Brand:</strong>
		            <input type="text" name="brand" id="brand" class="form-control" placeholder="Brand" >
		        </div>
		    </div>

            <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
		        <div class="form-group">
		            <strong>Comment:</strong>
		            <input type="text" name="comment" id="comment" class="form-control" placeholder="Comment">
		        </div>
		    </div>

            <div class="col-xs-12 col-sm-12 col-md-12 mb-2" id="divMedia">
		        <div class="form-group">
		            <strong>Media:</strong>
                    @php
                        $all_media = App\Models\Media::all();
                    @endphp
                    @if (isset($all_media[0]))
                    <select class="form-select" aria-label="Media select" id="media">
                        <option selected>Select media</option>
                            @foreach ($all_media as $media)
                                <option value="{{$media}}">{{$media->abbreviation}}</option>
                            @endforeach
                    </select>   
                        @else
                        <p>No media Add</p>
                    @endif
		            
		        </div>
		    </div>            

            <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
		        <div class="form-group">
		            <strong>Month:</strong>
		            <input type="text" name="month" id="month" class="form-control" placeholder="Month">
		        </div>
		    </div>

            <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
		        <div class="form-group">
		            <strong>Issue Nr:</strong>
		            <input type="text" name="issue_nr" id="issue_nr" class="form-control" placeholder="Issue Nr">
		        </div>
		    </div>

            <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
		        <div class="form-group">
		            <strong>Number of pages:</strong>
		            <input type="number" name="number_of_pages" id="number_of_pages" class="form-control" placeholder="Number of pages">
		        </div>
		    </div>

            <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
		        <div class="form-group">
		            <strong>Quantity:</strong>
		            <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Quantity">
		        </div>
		    </div>

		    <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
		        <div class="form-group">
		            <strong>Fare:</strong>
		            <input type="text" name="fare" id="fare" class="form-control" placeholder="Fare">
		        </div>
		    </div>

            <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
		        <div class="form-group">
		            <strong>Invoiced:</strong>
		            <input type="text" name="invoiced" id="invoiced" class="form-control" placeholder="Invoiced">
		        </div>
		    </div>

            <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
		        <div class="form-group">
		            <strong>Year:</strong>
		            <input type="text" name="year" id="year" class="form-control" placeholder="Year">
		        </div>
		    </div>

		    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
		            <button type="submit" class="btn btn-primary" id="add">Submit</button>
		    </div>
		</div>
    </form>

    <script>
        // DISPLAY ONLY MONTH IN CALENDAR
        $(document).ready(function(){
            $("#month").datepicker({
                format: "mm",
                viewMode: "months", 
                minViewMode: "months",
                autoclose:true 
            });
            
        })

        // DISPLAY ONLY YEAR IN CALENDAR
        $(document).ready(function(){
            $("#year").datepicker({
                format: "yyyy",
                viewMode: "years", 
                minViewMode: "years",
                autoclose:true 
            });
            
        })
            
        // DISPLAY TYPE & PLACEMENT
        $('#media').change(function(){
            $('.types').remove();
            $('.placements').remove();

            let media = $('#media').val();
            media = JSON.parse(media);

            let type = JSON.parse(media.type);
            let placement = JSON.parse(media.placement);

            if (placement[0] != ""){
                let select = '<div class="col-xs-12 col-sm-12 col-md-12 mb-2 placements"><div class="form-group"><strong>Placement:</strong><select class="form-select" aria-label="Default select example" name="placement" id="placement"><option selected>Select type</option>'

                placement.forEach(element => {
                    select += "<option value='"+element.trim()+"'>"+element.trim()+"</option>";
                });

                select += '</select></div></div>'

                $('#divMedia').after(select);
            }

            if (type[0] != ""){
                
                let select = '<div class="col-xs-12 col-sm-12 col-md-12 mb-2 types"><div class="form-group"><strong>Type:</strong><select class="form-select" aria-label="Default select example" name="type" id="type"><option selected>Select type</option>'

                type.forEach(element => {
                    select += "<option value='"+element.trim()+"'>"+element.trim()+"</option>";
                });

                select += '</select></div></div>'

                $('#divMedia').after(select);
            }
        })

        // STORE 
        $(document).ready(function(){
            $('#add').on('click', function(e){
                let media = JSON.parse($('#media').val());
                let mediaName = media.name;
                
                let company = JSON.parse($('#company').val());
                let companyName = company.name;

                e.preventDefault();
                $.ajax({
                    url: "/insertions",
                    type: 'post',
                    data: {
                        "_token" : "{{ csrf_token() }}",
                        user_id : $('#user_id').val(),
                        job_id : $('#job_id').val(),
                        company : companyName,
                        brand : $('#brand').val(),
                        comment : $('#comment').val(),
                        media : mediaName,
                        type : $('#type').val(),
                        placement : $('#placement').val(),
                        month : $('#month').val(),
                        issue_nr : $('#issue_nr').val(),
                        number_of_pages: $('#number_of_pages').val(),
                        quantity : $('#quantity').val(),
                        fare : $('#fare').val(),
                        invoiced : $('#invoiced').val(),
                        year : $('#year').val(),
                    },
                    success: function(result){
                        console.log(result);
                    }
                });
            });
        });
    </script>

@endsection