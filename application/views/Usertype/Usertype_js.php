
<script type="text/javascript">
var moduleAllow = null;
var myDatatable;
var myselect;
$.holdReady(true);

$(window).on('load', function() {

    $.ajax({
        type: "POST",
        url: "<?=base_url();?>Usertype/checkAccessCRUD",
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
                    "url": '<?=base_url();?>/Usertype/lists',
                    "dataSrc": ""
                },
                "columns": [{
                        "data": "TypeCode"
                    },
                    {
                        "data": "TypeDesc"
                    },
                    {
                        "mData": "Name",
                        "mRender": function(data, type, row) {
                            return '<div class="btn-toolbar"> <button id="icon_edit" data-value="' + row.TypeCode + '" class="btn btn-warning editData"> <i class="fa fa-pencil"> </i>  </button>' +
                                '<button id="icon_delete"  data-value="' + row.TypeCode + '"  class="btn btn-danger deleteData"> <i class="fa fa-close "> </i>   </button> ' +
                                '<button id="icon_addmodule" data-id="' + row.TypeDesc + '"  data-value="' + row.TypeCode + '"  class="btn btn-info addModule"> <i class="fa fa-cogs "> </i>   </button> </div>';
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

    var publiCode;

    $.fn.dataTable.ext.buttons.add_new = {
        text: 'Add New',
        action: function(e, dt, node, config) {
            populateModal();
        },
        className: "btn btn-success btn-sm customBtn_by"
    };
    if (resultOfAccess.insert == 1) {
        myDatatable.button().add(0, {
            text: 'Add New',
            action: function(e, dt, node, config) {
                populateModal();
            },
            className: "btn btn-success btn-sm customBtn_by"
        });
    }

    myDatatable.on('draw.dt', function() {
        $(".editData").hide();
        $(".deleteData").hide();
        $(".addModule").hide();
        if (resultOfAccess.edit == 1) {
            $(".editData").show();
        }
        if (resultOfAccess.delete == 1) {
            $(".deleteData").show();
        }

        if(resultOfAccess.access_edit == 1){
            $(".addModule").show();
        }

    });

    function populateModal() {
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>Usertype/generateNextNo",
            success: function(datas) {
                var data = $.parseJSON(datas);
                $(".typecode").val(data);
            }
        });
        $("#compose-modal").modal("show");
    }

    $(document).on("click", "#saveData", function() {
        var typecode = $(".typecode").val();
        var typedesc = $(".typedesc").val();
        var request = $.ajax({
            type: "POST",
            url: "<?=base_url();?>Usertype/savedata",
            data: {
                typecode: typecode,
                typedesc: typedesc
            }
        });
        request.done(function(msg) {
            var data = $.parseJSON(msg);
            if (data.Status == false) {
                buildFalse(data);
            } else {
                $("#myForm")[0].reset();
                $("#compose-modal").modal("toggle");
                myDatatable.ajax.reload();
            }
        });
        request.fail(function(jqXHR, textStatus) {
            buildFalse("Please try again later");
        });
    });

    function buildFalse(data) {
        $(".forMessage").html('<div class="alert alert-danger text-center">' + data.Message + '</div>');
    }

    $('#compose-modal').on('hidden.bs.modal', function() {
        $("#myForm")[0].reset();
        $("#editForm")[0].reset();
    });

    $('#edit-modal').on('hidden.bs.modal', function() {
        $("#editForm")[0].reset();
        $("#myForm")[0].reset();
    });


    $(document).on("click", '.editData', function() {
        var typecode = $(this).data("value");
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>Usertype/getSingle",
            data: {
                typecode: typecode
            },
            success: function(datas) {
                var data = $.parseJSON(datas);
                $(".typecode").val(data.TypeCode);
                $(".typedesc").val(data.TypeDesc);
            }
        });
        $("#edit-modal").modal("show");
    });

    $("#updateData").click(function() {
        var typecode = $("#editForm .typecode").val();
        var typedesc = $("#editForm .typedesc").val();

        var request = $.ajax({
            type: "POST",
            url: "<?=base_url();?>Usertype/updateData",
            data: {
                typecode: typecode,
                typedesc: typedesc
            }
        });

        request.done(function(msg) {
            var data = $.parseJSON(msg);
            if (data.Status == false) {
                buildFalse(data);
            } else {
                $("#editForm")[0].reset();
                $("#edit-modal").modal("toggle");
                myDatatable.ajax.reload();
            }
        });
        request.fail(function(jqXHR, textStatus) {
            buildFalse("Please try again later");
        });
    });

    $(document).on("click", ".deleteData", function() {
        var value = $(this).data("value");
        publiCode = value;
        $("#compose-modalDelete").modal("show");
    });

    $("#deleteConfirm").click(function() {
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>Usertype/deletedata",
            data: {
                typecode: publiCode
            }
        });

        $("#compose-modalDelete").modal("toggle");
        myDatatable.ajax.reload();
    });

    $(document).on("click", ".addModule", function() {
        var value = $(this).data("value");
        var desc = $(this).data("id");
        publiCode = value;
        $.redirect('<?=base_url();?>Usertype/edit/'+value);

    });
});

</script>
