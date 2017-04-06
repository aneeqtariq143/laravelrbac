<!doctype html>

<head>
    <meta charset="utf-8">
    <title>Assign Role Permissions</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="http://imgup.jan-japan.com/invoice_training/resources/css/bootstrap-select.css"/>
    <style type="text/css" >
        h3.bg-info {
            padding: 10px 0px;
            margin: 0px;
        }
        #menu_options tr > th:first-of-type {
            width: 20%;
        }
        #message {
            font-size: 30px;
            margin-top: 5px;
        }
        .table {
            width: 100% !important;
        }
        .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
            width: 220px;
        }
        #menu_options tr > th:first-of-type {
            width: 20%;
        }
        .bootstrap-select {
            max-width: 310px;
        }
    </style>
    <script src="http://imgup.jan-japan.com/invoice_training/resources/js/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" defer></script>
    <script src="http://imgup.jan-japan.com/invoice_training/resources/js/bootstrap-select.js" type="text/javascript"></script>
</head>

<body>
    <div id="result_page">
        <div id="message" style="text-align:center;"></div>
        <form action="" method="post" id="permissions_form" class="input_container">
            <table class="table table-striped table-bordered" id="menu_options">
                <thead>
                    <tr>
                        <th> <select id="role_id" name="role_id" class="selectpicker" data-live-search="true">
                                <option value="">Select Role</option>
                                <?php foreach ($roles as $role) { ?>
                                    <option value="{{$role->id}}" <?php echo ($role->id == $role_id) ? 'selected' : ''; ?>>{{$role->display_name}}</option>
                                <?php } ?>
                            </select>
                        </th>
                    </tr>
                    <tr>
                      <th>Main Menu <!--| - | Grant All <input type="checkbox" id="grant_all" >--></th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo generatePermissionsHtml($permissions); ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td><input id="assign-permissions" value="Assign Permissions" class="btn btn-primary" type="button"></td>
                    </tr>
                </tfoot>
            </table>
            {{ csrf_field() }}
        </form>
    </div>
    <script type="text/javascript">
