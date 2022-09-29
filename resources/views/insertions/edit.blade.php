@extends('layouts.app')


@section('content')
@if ($insertion->user_id == Auth::user()->id || Str::lower(Auth::user()->role) == "admin")
	<div class="row">
		<div class="col-lg-12 margin-tb">
			<div class="pull-left">
				<h2>Edit Insertion</h2>
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


	<form action="{{ route('insertions.update',$insertion->id) }}" method="POST">
		@csrf
		@method('PUT')
		@if (Auth::user()->role == 'Admin')
			<div class="mt-3 form-check">
				<input class="form-check-input" type="checkbox" value="check" id="checkRCVD" name="checkRCVD">
				<label class="form-check-label" for="checkRCVD">
				<b>Received?</b> 
				</label>
			</div>
        @endif

		<div class="row mt-3">
			<input name="user_id" id="user_id" type="hidden" value="{{Auth::user()->id}}" >
			
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group">
					<strong>Job ID:</strong>
					<input type="text" name="job_id" value="{{ $insertion->job_id }}" class="form-control" placeholder="Job ID">
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 mb-2">
				<div class="form-group">
					<strong>Company:</strong>
					@php
						$companies = App\Models\Company::orderBy('name', 'asc')->get();
					@endphp

					@if (isset($companies[0]))
						<select class="form-select" aria-label="Company select" name="company">
							<option selected disabled>Select Company</option>
								@foreach ($companies as $company)

									<option value="{{$company->id}}" {{$insertion->company == $company->id ? 'selected' : ''}}>{{$company->name}}</option>
								@endforeach
						</select>   
					@else
						<p>No Company Name Added</p>
					@endif
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 mb-2" id="mediaDiv">
				<div class="form-group">
					<strong>Media:</strong>
					@php
						$all_media = App\Models\Media::orderBy('name', 'asc')->get();
					@endphp

					@if (isset($all_media[0]))
						<select class="form-select" aria-label="Media select" name="media" id="media">
							<option selected disabled>Select Media</option>
								@foreach ($all_media as $media)

									<option value="{{$media}}" {{$insertion->media == $media->id ? 'selected' : ''}}>{{$media->name}} ({{$media->abbreviation}})</option>
								@endforeach
						</select>   
					@else
						<p>No Media Added</p>
					@endif
				</div>
			</div>

			@if (isset($insertion->type))

			<div class="col-xs-12 col-sm-12 col-md-12 mb-2" id="typeDiv">
				<div class="form-group">
					<strong>Type:</strong>
					@php
						$media = App\Models\Media::where('id', $insertion->media)->first();
						$all_type = $media->type;
						$all_type = explode(",", $all_type);
					@endphp

					@if (isset($all_type[0]))
						<select class="form-select" aria-label="Type select" name="type" >
							<option selected disabled>Select Type</option>
								@foreach ($all_type as $type)

									<option value="{{$type}}" {{$insertion->type == $type ? 'selected' : ''}}>{{$type}}</option>
								@endforeach
						</select>   
					@else
						<p>No Type Added</p>
					@endif
				</div>
			</div>
				
			@endif

			@if (isset($insertion->placement))

			<div class="col-xs-12 col-sm-12 col-md-12 mb-2" id="placementDiv">
				<div class="form-group">
					<strong>Placement:</strong>
					@php
						$media = App\Models\Media::where('id', $insertion->media)->first();
						$all_placement = $media->placement;
						$all_placement = explode(",", $all_placement);
					@endphp

					@if (isset($all_placement[0]))
						<select class="form-select" aria-label="Placement select" name="placement" >
							<option selected disabled>Select Placement</option>
								@foreach ($all_placement as $placement)

									<option value="{{$placement}}" {{$insertion->placement == $placement ? 'selected' : ''}}>{{$placement}}</option>
								@endforeach
						</select>   
					@else
						<p>No Placement Added</p>
					@endif
				</div>
			</div>
				
			@endif

			<div class="col-xs-12 col-sm-12 col-md-12" id="issueDiv">
				<div class="form-group">
					<strong>Issue Nr:</strong>
					@php
						$all_issue = App\Models\IssueNrs::where('id', $insertion->media)->get();
					@endphp
					<select class="form-select" aria-label="Issue select" name="issue_nr" >
						<option selected disabled>Select Issue</option>
							@foreach ($all_issue as $issue)
								<option value="{{$issue->id}}" {{$insertion->issue_nr == $issue->id ? 'selected' : ''}}>{{$issue->final_issue}}</option>
							@endforeach
					</select>
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group">
					<strong>Brand:</strong>
					<input type="search" name="brand" id="brand" class="form-control" placeholder="Brand" list="brand_list" value="{{$insertion->brand}}">

                    <datalist id="brand_list">

                    </datalist>
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group">
					<strong>Comment:</strong>
					<input type="text" name="comment" value="{{ $insertion->comment }}" class="form-control" placeholder="Comment">
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group">
					<strong>Quantity:</strong>
					<input type="number" name="quantity" value="{{ $insertion->quantity }}" class="form-control" placeholder="Quantity">
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group">
					<strong>Fare:</strong>
					<input type="text" name="fare" value="{{ $insertion->fare }}" class="form-control" placeholder="Fare">
				</div>
			</div>

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

									<option value="{{$status->id}}" {{$insertion->invoiced == $status->id ? 'selected' : ''}}>{{$status->name}}</option>
								@endforeach
						</select>   
					@else
						<p>No Invoice status Added</p>
					@endif
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group">
					<strong>Year:</strong>
					<input type="text" id="year" name="year" value="{{ $insertion->year }}" class="form-control" placeholder="year">
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
			<button type="submit" class="btn btn-primary" id='add'>Submit</button>
			</div>
		</div>

	</form>
