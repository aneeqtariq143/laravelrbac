<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Roles</title>
        <link rel='stylesheet'  href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" media="screen"/>
        <link rel='stylesheet'  href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css" media="screen"/>
        <link rel='stylesheet'  href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" type="text/css" media="screen"/>
        <style>
            body{
                background-color:<?php echo $roles_view_backgroud_color; ?>;
            }
            .row{
                margin:20px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="col-md-12">
                <div class="row">
                    <h1 class="col-xs-offset-5">User Roles</h1>
                </div>

                <div class="row">
                    <form class="form-inline" id="roles-form">
                        <div class="col-md-12">
                            <div class="form-group col-lg-10" style="margin-bottom:5px;">
                                <div class="col-lg-2"><label for="name">Role Name:</label></div> 
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter role Name"/>
                                    <span class="text-danger"></span>
                                </div>

                            </div>

                            <div class="form-group col-lg-10" style="margin-bottom:5px;">
                                <div class="col-lg-2"><label for="display_name">Display Name:</label></div>
                                <div class="col-lg-3">
                                    <input type="display_name" class="form-control" id="display_name" name="display_name" placeholder="Enter Display Name"/>
                                    <span class="text-danger"></span>
                                </div>
                            </div>

                            <div class="form-group col-lg-10" style="margin-bottom:5px;">
                                <div class="col-lg-2"><label for="description">Description:</label></div>
                                <div class="col-lg-3">
                                    <input type="description" class="form-control" id="description" name="description" placeholder="Enter Description"/>
                                    <span class="text-danger"></span>
                                </div>                                
                            </div>
                        </div>
                        {{ csrf_field() }}
                        <input type="hidden" name="id" id="id"/>
                    </form>
                </div>
                <div class="row"> 
                    <div class="col-lg-3">
                        <button type="button" class="btn btn-primary" id="form-add">Add</button>
                        <button type="button" class="btn btn-primary" id="form-update" style="display: none;">Update</button>
                        <button type="button" class="btn btn-danger" id="form-cancel" style="display: none;">Cancel</button>
                    </div>
                </div>



                <div class="row">
                    <table id="roles-grid" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Actions</th>
                                <th>Role Name</th>
                                <th>Display Name</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Actions</th>
                                <th>Role Name</th>
                                <th>Display Name</th>
                                <th>Description</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="  crossorigin="anonymous"></script>
        <script type='text/javascript' src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
        <script type='text/javascript' src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script> 
        <script>
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
        }
    });

    var datatable = $('#roles-grid').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('get-roles') }}",
            type: "POST"
        },
        columns: [
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'display_name', name: 'display_name'},
            {data: 'description', name: 'description'}
        ]
    });

    $('#form-add').click(function (e) {
        e.preventDefault();
        $('.text-danger').hide().html('');
        $.ajax({
            url: "{{ url('add-role') }}",
            data: $('#roles-form').serializeArray(),
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                if (response.hasOwnProperty('success')) {
                    alert(response['success']);
                    datatable.ajax.reload();
                    resetForm();
                } else if (response.hasOwnProperty('error')) {
                    alert(response['error']);
                    datatable.ajax.reload();
                }
            },
            error: function (errors) {
                $.each(errors['responseJSON'], function (index, error) {
                    $('#' + index).siblings('.text-danger').html(error).show();
                });
            }
        });
    });

    datatable.on('click', '.grid-row-update', function () {
        $('#id').val($(this).data('id'));
        $('#name').val($(this).data('name')).focus();
        $('#display_name').val($(this).data('display_name'));
        $('#description').val($(this).data('description'));

        $('#form-add').hide();
        $('#form-update').show();
        $('#form-cancel').show();
    });

    $('#form-update').click(function (e) {
        e.preventDefault();
        $('.text-danger').hide().html('');
        $.ajax({
            url: "{{ url('update-role') }}",
            data: $('#roles-form').serializeArray(),
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                if (response.hasOwnProperty('success')) {
                    alert(response['success']);
                    datatable.ajax.reload();
                    resetForm();
                } else if (response.hasOwnProperty('error')) {
                    alert(response['error']);
                    resetForm();
                } else if (response.hasOwnProperty('not_found')) {
                    alert(response['not_found']);
                }
            },
            error: function (errors) {
                $.each(errors['responseJSON'], function (index, error) {
                    $('#' + index).siblings('.text-danger').html(error).show();
                });
            }
        });
    });

    datatable.on('click', '.grid-row-delete', function () {
        if (confirm('Are you sure you want to delete this record?')) {
            var id = $(this).data('id');
            $.ajax({
                url: "{{ url('delete-role') }}",
                type: 'POST',
                data: {id: id},
                dataType: 'json',
                success: function (response) {
                    if (response.hasOwnProperty('success')) {
                        alert(response['success']);
                        datatable.ajax.reload();
                        resetForm();
                    } else if (response.hasOwnProperty('error')) {
                        alert(response['error']);
                        resetForm();
                    } else if (response.hasOwnProperty('not_found')) {
                        alert(response['not_found']);
                    }
                }
            });
        }
    });
    
    $('#form-cancel').click(function (){
        resetForm();
    });

    function resetForm() {
        $('#id').val('');
        $('#name').val('');
        $('#display_name').val('');
        $('#description').val('');
        $('#form-update').hide();
        $('#form-cancel').hide();
        $('#form-add').show();
    }
});
        </script>
    </body>
</html>
