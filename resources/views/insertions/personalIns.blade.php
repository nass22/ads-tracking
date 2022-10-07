@extends('layouts.app')

@section('content')

<div class="container text-center mt-4 pb-4">
    <a href="{{ route('insertions.create') }}" class="btn btn-warning"><i class="fa-solid fa-circle-plus"></i> <strong>Add New Insertion</strong></a>
</div>

<div class="container card mt-4">
    <div class="row">
        <div class="col-6 card-body">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="checkInput" id="checkInput" value="">
                <label class="form-check-label" for="flexCheckDefault">
                    Show closed insertions
                </label>
            </div>
        </div>
        <div class="col-6 card-body">
            <h5 class="">Search on:</h5>
            <ul class="list-group list-group-horizontal">
                <li class="list-group-item">
                    <input type="text" name="search_job_id" id="search_job_id" placeholder="Job ID">
                </li>
                <li class="list-group-item">
                    <input type="text" name="search_company" id="search_company" placeholder="Company">
                </li>
            </ul>
            <ul class="list-group list-group-horizontal">
                <li class="list-group-item">
                    <input type="text" name="search_brand" id="search_brand" placeholder="Brand">
                </li>

                <li class="list-group-item">
                    <input type="text" name="search_status" id="search_status" placeholder="Status">
                </li>
            </ul>

                @php
                    $all_media = App\Models\Media::orderBy('name', 'asc')->get();
                    $all_issue = App\Models\IssueNrs::orderBy('final_issue', 'asc')->get();          
                @endphp
                <ul class="list-group text-center" style="width: 445px;">
                    @if (isset($all_media[0]))
                    
                        <li class="list-group-item">
                            <select aria-label="Media select" id="search_media" name="search_media">
                                <option selected disabled>Media</option>
                                    @foreach ($all_media as $media)
                                        <option value="{{$media->abbreviation}}">{{$media->name}}</option>
                                    @endforeach
                            </select>
                        </li>   
                    @else
                        <p>No Media added</p>
                    @endif
              
                    @if (isset($all_issue[0]))
                    <li class="list-group-item" id="liDiv">
                        <select aria-label="Issue select" id="search_issue_nr" name="search_issue_nr">
                            <option selected disabled>Issue</option>
                                @foreach ($all_issue as $issue)
                                    <option value="{{$issue->final_issue}}">{{$issue->final_issue}}</option>
                                @endforeach
                        </select></li>   
                    @else
                        <p>No Issue added</p>
                    @endif
                </ul>
        </div>
    </div>
</div>

<table cellpadding="3" cellspacing="0" border="0" style="width: 67%; margin: 0 auto 2em auto;" class="mt-4">
    <div id="buttons"></div>
<table class="table table-bordered data-table" id="insertionsPersoTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Author</th>
            <th>Job ID</th>
            <th>Company</th>
            <th>Brand</th>
            <th>Comment</th>
            <th>Media</th>
            <th>Type</th>
            <th>Placement</th>
            <th>Issue Nr</th>
            <th>Quantity</th>
            <th>Fare</th>
            <th>Invoiced</th>
            <th>Deadline</th>
            <th>RCVD</th>
            <th>Status</th>
            <th width="100px">Action</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
        <tr>
            <th  colspan="11" style="text-align:right"></th>
            <th></th>
        </tr>
    </tfoot>
</table>

<script type="text/javascript">

    //FUNCTIONS

    function datatable() {
        var table = $('#insertionsPersoTable').DataTable({
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
                url: "{{ route('my_insertions') }}",
                data: function(d){
                    d.search = $('input[type="search"]').val();
                    d.check = $('#checkInput').is(":checked");
                    d.search_job_id = $('#search_job_id').val();
                    d.search_company = $('#search_company').val();
                    d.search_brand = $('#search_brand').val();
                    d.search_media = $('#search_media').val();
                    d.search_issue_nr = $('#search_issue_nr').val();
                    d.search_status = $('#search_status').val();
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'author', name: 'author'},
                {data: 'job_id', name: 'job_id'},
                {data: 'company', name: 'company'},
                {data: 'brand', name: 'brand'},
                {data: 'comment', name: 'comment'},
                {data: 'media', name: 'media'},
                {data: 'type', name: 'type'},
                {data: 'placement', name: 'placement'},
                {data: 'issue_nr', name: 'issue_nr'},
                {data: 'quantity', name: 'quantity'},
                {data: 'fare', name: 'fare'},
                {data: 'invoiced', name: 'invoiced'},
                {data: 'deadline', name: 'deadline'},
                {data: 'rcvd', name: 'rcvd'},
                {data: 'invoice_status', name: 'status'},
                {data: 'action', name: 'action', orderable: true, searchable: true},
            ],
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total over ALL pages
                var total = api
                    .column( 11 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    
                // Update footer
                $( api.column( 10 ).footer() ).html('Total:');
                $( api.column( 11 ).footer() ).html(total+'€');
                
            },
            "fnDrawCallback": function() {
                $('#checkInput').change(function (d) {
                    $('.data-table').DataTable().ajax.reload();
                });
                $('#search_job_id').keyup(function(){
                    table.draw();
                });
                $('#search_company').keyup(function(){
                    table.draw();
                });
                $('#search_brand').keyup(function(){
                    table.draw();
                });
                $('#search_media').change(function(){
                    table.draw();
                });
                $('#search_issue_nr').change(function(){
                    table.draw();
                });
                $('#search_status').keyup(function(){
                    table.draw();
                });
            },
        });
    };

    //SELECT ISSUE
    function getIssue(){
        let mediaInput = $('#search_media').val();
        
        $.ajax({
            type: 'post',
            url: '/ajax/issue/getSearch',
            data: {
                "_token": "{{ csrf_token() }}",
                media:mediaInput,
            },
            success: function (response) {
                let issue = '<select aria-label="Default select example" name="search_issue_nr" id="search_issue_nr"><option selected disabled>Issue</option>' ;
                
                response.forEach(element => {
                    issue += "<option value='"+element['final_issue']+"'>"+element['final_issue']+"</option>";
                });

                issue += '</select>';

                $('#liDiv').append(issue);
            },
            error: function (e){
                console.log(e)
            }
        });
    }

    $(document).ready(function(){
        datatable();
    });

    $("#search_media").change(function(){
        $('#search_issue_nr').remove();

        getIssue();
    })

  </script>
@endsection
