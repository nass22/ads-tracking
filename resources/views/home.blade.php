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

                <input type="text" name="search_job_id" id="search_job_id" placeholder="Job ID">
                <input type="text" name="search_company" id="search_company" placeholder="Company">
                <input type="text" name="search_brand" id="search_brand" placeholder="Brand">
                <input type="text" name="search_media" id="search_media" placeholder="Media">
                <input type="text" name="search_issue_nr" id="search_issue_nr" placeholder="Issue Nr">
                <input type="text" name="search_status" id="search_status" placeholder="Status">
           
        </div>
    </div>

</div>


<table border="0" style="width: 67%; margin: 0 auto 2em auto;" class="mt-4">
    <div id="buttons"></div>
<table class="table table-bordered data-table stripe compact" id="insertionsTable">
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
            <th>Invoice Nr</th>
            <th>Year</th>
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
</div>

<script type="text/javascript">

    //FUNCTIONS

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
                url: "{{ route('home') }}",
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
                {data: 'invoice_nr', name: 'invoice_nr'},
                {data: 'year', name: 'year'},
                {data: 'rcvd', name: 'rcvd'},
                {data: 'invoice_status', name: 'invoice_status'},
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
                $('#checkInput').change(function () {
                    table.draw();
                });
                $('#search_job_id').keyup(function(){
                    table.draw();
                });
                $('#search_company').keyup(function(){
                    table.draw();
                });
                $('#search_job_id').keyup(function(){
                    table.draw();
                });
                $('#search_media').keyup(function(){
                    table.draw();
                });
                $('#search_issue_nr').keyup(function(){
                    table.draw();
                });
                $('#search_status').keyup(function(){
                    table.draw();
                });
            },
        });
    };

    $(document).ready(function(){
        datatable();
    });

    $('.delete-confirm').on('click', function (event) {
        var form =  $(this).closest("form");
        event.preventDefault();
        new swal({
            title: 'Are you sure?',
            text: 'This record and it`s details will be permanantly deleted!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
                form.submit();
            }
        });
    });
  </script>
@endsection
