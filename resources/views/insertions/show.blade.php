@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show Insertion</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('insertions.index') }}"> Back</a>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Author:</strong>
                @php
                $username = App\Models\User::where('id', $insertion->user_id)->first();
                @endphp
                {{ $username->name }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Job ID:</strong>
                {{ $insertion->job_id }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Company:</strong>
                {{ $insertion->company }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Brand:</strong>
                {{ $insertion->brand }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Comment:</strong>
                {{ $insertion->comment }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Media:</strong>
                {{ $insertion->media }}
            </div>
        </div>

        @if ($insertion->type != null)
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Type:</strong>
                    {{ $insertion->type }}
                </div>
            </div>
        @endif


        @if ($insertion->placement != null)
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Placement:</strong>
                    {{ $insertion->placement }}
                </div>
            </div>
        @endif
        
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Month:</strong>
                {{ $insertion->month }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Issue Nr:</strong>
                {{ $insertion->issue_nr }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Number of pages:</strong>
                {{ $insertion->number_of_pages }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Quantity:</strong>
                {{ $insertion->quantity }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Fare:</strong>
                {{ $insertion->fare . "€"}}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Invoiced:</strong>
                {{ $insertion->invoiced }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Year:</strong>
                {{ $insertion->year }}
            </div>
        </div>
    </div>
@endsection