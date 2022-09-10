@extends('layouts.app')

@section('content')

<head>
    <meta charset="UTF-8">
    <title>City DataTable</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!------------------------------------------include JQuery------------------------------------------>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!------------------------------------------include JQuery UI------------------------------------------>
    <link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">
    <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
    <!------------------------------------------include Bootstrap------------------------------------------>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!------------------------------------------include DataTable Plugin------------------------------------------>
    <link type="text/css" href="https://cdn.datatables.net/s/dt/dt-1.10.10,se-1.1.0/datatables.min.css" rel="stylesheet" />
    <script type="text/javascript" src="https://cdn.datatables.net/s/dt/dt-1.10.10,se-1.1.0/datatables.min.js"></script>
    <!------------------------------------------include DataTable Checbox------------------------------------------>
    <link type="text/css" href="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />
    <script type="text/javascript" src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
    <!------------------------------------------include DataTable Editor------------------------------------------>
    <link type="text/css" href="https://editor.datatables.net/extensions/Editor/css/editor.dataTables.min.css" rel="stylesheet" />
    <!------------------------------------------Include Select2 plugin------------------------------------------>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://raw.githubusercontent.com/donyyasin12/file-hosting/main/select2-dropdownPosition.js"></script>
    <!------------------------------------------Slight CSS code fo some tags------------------------------------------>
    <style>
        .select2 {
            width: 435px;
            position: static;
        }
    </style>

</head>
<!------------------------------------------START MAIN CONTENT------------------------------------------>
<div class="container">
    <div class="row justify-content-center">
        <h1 style="text-align: center">Surveyor Page</h1>
        <!---------------------------START TOP BUTTON--------------------------->
        <div class="pull-right mb-2">
            <input type="button" class="btn btn-success top-btn batch-done" value="Mark as Done">
            <input type="button" class="btn btn-warning top-btn batch-undone" value="Mark as unDone">
        </div>
        <!---------------------------END TOP BUTTON--------------------------->
        <!---------------------------START DATATABLE--------------------------->
        <table id="city-crud-datatable" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><input type="checkbox" id="batchcheckbox" onclick="toggle(this);"></th>
                    <th>No</th>
                    <th>City</th>
                    <th>Population</th>
                    <th>Surveyor</th>
                    <th>Done</th>
                    <th>Confirmed</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th><input type="checkbox" id="batchcheckbox" onclick="toggle(this);"></th>
                    <th>No</th>
                    <th>City</th>
                    <th>Population</th>
                    <th>Surveyor</th>
                    <th>Done</th>
                    <th>Confirmed</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
        <!---------------------------END DATATABLE--------------------------->
    </div>