$(document).ready(function (e) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
        }
    });
    
    $('#role_id').selectpicker();


    $("#grant_all").click(function (e) {

        if ($(this).prop("checked")) {
            $("tbody").find(":checkbox").prop("checked", true);
            $("tbody").find(":checkbox").prop("disabled", false);
        }
        else {
            $("tbody").find(":checkbox").prop("checked", false);
            document.getElementById("permissions_form").reset();
        }
    });

    $(".action, .child, .sub_parent").attr("disabled", "disabled");
    $(".child_inner, .child_first").hide();

    $(".main_parent, .main_parent+label > span").click(function (e) {
        var target = e.target.nodeName;
        if (target == "INPUT") {
            if ($(this).prop("checked")) {
                $(this).siblings("label").children("span").removeClass("glyphicon-triangle-bottom");
                $(this).siblings("label").children("span").addClass("glyphicon-triangle-top");

                $(this).parents(".parent_top").next(".child_first").show();

                $(this).parents(".parent_top").next(".child_first").find(".sub_parent").removeAttr("disabled");
                $(this).parents(".parent_top").next(".child_first").find(".lvl_2").find(".child").removeAttr("disabled");
                $(this).parents(".parent_top").next(".single").find('input.action').removeAttr("disabled");

            } else {
                $(this).parents(".parent_top").next(".child_first").find(".sub_parent").attr("disabled", "disabled");
                $(this).parents(".parent_top").next(".child_first").find(".sub_parent").removeAttr("checked");

                $(this).parents(".parent_top").next(".child_first").find(":checkbox").removeAttr("checked");
                $(this).parents(".parent_top").next(".child_first").find(":checkbox").attr("disabled", "disabled");
                $(this).parents(".parent_top").next(".single").find('input.action').attr("disabled", "disabled");
            }
        }
        else if (target == "SPAN") {
            if ($(this).hasClass("glyphicon-triangle-bottom")) {
                $(this).removeClass("glyphicon-triangle-bottom");
                $(this).addClass("glyphicon-triangle-top");
                $(this).parents(".parent_top").next(".child_first").show();
            } else {
                $(this).addClass("glyphicon-triangle-bottom");
                $(this).removeClass("glyphicon-triangle-top");
                $(this).parents(".parent_top").next(".child_first").hide();

            }
        }

    });

    $(".sub_parent+span, .sub_parent").click(function (e) {
        var target = e.target.nodeName;

        if (target == "INPUT") {
            if ($(this).prop("checked")) {
                $(this).siblings("span").removeClass("glyphicon-triangle-bottom");
                $(this).siblings("span").addClass("glyphicon-triangle-top");
                $(this).parents(".parent_inner").next(".child_inner").show();
                $(this).parents(".parent_inner").next(".child_inner").find(".child").removeAttr("disabled");
            } else {
                $(this).parents(".parent_inner").next(".child_inner").find(".child").attr("disabled", "disabled");
                $(this).parents(".parent_inner").next(".child_inner").find(".child").removeAttr("checked");
                $(this).parents(".parent_inner").next(".child_inner").find(".child").parent().siblings().children(".action").removeAttr("checked");
                $(this).parents(".parent_inner").next(".child_inner").find(".child").parent().siblings().children(".action").attr("disabled", "disabled");
            }
        }
        else if (target == "SPAN") {
            if ($(this).hasClass("glyphicon-triangle-bottom")) {
                $(this).removeClass("glyphicon-triangle-bottom");
                $(this).addClass("glyphicon-triangle-top");
                $(this).parents(".parent_inner").next(".child_inner").show();
            } else {
                $(this).addClass("glyphicon-triangle-bottom");
                $(this).removeClass("glyphicon-triangle-top");
                $(this).parents(".parent_inner").next(".child_inner").hide();

            }
        }

    });

    $(".child").click(function (e) {
        if ($(this).prop("checked")) {
            $(this).parent("div").siblings("div").children(".action").removeAttr("disabled");
        } else {
            $(this).parent("div").siblings("div").children(".action").attr("disabled", "disabled");
            $(this).parent("div").siblings("div").children(".action").removeAttr("checked");
        }
    });
    
    $('#role_id').change(function () {
        if ($(this).val() !== '') {
            $.ajax({
                url: "{{ url('get-role-permissions-ajax') }}",
                type: 'POST',
                data: {'role_id': $(this).val()},
                dataType: 'json',
                success: function (response) {
                    $('input[name^="permission_ids"]').prop('checked', false);
                    if(response['permissions'].length > 0){
                        $.each(response['permissions'], function (index, element){
                            $('input[name^="permission_ids"][value="'+element.id+'"]').prop('checked', true).removeAttr("disabled");
                        })
                    }
                },
                error: function (errors) {
                    $.each(errors['responseJSON'], function (index, error) {
                        $('#' + index + '_error').html(error).show();
                    });
                }
            });
        } else {
            $('input[name^="permission_ids"]').prop('checked', false);
        }
    });
    $('#role_id').trigger('change');

    $('#assign-permissions').click(function () {
        $('.text-danger').html('').hide();
        $.ajax({
            url: "{{ url('assign-role-permissions-ajax') }}",
            type: 'POST',
            data: $('#permissions_form').serializeArray(),
            dataType: 'json',
            success: function (response) {
                if (response.hasOwnProperty('success')) {
                    alert(response['success']);
                } else if (response.hasOwnProperty('error')) {
                    alert(response['error']);
                } else if (response.hasOwnProperty('not_found')) {
                    alert(response['not_found']);
                }
            },
            error: function (errors) {
                $.each(errors['responseJSON'], function (index, error) {
                    $('#' + index + '_error').html(error).show();
                });
            }
        });
    });
});


    </script>
</body>
</html>