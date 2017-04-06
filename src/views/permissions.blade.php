<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Permissions</title>
        <link rel='stylesheet'  href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" media="screen"/>
        <link rel='stylesheet'  href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css" media="screen"/>
        <link rel='stylesheet'  href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
            <style>
                body{
                    background-color:<?php echo $permissions_view_backgroud_color; ?>;
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
                    <h1 class="col-xs-offset-5">Permissions</h1>
                </div>

                <div class="row">
                    <form class="form-inline" id="permissions-form">
                        <div class="col-md-12">
                            <div class="form-group col-lg-10" style="margin-bottom:5px;">
                                <div class="col-lg-3"><label for="parent_id">Parent:</label></div> 
                                <div class="col-lg-5">
                                    <select class="form-control" id="parent_id" name="parent_id">
                                        <option value="">Select Parent</option>
                                        <?php echo $permissions_dropdown; ?>
                                    </select>
                                    <span class="text-danger" id="parent_id_error"></span>
                                </div>
                            </div>

                            <div class="form-group col-lg-10" style="margin-bottom:5px;">
                                <div class="col-lg-3"><label for="name">Permission Name:</label></div> 
                                <div class="col-lg-5">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Permission Name"/>
                                    <span class="text-danger" id="name_error"></span>
                                </div>
                            </div>

                            <div class="form-group col-lg-10" style="margin-bottom:5px;">
                                <div class="col-lg-3"><label for="display_name">Display Name:</label></div>
                                <div class="col-lg-5">
                                    <input type="text" class="form-control" id="display_name" name="display_name" placeholder="Enter Display Name"/>
                                    <span class="text-danger" id="display_name_error"></span>
                                </div>
                            </div>

                            <div class="form-group col-lg-10" style="margin-bottom:5px;">
                                <div class="col-lg-3"><label for="description">Description:</label></div>
                                <div class="col-lg-5">
                                    <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description"/>
                                    <span class="text-danger" id="description_error"></span>
                                </div>                                
                            </div>

                            <div class="form-group col-lg-10" style="margin-bottom:5px;">
                                <div class="col-lg-3"><label for="type">Type:</label></div> 
                                <div class="col-lg-5">
                                    <select class="form-control" id="type" name="type">
                                        <option value="expand">Expand</option>
                                        <option value="open">Open</option>
                                        <option value="button">Button</option>
                                    </select>
                                    <span class="text-danger" id="type_error"></span>
                                </div>

                            </div>

                            <div class="form-group col-lg-10" style="margin-bottom:5px;">
                                <div class="col-lg-3"><label for="url">URL:</label></div>
                                <div class="col-lg-5">
                                    <input type="text" class="form-control" id="url" name="url" placeholder="Enter URL Link"/>
                                    <span class="text-danger" id="url_error"></span>
                                </div>                                
                            </div>

                            <div class="form-group col-lg-10" style="margin-bottom:5px;">
                                <div class="col-lg-3"><label for="parameters">URL Parameters:</label></div>
                                <div class="col-lg-5">
                                    <input type="text" class="form-control" id="parameters" name="parameters" placeholder="Enter URL Parameters"/>
                                    <span class="text-danger" id="parameters_error"></span>
                                </div>                                
                            </div>

                            <div class="form-group col-lg-10" style="margin-bottom:5px;">
                                <div class="col-lg-3"><label for="url_query_string">URL Query String:</label></div>
                                <div class="col-lg-5">
                                    <input type="text" class="form-control" id="url_query_string" name="url_query_string" placeholder="Enter Query String"/>
                                    <span class="text-danger" id="url_query_string_error"></span>
                                </div>                                
                            </div>

                            <div class="form-group col-lg-10" style="margin-bottom:5px;">
                                <div class="col-lg-3"><label for="css_class">CSS Class:</label></div>
                                <div class="col-lg-5">
                                    <input type="text" class="form-control" id="css_class" name="css_class" placeholder="Enter CSS Class"/>
                                    <span class="text-danger" id="css_class_error"></span>
                                </div>                                
                            </div>

                            <div class="form-group col-lg-10" style="margin-bottom:5px;">
                                <div class="col-lg-3"><label for="main_menu">Main Menu:</label></div>
                                <div class="col-lg-5">
                                    Yes <input type="radio" class="form-control main_menu" value="1" name="main_menu"/> | NO <input type="radio" class="form-control main_menu" value="0" checked name="main_menu"/>
                                    <span class="text-danger" id="main_menu_error"></span>
                                </div>                                
                            </div>

                            <div class="form-group col-lg-10" style="margin-bottom:5px;">
                                <div class="col-lg-3"><label for="sort_no">Sort No:</label></div>
                                <div class="col-lg-5">
                                    <input type="text" class="form-control" id="sort_no" name="sort_no" placeholder="Enter Sort No"/>
                                    <span class="text-danger" id="sort_no_error"></span>
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
                    <table id="permissions-grid" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Actions</th>
                                <th>Parent</th>
                                <th>Permission Name</th>
                                <th>Display Name</th>
                                <th>Description</th>
                                <th>Main Menu Status</th>
                                <th>Sort No</th>
                                <th>CSS Class</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Actions</th>
                                <th>Parent</th>
                                <th>Permission Name</th>
                                <th>Display Name</th>
                                <th>Description</th>
                                <th>Main Menu Status</th>
                                <th>Sort No</th>
                                <th>CSS Class</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="  crossorigin="anonymous"></script>
        <script type='text/javascript' src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
        <script type='text/javascript' src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
        <script>
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
        }
    });

    $('select').selectpicker({
        liveSearch: true
    });
    var datatable = $('#permissions-grid').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('get-permissions') }}",
            type: "POST"
        },
        columns: [
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
            {data: 'parent', name: 'parent'},
            {data: 'name', name: 'name'},
            {data: 'display_name', name: 'display_name'},
            {data: 'description', name: 'description'},
            {data: 'main_menu', name: 'main_menu'},
            {data: 'sort_no', name: 'sort_no'},
            {data: 'css_class', name: 'css_class'}
        ]
    });

    $('#form-add').click(function (e) {
        e.preventDefault();
        $('.text-danger').hide().html('');
        $.ajax({
            url: "{{ url('add-permission') }}",
            data: $('#permissions-form').serializeArray(),
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                if (response.hasOwnProperty('success')) {
                    repopluatePermissions();
                    datatable.ajax.reload();
                    alert(response['success']);
                    resetForm();
                } else if (response.hasOwnProperty('error')) {
                    alert(response['error']);
                    datatable.ajax.reload();
                }
            },
            error: function (errors) {
                $.each(errors['responseJSON'], function (index, error) {
                    $('#' + index + '_error').html(error).show();
                });
            }
        });
    });

    datatable.on('click', '.grid-row-update', function () {
        $('.text-danger').hide().html('');
        $('#id').val($(this).data('id'));
        $('#parent_id').selectpicker('val', $(this).data('parent_id')).focus();
        $('#name').val($(this).data('name'));
        $('#display_name').val($(this).data('display_name'));
        $('#description').val($(this).data('description'));
        $('#type').selectpicker('val', $(this).data('type'));
        $('#url').val($(this).data('url'));
        $('#parameters').val($(this).data('parameters'));
        $('#url_query_string').val($(this).data('url_query_string'));
        $('#css_class').val($(this).data('css_class'));
        $('input.main_menu[value="' + $(this).data('main_menu') + '"]').prop('checked', true);
        $('#sort_no').val($(this).data('sort_no'));

        $('#form-add').hide();
        $('#form-update').show();
        $('#form-cancel').show();
    });

    $('#form-update').click(function (e) {
        e.preventDefault();
        $('.text-danger').hide().html('');
        $.ajax({
            url: "{{ url('update-permission') }}",
            data: $('#permissions-form').serializeArray(),
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                if (response.hasOwnProperty('success')) {
                    repopluatePermissions();
                    datatable.ajax.reload();
                    alert(response['success']);
                    resetForm();
                } else if (response.hasOwnProperty('error')) {
                    alert(response['error']);
                    resetForm();
                } else if (response.hasOwnProperty('not_found')) {
                    alert(response['not_found']);
                } else if (response.hasOwnProperty('parent_id')) {
                    alert(response['parent_id']);
                }
            },
            error: function (errors) {
                $.each(errors['responseJSON'], function (index, error) {
                    $('#' + index + '_error').html(error).show();
                });
            }
        });
    });

    datatable.on('click', '.grid-row-delete', function () {
        if (confirm('Are you sure you want to delete this record?')) {
            var id = $(this).data('id');
            $.ajax({
                url: "{{ url('delete-permission') }}",
                type: 'POST',
                data: {id: id},
                dataType: 'json',
                success: function (response) {
                    if (response.hasOwnProperty('success')) {
                        repopluatePermissions();
                        datatable.ajax.reload();
                        alert(response['success']);
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
        $('.text-danger').hide().html('');
        $('#id').val('');
        $('#parent_id').selectpicker('val', '');
        $('#name').val('');
        $('#display_name').val('');
        $('#description').val('');
        $('#type').selectpicker('val', 'expand');
        $('#url').val('');
        $('#parameters').val('');
        $('#url_query_string').val('');
        $('#css_class').val('');
        $('input.main_menu[value="0"]').prop('checked', true);
        $('#sort_no').val('');
        $('#form-update').hide();
        $('#form-cancel').hide();
        $('#form-add').show();
    }

    function repopluatePermissions() {
        $.ajax({
            url: "{{ url('get-permissions-ajax') }}",
            type: 'POST',
            dataType: 'html',
            success: function (data) {
                $('#parent_id option:not(:first)').remove();
                $('#parent_id').selectpicker('val', '');
                $('#parent_id').append(data).selectpicker('refresh');
            }
        });
    }
});
        </script>
    </body>
</html>
