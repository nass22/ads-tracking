@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Issue Nr</h2>
        </div>
        <div class="pull-right">
                <a class="btn btn-success" href="{{ route('issue_nr.create') }}"> Create New Issue</a>
        </div>
    </div>
</div>

@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif

<div class="container card mt-4 ">

    <div class="row">
        <div class="col-6 card-body text-center">
            <h5 class="">Search on:</h5>

            <input type="text" name="search_issue_nr" id="search_issue_nr" placeholder="Issue Nr">
        </div>
    </div>

</div>

<table border="0" style="width: 67%; margin: 0 auto 2em auto;" class="mt-4">
    <div id="buttons"></div>
<table class="table table-bordered data-table stripe compact" id="issueNrTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Media</th>
            <th>Issue Nr</th>
            <th>Deadline</th>
            <th width="100px">Action</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>




<script>

function datatable() {
        var table = $('.data-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            paging: true,
            pageLength: 50,
            dom: 'Bfrtip',
            buttons: [
                'pageLength',
                'excelHtml5',
                'pdfHtml5'
            ],
            "columnDefs":[
                {
                    className:'dt-body-center',
                    targets: "_all"
                }
            ],
            ajax: {
                url: "{{ route('issue_nr.index') }}",
                data: function(d){
                    d.search = $('input[type="search"]').val();
                    d.search_issue_nr = $('#search_issue_nr').val();
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'media', name: 'media'},
                {data: 'final_issue', name: 'final_issue'},
                {data: 'deadline', name: 'deadline'},
                {data: 'action', name: 'action', orderable: true, searchable: true},
            ],
            "fnDrawCallback": function() {
                $('#search_issue_nr').keyup(function(){
                    table.draw();
                });

            },
        });
    };
    
    $(document).ready(function(){
        datatable();
    });

</script>

@endsection