@else 
	<div class="alert alert-danger">
		<strong>Whoops!</strong> Nice try...<br><br>
		<ul>
			
				<li>Your are not admin!</li>
			
		</ul>
	</div>
@endif
    
    <script>
		function getIssue(){
			$('#issueDiv').remove();

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
					let issue = '<div class="col-xs-12 col-sm-12 col-md-12 mb-2 issue" id="issueDiv"><div class="form-group"><strong>Issue Nr:</strong><select class="form-select" aria-label="Default select example" name="issue_nr" id="issue_nr"><option selected disabled>Select issue</option>' ;
					
					response.forEach(element => {
						issue += "<option value='"+element['id']+"'>"+element['final_issue']+"</option>";
					});

					issue += '</select></div></div>';

					$('#mediaDiv').after(issue);
				},
				error: function (e){
					console.log(e)
				}
			});
    }

        $(document).ready(function(){
			// DISPLAY ONLY MONTH IN INPUT MONTH
			$("#month").datepicker({
            format: "mm",
            viewMode: "months", 
            minViewMode: "months",
            multidate: true
        	});

			// DISPLAY ONLY YEAR IN CALENDAR
            $("#year").datepicker({
                format: "yyyy",
                viewMode: "years", 
                minViewMode: "years",
                ultidate: true
            });

			// ADD INPUT_NR 
			if($('#invoiced').val() == 2){
				let invoice_nr = '<div class="col-xs-12 col-sm-12 col-md-12 mb-2" id="invoice_nrDiv"><div class="form-group"><strong>Invoice Nr:</strong><input type="text" name="invoice_nr" value="{{ $insertion->invoice_nr }}"class="form-control" placeholder="Invoice Nr"></div></div>'

				$('#invoice_statusDiv').after(invoice_nr);
			}

			// DISPLAY TYPE & PLACEMENT ON MEDIA CHANGE
			$('#media').change(function(){
				let mediaArray = $('#media').val();
				mediaArray = JSON.parse(mediaArray);
				
				let typeString = mediaArray.type;
				let typeArray = typeString.split(",");

				let placementString = mediaArray.placement;
				let placementArray = placementString.split(",");

				$('#typeDiv').remove();
				$('#placementDiv').remove();
				

				getIssue();

				if(placementArray != ""){
					let html = "<div class='col-xs-12 col-sm-12 col-md-12 mb-2' id='placementDiv'><div class='form-group'><strong>Placement:</strong><select class='form-select' aria-label='Placement select' name='placement'><option selected>Select Placement</option>"

						placementArray.forEach(element => {
							html += "<option value='"+element+"'}>"+element+"</option>"
						});

					html += "</select>";

					$('#mediaDiv').after(html);
				}

				if(mediaArray.type != ""){
					let html = "<div class='col-xs-12 col-sm-12 col-md-12 mb-2' id='typeDiv'><div class='form-group'><strong>Type:</strong><select class='form-select' aria-label='Type select' name='type'><option selected>Select Type</option>";

						typeArray.forEach(element => {
							html += "<option value='"+element+"'}>"+element+"</option>"
						});

					html += "</select>";

					$('#mediaDiv').after(html);
				}
			});
        })

		// DISPLAY INVOICE_NR IF INVOICED = YES
		$('#invoiced').change(function(){
			$('#invoice_nrDiv').remove();

			if($('#invoiced').val() == 2){
				let invoice_nr = '<div class="col-xs-12 col-sm-12 col-md-12 mb-2" id="invoice_nrDiv"><div class="form-group"><strong>Invoice Nr:</strong><input type="text" name="invoice_nr" value="{{ $insertion->invoice_nr }}"class="form-control" placeholder="Invoice Nr"></div></div>'

				$('#invoice_statusDiv').after(invoice_nr);
			}			
		})

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