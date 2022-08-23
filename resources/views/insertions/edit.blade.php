@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Insertion</h2>
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


    <form action="{{ route('insertions.update',$insertion->id) }}" method="POST">
    	@csrf
        @method('PUT')


         <div class="row mt-3">

		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Job ID:</strong>
		            <input type="text" name="job_id" value="{{ $insertion->job_id }}" class="form-control" placeholder="Job ID">
		        </div>
		    </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Company:</strong>
		            <input type="text" name="company" value="{{ $insertion->company }}" class="form-control" placeholder="Company">
		        </div>
		    </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Brand:</strong>
		            <input type="text" name="brand" value="{{ $insertion->brand }}" class="form-control" placeholder="Brand">
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
		            <strong>Media:</strong>
		            <input type="text" name="media" value="{{ $insertion->media }}" class="form-control" placeholder="Media">
		        </div>
		    </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Type:</strong>
		            <input type="text" name="type" value="{{ $insertion->type }}" class="form-control" placeholder="Type">
		        </div>
		    </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Placement:</strong>
		            <input type="text" name="placement" value="{{ $insertion->placement }}" class="form-control" placeholder="Placement">
		        </div>
		    </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Month:</strong>
		            <input type="text" name="month" value="{{ $insertion->month }}" class="form-control" placeholder="Month">
		        </div>
		    </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Issue Nr:</strong>
		            <input type="text" name="issue_nr" value="{{ $insertion->issue_nr }}" class="form-control" placeholder="Issue Nr">
		        </div>
		    </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Number of pages:</strong>
		            <input type="text" name="number_of_pages" value="{{ $insertion->number_of_pages }}" class="form-control" placeholder="Number of pages">
		        </div>
		    </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Quantity:</strong>
		            <input type="text" name="quantity" value="{{ $insertion->quantity }}" class="form-control" placeholder="Quantity">
		        </div>
		    </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Fare:</strong>
		            <input type="text" name="fare" value="{{ $insertion->fare }}" class="form-control" placeholder="Fare">
		        </div>
		    </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Invoiced:</strong>
		            <input type="text" name="invoiced" value="{{ $insertion->invoiced }}" class="form-control" placeholder="Invoiced">
		        </div>
		    </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Year:</strong>
		            <input type="text" name="year" value="{{ $insertion->year }}" class="form-control" placeholder="year">
		        </div>
		    </div>

		    <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
		      <button type="submit" class="btn btn-primary" id='add'>Submit</button>
		    </div>
		</div>

    </form>

    <script>
        // DISPLAY ONLY YEAR IN CALENDAR
        $(document).ready(function(){
            $("#year").datepicker({
                format: "yyyy",
                viewMode: "years", 
                minViewMode: "years",
                autoclose:true 
            });
        })
    </script>

@endsection