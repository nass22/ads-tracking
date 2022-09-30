@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Insertion</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ url()->previous() }}">Back</a>
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

    <form method="POST" action="{{route('insertions.store')}}">
    	@csrf

        @if (Auth::user()->role == 'Admin')
        <div class="container card mt-4">
            <h5 class="pt-2 text-center">Admin Zone</h5>
            <div class="form-check card-body">
                <input class="form-check-input" type="checkbox" value="check" id="checkRCVD" name="checkRCVD">
                <label class="form-check-label" for="checkRCVD">
                    <b>Received?</b> 
                </label>
            </div>

            <div class="card-body">
                <strong>Deadline:</strong>
		            <input type="text" name="deadline" id="deadline" class="form-control">
            </div>
        </div>
        @endif

        <div class="row mt-3">
            <input name="user_id" id="user_id" type="hidden" value="{{Auth::user()->id}}" >
            
            <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
		        <div class="form-group">
		            <strong>Job ID:</strong>
		            <input type="text" name="job_id" id="job_id" class="form-control" placeholder="Job ID">
		        </div>
		    </div>

            <div class="row mb-2">
                <div class="form-group col-xs-8 col-sm-8 col-md-8">
                    <strong id="company">Company:</strong>                    
                        
                </div>
            
                <div class="col-xs-4 col-sm-4 col-md-4 pt-3">
                    <a href="#" id="addCompany"><img src="https://img.icons8.com/avantgarde/50/000000/add.png"/></a>
                </div>
            </div>

            {{-- MODAL --}}
            
            <!-- Modal -->
            <div class="modal fade" id="companyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Company</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            @csrf
                            <div>
                                <strong>Name:</strong>
                                <input type="text" name="nameModal" id="nameModal" class="form-control" placeholder="Name">
                            </div>
                            
                            <div>
                                <strong>Abbreviation:</strong>
                                <input type="text" name="abbreviationModal" id="abbreviationModal" class="form-control" placeholder="Abbreviation">
                            </div>
                            
                            <button type="button" class="btn btn-primary mt-2" id="addModal">Save</button>
                        </form>
                    </div>
                    
                    
                    
                </div>
                </div>
            </div>

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

		    <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
		        <div class="form-group">
		            <strong>Brand:</strong>
		            <input type="search" name="brand" id="brand" class="form-control" placeholder="Brand" list="brand_list">

                    <datalist id="brand_list">

                    </datalist>
		        </div>
		    </div>

            <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
		        <div class="form-group">
		            <strong>Comment:</strong>
		            <input type="text" name="comment" id="comment" class="form-control" placeholder="Comment">
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

            {{-- A VOIR SI ON LE GERE EN BACK OU SI L'USER L'INDIQUE LUI MEME --}}
            <div class="col-xs-12 col-sm-12 col-md-12 mb-2" id="invoice_statusDiv">
		        <div class="form-group">
		            <strong>Invoiced:</strong>
                    @php
                        $all_status = App\Models\InvoiceStatus::all();
                    @endphp

                    @if (isset($all_status[0]))
                    <select class="form-select" aria-label="Invoiced select" id="invoiced" name="invoiced">
                        <option selected disabled>Select Invoice Status</option>
                            @foreach ($all_status as $status)

                                <option value="{{$status->id}}">{{$status->name}}</option>
                            @endforeach
                    </select>   
                        @else
                        <p>No Invoice status Added</p>
                    @endif
		            
		        </div>
		    </div>

		    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
		            <button type="submit" class="btn btn-primary" id="add">Submit</button>
		    </div>
		</div>
    </form>

    






    <script>
    // FUNCTIONS
    
    //SELECT COMPANY
    function getCompany(){
        $.ajax({
            "url": "/ajax/companies/index",
            "type": "GET",
            success: function(data){
                let option = '<select class="form-select" aria-label="Company select" id="selectCompany" name="company"><option selected disabled>Select the company</option>'

                data.forEach(element =>
                    option += "<option value='"+element.id+"'>"+element.name+" ("+element.abbreviation+")</option>"
                );

                $('#company').after(option);

            },
            error: function(error){
                console.log(error);
            }
        });
    }

    //SELECT ISSUE
    function getIssue(){
        let mediaInput = $('#media').val();
        mediaInput = JSON.parse(mediaInput);
        let mediaId = mediaInput.id;
        
        $.ajax({
            type: 'post',
            url: '/ajax/issue/get',
            data: {
                "_token": "{{ csrf_token() }}",
                media:mediaId,
            },
            success: function (response) {
                let issue = '<div class="col-xs-12 col-sm-12 col-md-12 mb-2 issue"><div class="form-group"><strong>Issue Nr:</strong><select class="form-select" aria-label="Default select example" name="issue_nr" id="issue_nr"><option selected disabled>Select issue</option>' ;
                
                response.forEach(element => {
                    issue += "<option value='"+element['id']+"'>"+element['final_issue']+"</option>";
                });

                issue += '</select></div></div>';

                $('#divMedia').after(issue);
            },
            error: function (e){
                console.log(e)
            }
        });
    }


    //WHEN DOCUMENT IS READY
    
    $(document).ready(function(){
        getCompany();
    });

    // DISPLAY TYPE, PLACEMENT INPUTS & ISSUES
    $('#media').change(function(){
        $('.types').remove();
        $('.placements').remove();
        $('.issue').remove();
        
        getIssue();

        let media = $('#media').val();
        media = JSON.parse(media);
        let mediaName = media.name;

        let typeString = media.type;
        let type = typeString.split(",");

        let placementString = media.placement;
        let placement = placementString.split(",");

        if (placement[0] != ""){
            let select = '<div class="col-xs-12 col-sm-12 col-md-12 mb-2 placements"><div class="form-group"><strong>Placement:</strong><select class="form-select" aria-label="Default select example" name="placement" id="placement"><option selected disabled>Select placement</option>'

            placement.forEach(element => {
                select += "<option value='"+element.trim()+"'>"+element.trim()+"</option>";
            });

            select += '</select></div></div>'

            $('#divMedia').after(select);
        }

        if (type[0] != ""){
            
            let select = '<div class="col-xs-12 col-sm-12 col-md-12 mb-2 types"><div class="form-group"><strong>Type:</strong><select class="form-select" aria-label="Default select example" name="type" id="type"><option selected disabled>Select type</option>'

            type.forEach(element => 
                select += "<option value='"+element.trim()+"'>"+element.trim()+"</option>"
            );

            select += '</select></div></div>'

            $('#divMedia').after(select);
        }
    });

    //DISPLAY COMPANY MODAL + STORE
    $('#addCompany').click(function(){
        $('#companyModal').modal('show');
        $('#addModal').on('click', function(e){
            e.preventDefault();
            $.ajax({
                url:"/ajax/companies/store",
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    name: $('#nameModal').val(),
                    abbreviation: $('#abbreviationModal').val(),
                },
                success: function (result){
                    $('#selectCompany').remove();
                    getCompany();
                    $('#companyModal').modal('hide');
                }, 
                error: function(error){
                    console.log(error);
                }
            })
        })
    });
    

    //DISPLAY BRANDS ON KEYUP
    $('#brand').keyup(function(){
        $('.option').remove();
        let value= $('#brand').val();

        $.ajax({
                url:"/ajax/brand/get",
                type: "get",
                data: {
                    'brand': value,
                },
                success: function (results){
                    let option;
                    results.forEach(element => {
                        
                        option += "<option value='"+element.name+"' class='option'>";
                        
                    });
                    
                    $('#brand_list').append(option);
                }, 
                error: function(error){
                    console.log(error);
                }
            })
    })

    </script>
@endsection