</div>
<!------------------------------------------END MAIN CONTENT------------------------------------------>
<!------------------------------------------START JAVASCRIPT SECTION------------------------------------------>
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //===========DATATABLE DECLARATION==============================
        $('#city-crud-datatable').DataTable({
            rowCallback: function(row, data, index) {
                if (data.confirmed == '1') {
                    $(row).find('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6)')
                        .css('background-color', '#90EE90'); //green
                } else if (data.done == '1') {
                    $(row).find('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5)')
                        .css('background-color', '#FFFF99'); //yellow
                } else if (data.surveyor != null) {
                    $(row).find('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)')
                        .css('background-color', '#D7DAE5'); //grey
                }
            },
            processing: true,
            serverSide: true,
            ajax: "{{ url('surveyor-page') }}",
            columns: [{
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'population',
                    name: 'population'
                },
                {
                    data: 'surveyor',
                    name: 'surveyor'
                },
                {
                    data: 'done',
                    name: 'done'
                },
                {
                    data: 'confirmed',
                    name: 'confirmed'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                },
            ],
            order: [
                [0, 'desc']
            ]
        });
    });
    //===========BATCH DONE SOME ROWS OF DATA==============================
    $(document).on('click', '.batch-done', function(e) {
        var cityId = [];
        if (confirm("Do you want to mark as DONE these rows?")) {
            $('.checkbox:checked').each(function() {
                cityId.push($(this).val());
                console.log(cityId);
            });

            if (cityId.length > 0) {
                $.ajax({
                    type: "PUT",
                    url: "{{ url('batch-done') }}",
                    data: {
                        cityId
                    },
                    dataType: "json",
                    success: function(res) {
                        console.log(res);
                        if (res.status == 400) {
                            $('#success_message').html('');
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(res.message);
                        } else {
                            $('#success_message').html('');
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(res.message);
                            //table.draw();
                            var oTable = $('#city-crud-datatable').dataTable();
                            oTable.fnDraw(false);
                        }
                    }
                });
            } else {
                alert('Please select atleast one row');
            }
        }
    });
    //===========BATCH UNDONE SOME ROWS OF DATA==============================
    $(document).on('click', '.batch-undone', function(e) {
        var cityId = [];
        if (confirm("Do you want to mark as UNDONE these rows?")) {
            $('.checkbox:checked').each(function() {
                cityId.push($(this).val());
                console.log(cityId);
            });

            if (cityId.length > 0) {
                $.ajax({
                    type: "PUT",
                    url: "{{ url('batch-undone') }}",
                    data: {
                        cityId
                    },
                    dataType: "json",
                    success: function(res) {
                        console.log(res);
                        if (res.status == 400) {
                            $('#success_message').html('');
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(res.message);
                        } else {
                            $('#success_message').html('');
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(res.message);
                            //table.draw();
                            var oTable = $('#city-crud-datatable').dataTable();
                            oTable.fnDraw(false);
                        }
                    }
                });
            } else {
                alert('Please select atleast one row');
            }
        }
    });
    //===========MARK DONE A ROW OF DATA==============================
    function doneFunc(id) {
        if (confirm("Do you want to mark as DONE this row?")) {
            $.ajax({
                type: "PUT",
                url: "{{ url('mark-done') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    if (res.status == 400) {
                        $('#success_message').html('');
                        $('#success_message').addClass('alert alert-danger');
                        $('#success_message').text(res.message);
                    } else {
                        $('#success_message').html('');
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(res.message);
                        //table.draw();
                        var oTable = $('#city-crud-datatable').dataTable();
                        oTable.fnDraw(false);
                    }
                }
            });
        }
    }
    //===========MARK UNDONE A ROW OF DATA==============================
    function undoneFunc(id) {
        if (confirm("Do you want to mark as UNDONE this row?")) {
            $.ajax({
                type: "PUT",
                url: "{{ url('mark-undone') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    if (res.status == 400) {
                        $('#success_message').html('');
                        $('#success_message').addClass('alert alert-danger');
                        $('#success_message').text(res.message);
                    } else {
                        $('#success_message').html('');
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(res.message);
                        //table.draw();
                        var oTable = $('#city-crud-datatable').dataTable();
                        oTable.fnDraw(false);
                    }
                }
            });
        }
    }
</script>
<!------------------------------------------JavaScript Divider------------------------------------------>
<script>
    $(document).ready(() => {
        const targetObs = document.querySelector('#city-crud-datatable > tbody');
        // ============================================
        // CREATE OBSERVER
        const observer = new MutationObserver(() => {
            if (document.querySelector('#checkbox')) {
                console.log('checkbox detected in HTML!');
                //CHECKED CONDITION
                $('input[type="checkbox"]').change(function() {
                    if ($(this).is(':checked')) {
                        $('.top-btn').removeAttr('disabled').removeClass('opacity-25'); //enable input
                        console.log('Some checkboxes are CHECKED!');
                    } else {
                        $('.top-btn').attr('disabled', true).addClass('opacity-25'); //disable input
                        console.log('Some checkboxes are UNCHECKED!');
                    }
                });
                $('.top-btn').attr('disabled', true).addClass('opacity-25');
            }
        });
        // ============================================
        // START THE OBSERVER
        observer.observe(targetObs, {
            childList: true
        });

        //SELECT2 JS =========================
        $('.select2').select2({
            dropdownParent: $('#city-modal'),
            dropdownPosition: 'below'
        });
        //SELECT2 JS =========================
    });
    //SELECT ALL CHECKBOXES
    function toggle(source) {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i] != source)
                checkboxes[i].checked = source.checked;
        }
    }
</script>
@endsection