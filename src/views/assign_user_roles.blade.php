<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Assign User Roles</title>
        <link rel='stylesheet'  href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" media="screen"/>
        <link rel='stylesheet'  href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css" media="screen"/>
        <link rel='stylesheet'  href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" type="text/css" media="screen"/>
        <style>
            body{
                background-color:<?php echo $assign_roles_view_background_color; ?>;
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
                    <form class="form-inline" id="user-roles-form">
                        <div class="col-md-12">
                            <div class="form-group col-lg-12" style="margin-bottom:5px;">
                                <div class="col-lg-2"><label for="name">User Name:</label></div> 
                                <div class="col-lg-3">
                                    {{ $user->$user_display_name }}
                                </div>

                            </div>

                            <div class="form-group col-lg-12" style="margin-bottom:5px;">
                                <div class="col-lg-2"><label for="role_id">Role Name:</label></div>
                                <div class="col-lg-10">
                                    <select class="role_ids" name="role_ids[]" multiple="multiple" style="width: 90%">
                                        <?php if (!empty($roles)) {
                                            foreach ($roles as $role) {
                                                ?>
                                        <option value="{{$role->id}}"  <?php echo (in_array($role->id, $user_roles)) ? 'selected' : ''; ?>>{{$role->display_name}}</option>
                                            <?php }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id" value="{{$user_id}}"/>
                    </form>
                </div>
                <div class="row"> 
                    <div class="col-lg-3">
                        <button type="button" class="btn btn-primary" id="form-add">Assign Roles</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="  crossorigin="anonymous"></script>
        <script type='text/javascript' src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
        <script type='text/javascript' src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> 
        <script>
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
        }
    });

    $(".role_ids").select2();
    $('#form-add').click(function (e) {
        e.preventDefault();
        $('.text-danger').hide().html('');
        $.ajax({
            url: "{{ url('assign-user-roles-ajax') }}",
            data: $('#user-roles-form').serializeArray(),
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                if (response.hasOwnProperty('success')) {
                    alert(response['success']);
                    resetForm();
                } else if (response.hasOwnProperty('error')) {
                    alert(response['error']);
                }
            },
            error: function (errors) {
                $.each(errors['responseJSON'], function (index, error) {
                    $('#' + index).siblings('.text-danger').html(error).show();
                });
            }
        });
    });
});
        </script>
    </body>
</html>
