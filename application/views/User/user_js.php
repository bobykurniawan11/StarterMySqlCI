
<script>	
	var moduleAllow = null;
var myDatatable;
$.holdReady(true);

$(window).on('load', function() {



    $.ajax({
        type: "POST",
        url: "<?=base_url();?>users/checkAccessCRUD",
        success: function(data) {
            moduleAllow = data;


            $.fn.dataTable.ext.buttons.refresh = {
                text: 'Refresh',
                action: function(e, dt, node, config) {
                    dt.ajax.reload();
                },
                className: "btn btn-info btn-sm customBtn_by"
            };

            myDatatable = $('#example1').DataTable({
                "processing": true,
                dom: 'Bfrtip',
                "ajax": {
                    "url": '<?=base_url();?>/users/lists',
                    "dataSrc": ""
                },
                "columns": [{
                        "data": "username"
                    },
                    {
                        "data": "type"
                    },
                 
                
                    {
                        "mData": "Name",
                        "mRender": function(data, type, row) {

                            if (row.flag == 1) {
                                return '<div class="btn-toolbar"> <button id = "icon_edit" data-value="' + row.username + '" class="btn btn-warning editData"> <i class="fa fa-pencil"> </i>  </button>' +
                                    '<button id = "icon_delete" data-value="' + row.username + '" data-flag="' + row.flag + '"  class="btn btn-success deleteData"> <i class="fa fa-toggle-off"> </i>   </button>  </div>';
                            } else {
                                return '<div class="btn-toolbar"> <button id = "icon_edit" data-value="' + row.username + '" class="btn btn-warning editData"> <i class="fa fa-pencil"> </i>  </button>' +
                                    '<button   id = "icon_delete" data-value="' + row.username + '"  data-flag="' + row.flag + '" class="btn btn-danger deleteData"> <i class="fa fa-toggle-on"> </i>   </button> </div>';
                            }

                        }
                    }

                ],
                buttons: [
                    'refresh'
                ],
            });

            $.holdReady(false);
        }
    });
});

$(document).ready(function() {
    var resultOfAccess = $.parseJSON(moduleAllow);

    var usernameValue, typeValue;
    var selectType = $(".Type");
    var UsernameField = $(".Username");
    var PasswordField = $(".Password");

    var UsernameValue, PasswordValue, TypeValue, flagValue;

    $.fn.dataTable.ext.buttons.add_new = {
        text: 'Add New',
        action: function(e, dt, node, config) {
            populateModal();
        },
        className: "btn btn-success btn-sm customBtn_by"
    };


    myDatatable.on('draw.dt', function() {
        $(".editData").hide();
        $(".deleteData").hide();
        if (resultOfAccess.edit == 1) {
            $(".editData").show();
        }
        if (resultOfAccess.delete == 1) {
            $(".deleteData").show();
        }
    });

    if (resultOfAccess.insert == 1) {
        myDatatable.button().add(0, {
            text: 'Add New',
            action: function(e, dt, node, config) {
                populateModal();
            },
            className: "btn btn-success btn-sm customBtn_by"
        });
    }


    $(document).on("click", ".editData", function() {
        var value = $(this).data("value");
        usernameValue = value;
        populateModaledit();

    });

    $(document).on("click", ".deleteData", function() {
        var value = $(this).data("value");
        var flag = $(this).data("flag");
        flagValue = flag;
        usernameValue = value;
        deleteUser();
    });

    function populateType(existingData = "") {

        $.ajax({
            type: "POST",
            url: "<?=base_url();?>Users/getListType",
            success: function(data) {
                var opts = $.parseJSON(data);
                var selected;
                selected = "";
                selectType.append('<option value=""> --- </option>');
                $.each(opts, function(i, d) {
                    selectType.append('<option ' + selected + ' value="' + d.TypeCode + '">' + d.TypeDesc + '</option>');
                });

                selectType.val(existingData);

            }


        });
    }

    function populateModal() {
        populateType();
        $("#myForm")[0].reset();
        $("#compose-modal").modal("show");
    }



    $('#compose-modal').on('hidden.bs.modal', function() {
        $("#myForm")[0].reset();
        selectType.find('option')
            .remove()
            .end();
    });

    $('#edit-modal').on('hidden.bs.modal', function() {
        $("#editForm")[0].reset();
        selectType.find('option')
            .remove()
            .end();
    });

    $(document).on("click", '#saveData', function() {
        saveData();
    });

    function saveData() {
        UsernameValue = UsernameField.val();
        PasswordValue = PasswordField.val();
        TypeValue = selectType.val();

        var request = $.ajax({
            type: "POST",
            url: "<?=base_url();?>Users/saveData",
            data: {
                username: UsernameValue,
                password: PasswordValue,
                type: TypeValue
            },
        });

        request.done(function(msg) {
            var data = $.parseJSON(msg);
            if (data.Status == false) {
                buildFalse(data);
            } else {
                $("#compose-modal").modal('toggle');
                myDatatable.ajax.reload();
            }

        });

        request.fail(function(jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });

    }

    function buildFalse(data) {
        $(".forMessage").html('<div class="alert alert-danger text-center"> ' + data.Message + ' </div>');
    }

    function populateModaledit() {
        $("#editForm")[0].reset();
        $("#edit-modal").modal("show");

        selectType.find('option')
            .remove()
            .end();

        $.ajax({
            type: "POST",
            url: "<?=base_url();?>users/getSingle",
            data: {
                username: usernameValue
            },
            success: function(datas) {
                var data = $.parseJSON(datas);
                UsernameField.val(data.username);
                populateType(data.type.replace(/\s/g, ''));
            }

        });
    }

    $("#updateData").click(function() {
        usernameValue = UsernameField.val();
        typeValue = Typeedit.val();
        var request = $.ajax({
            type: "POST",
            url: "<?=base_url();?>Users/updateData",
            data: {
                username: usernameValue,
                type: typeValue
            },
        });
        request.done(function(msg) {
            var data = $.parseJSON(msg);
            if (data.Status == false) {
                buildFalse(data);
            } else {
                $("#edit-modal").modal("toggle");
                myDatatable.ajax.reload();
            }

        });

        request.fail(function(jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
    });

    function deleteUser() {
        console.log(flagValue);
        var request = $.ajax({
            type: "POST",
            url: "<?=base_url();?>Users/deleteUser",
            data: {
                username: usernameValue,
                flag: flagValue
            },
        });

        request.done(function(msg) {
            console.log(msg);
            myDatatable.ajax.reload();
        });

        request.fail(function(jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
    }

    $(document).on("click", ".addModule", function() {
        var value = $(this).data("value");
        publiCode = value;
        $.redirect('<?=base_url();?>Users/editAccess', {
            'usercode': publiCode
        });
    });

});


</script>