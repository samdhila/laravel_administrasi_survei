@extends('layouts.app')

@section('content')

<head>
    <!------------------------------------------include JQuery------------------------------------------>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!------------------------------------------include DataTable Plugin------------------------------------------>
    <link type="text/css" href="https://cdn.datatables.net/s/dt/dt-1.10.10,se-1.1.0/datatables.min.css" rel="stylesheet" />
    <script type="text/javascript" src="https://cdn.datatables.net/s/dt/dt-1.10.10,se-1.1.0/datatables.min.js"></script>
    <!------------------------------------------include DataTable Checbox------------------------------------------>
    <link type="text/css" href="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />
    <script type="text/javascript" src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
    <!------------------------------------------include DataTable Editor------------------------------------------>
    <link type="text/css" href="https://editor.datatables.net/extensions/Editor/css/editor.dataTables.min.css" rel="stylesheet" />
</head>
<div class="container">
    <div class="row justify-content-center">
        <h1 style="text-align: center">Table Template</h1>
        <form id="row-checked" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>City</th>
                        <th>Population</th>
                        <th>Surveyor</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>City</th>
                        <th>Population</th>
                        <th>Surveyor</th>
                    </tr>
                </tfoot>
            </table>
            <hr>

            <p>Press <b>Submit</b> and check console for URL-encoded form data that would be submitted.</p>

            <p><button>Submit</button></p>

            <p><b>Selected rows data:</b></p>
            <pre id="console-rows"></pre>

            <p><b>Form data as submitted to the server:</b></p>
            <pre id="console-form"></pre>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            'ajax': 'https://raw.githubusercontent.com/donyyasin12/file-hosting/main/simple.dataset.json',
            'columnDefs': [{
                'targets': 0,
                'checkboxes': {
                    'selectRow': true
                }
            }],
            'select': {
                'style': 'multi'
            },
            'order': [
                [1, 'asc']
            ]
        });

        // Handle form submission event 
        $('#row-checked').on('submit', function(e) {
            var form = this;

            var rows_selected = table.column(0).checkboxes.selected();

            // Iterate over all selected checkboxes
            $.each(rows_selected, function(index, rowId) {
                // Create a hidden element 
                $(form).append(
                    $('<input>')
                    .attr('type', 'hidden')
                    .attr('name', 'id[]')
                    .val(rowId)
                );
            });

            // FOR DEMONSTRATION ONLY
            // The code below is not needed in production

            // Output form data to a console     
            $('#console-rows').text(rows_selected.join(","));
            console.log(rows_selected.join(","));

            // Output form data to a console     
            $('#console-form').text($(form).serialize());
            console.log($(form).serialize());

            // Remove added elements
            $('input[name="id\[\]"]', form).remove();

            // Prevent actual form submission
            e.preventDefault();
        });
    });
</script>
@endsection