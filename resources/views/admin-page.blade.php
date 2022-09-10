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
        <h1 style="text-align: center; margin-bottom:15px">Admin Page</h1>
        <!---------------------------START TOP BUTTON--------------------------->
        <div class="pull-right mb-2">
            <input type="button" value="Add City" class="btn btn-success" onClick="add()" href="javascript:void(0)">

            <input type="button" value="Fast Assign" class="btn btn-primary opacity-25 top-btn fast-assign" disabled>
            <input type="button" value="Batch Assign" class="btn btn-primary opacity-25 top-btn batch-assign" disabled>
            <input type="button" value="Batch Confirm" class="btn btn-primary opacity-25 top-btn batch-confirm" disabled>

            <input type="button" value="Batch unAssign" class="btn btn-warning opacity-25 top-btn batch-unassign" disabled>
            <input type="button" value="Batch Delete" class="btn btn-danger opacity-25 top-btn batch-delete" disabled>
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
<!---------------------------START MODAL--------------------------->
<div class="modal fade" id="city-modal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="CityModal"></h4>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="CityForm" name="CityForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name" id="labelname" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter City Name" maxlength="50">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" id="labelpopulation" class="col-sm-2 control-label">Population</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="population" name="population" placeholder="Enter City Population" maxlength="50">
                        </div>
                    </div>
                    <div class="form-group">
                        <label id="labelsurveyor" class="col-sm-2 control-label">Surveyor</label>
                        <div class="col-sm-12">
                            <select class="form-control select2" id="surveyor_id" name="surveyor_id">
                                <option value="">--Select Surveyor--</option>
                                @foreach($users as $surveyor)
                                <option value="{{ $surveyor->id }}">{{ $surveyor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save">Save changes</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!---------------------------END MODAL--------------------------->
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
            ajax: "{{ url('admin-page') }}",
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
            ],
        });
    });
    //===========ADD DATA USING MODAL==============================
    function add() {
        $('#CityForm').trigger("reset");
        $('#CityModal').html("Add City");
        $('#city-modal').modal('show');
        $('#labelname').attr('hidden', false);
        $('#labelpopulation').attr('hidden', false);
        $('#labelsurveyor').attr('hidden', false);
        $('#id').val('');
        $('#name').attr('hidden', false);
        $('#population').attr('hidden', false);
        $('#surveyor_id').attr('Disabled', false);
        $('#surveyor_id').trigger('change');
    }
    //===========EDIT DATA USING MODAL==============================
    function editFunc(id) {
        $.ajax({
            type: "POST",
            url: "{{ url('edit-city') }}",
            data: {
                id: id
            },
            dataType: 'json',
            success: function(res) {
                $('#CityModal').html("Edit City");
                $('#city-modal').modal('show');
                $('#labelname').attr('hidden', false);
                $('#labelpopulation').attr('hidden', false);
                $('#labelsurveyor').attr('hidden', false);
                $('#id').val(res.id);
                $('#name').val(res.name).attr('hidden', false);
                $('#population').val(res.population).attr('hidden', false);
                $('#surveyor_id').val(res.surveyor_id).attr('disabled', false);
                $('#surveyor_id').trigger('change');
                console.log('Edit Function');
                console.log(res.id);
                console.log(res.name);
                console.log(res.population);
                console.log(res.surveyor_id);
                console.log('=========================');
            }
        });
    }
    //===========FAST ASSIGN A SURVEYOR==============================
    $(document).on('click', '.fast-assign', function(e) {
        var cityId = [];
        var temp = 3;
        if (confirm("Do you want to ASSIGN THIS SURVEYOR in these cities?")) {
            $('.checkbox:checked').each(function() {
                cityId.push($(this).val());
                console.log(cityId);
            });

            if (cityId.length > 0) {
                $.ajax({
                    type: "PUT",
                    url: "{{ url('fast-assign') }}",
                    data: {
                        cityId,
                        temp
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
    //===========BATCH ASSIGN A SURVEYOR INTO ROWS==============================
    $(document).on('click', '.batch-assign', function(e) {
        var cityId = [];
        var svrid;

        $('.checkbox:checked').each(function() {
            cityId.push($(this).val());
            console.log(cityId);
        });

        if (cityId.length > 0) {
            $.ajax({
                type: "PUT",
                url: "{{ url('batch-assign') }}",
                data: {
                    cityId,
                    svrid
                },
                dataType: "json",
                success: function(res) {
                    $('#CityModal').html("Assign Surveyor");
                    $('#city-modal').modal('show');
                    $('#labelname').attr('hidden', true);
                    $('#labelpopulation').attr('hidden', true);
                    $('#labelsurveyor').attr('hidden', false);
                    $('#id').val(res.id);
                    $('#name').val(res.name).attr('hidden', true);
                    $('#population').val(res.population).attr('hidden', true);
                    $('#surveyor_id').val(res.surveyor_id).attr('disabled', false);
                    //$('#surveyor_id').trigger('change');
                    svrid = res.surveyor_id;
                }
            });
        } else {
            alert('Please select atleast one row');
        }
    });
    //===========BATCH UNASSIGN A SURVEYOR FROM ROWS==============================
    $(document).on('click', '.batch-unassign', function(e) {
        var cityId = [];
        if (confirm("Do you want to UNASSIGN THIS SURVEYOR in these cities?")) {
            $('.checkbox:checked').each(function() {
                cityId.push($(this).val());
                console.log(cityId);
            });

            if (cityId.length > 0) {
                $.ajax({
                    type: "PUT",
                    url: "{{ url('batch-unassign') }}",
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
    //===========BATCH CONFIRM SOME DONE ROWS==============================
    $(document).on('click', '.batch-confirm', function(e) {
        var cityId = [];
        if (confirm("Do you want to CONFIRM these data are DONE?")) {
            $('.checkbox:checked').each(function() {
                cityId.push($(this).val());
                console.log(cityId);
            });

            if (cityId.length > 0) {
                $.ajax({
                    type: "PUT",
                    url: "{{ url('batch-confirm') }}",
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
    //===========BATCH DELETE SOME ROWS==============================
    $(document).on('click', '.batch-delete', function(e) {
        var cityId = [];
        if (confirm("Do you want to DELETE these rows of data?")) {
            $('.checkbox:checked').each(function() {
                cityId.push($(this).val());
                console.log(cityId);
            });

            if (cityId.length > 0) {
                $.ajax({
                    type: "PUT",
                    url: "{{ url('batch-delete') }}",
                    data: {
                        cityId
                    },
                    dataType: 'json',
                    success: function(res) {
                        var oTable = $('#city-crud-datatable').dataTable();
                        oTable.fnDraw(false);
                    }
                });
            } else {
                alert('Please select atleast one row');
            }
        }
    });
    //===========CONFIRM A DONE ROW==============================
    function confirmFunc(id) {
        if (confirm("Do you want to CONFIRM as DONE this row?")) {
            $.ajax({
                type: "PUT",
                url: "{{ url('set-confirm') }}",
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
    //===========DELETE A ROW==============================
    function deleteFunc(id) {
        if (confirm("Do you want to DELETE this row?") == true) {
            var id = id;
            // ajax
            $.ajax({
                type: "POST",
                url: "{{ url('delete-city') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    var oTable = $('#city-crud-datatable').dataTable();
                    oTable.fnDraw(false);
                }
            });
        }
    }
    //===========STORE DATA FROM MODAL INTO DATATABLE==============================
    $('#CityForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: "{{ url('store-city')}}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                $("#city-modal").modal('hide');
                var oTable = $('#city-crud-datatable').dataTable();
                oTable.fnDraw(false);
                $("#btn-save").html('Submit');
                $("#btn-save").attr("disabled", false);
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
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