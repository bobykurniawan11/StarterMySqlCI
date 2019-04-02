
<script>	
	$.holdReady(true);
	var moduleAllow = null;
	var myDatatable;
	$(window).on('load', function() {

	    $.ajax({
	        type: "POST",
	        url: "<?=base_url();?>module/checkAccessCRUD",
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
	                    "url": '<?=base_url();?>/module/lists',
	                    "dataSrc": ""
	                },
	                "columns": [{
	                        "data": "ModuleCode"
	                    },
	                   
	                    {
	                        "data": "ModulePath"
	                    },
	                    {
	                        "data": "ModuleParent"
	                    },

	                    {

	                        "mData": "Name",
	                        "mRender": function(data, type, row) {
	                            return '<div  class="btn-toolbar"> <button id = "icon_edit"  data-value="' + row.ModuleCode + '" class="btn btn-warning editData"> <i class="fa fa-pencil"> </i>  </button>' +
	                                '<button id="icon_delete" data-value="' + row.ModuleCode + '"  class="btn btn-danger deleteData"> <i  class="fa fa-close "> </i>   </button> </div>';
	                        }
	                    }

	                ],
	                buttons: [
	                    'refresh'
	                ],
	            });


	            $.holdReady(false);
	        },
	    });
	});

	$(document).ready(function() {
	    console.log(moduleAllow);
	    var resultOfAccess = $.parseJSON(moduleAllow);

	    var moduleCodeValue;
	    var moduleCodeField = $("#moduleCode");
	    var moduleNameField = $("#moduleName");
	    var moduleParentField = $("#moduleParent");
	    var modulePathField = $("#modulePath");

	    var ModuleCodeEditField = $("#moduleCode_edit");
	    var ModuleNameEditField = $("#moduleName_edit");
	    var ModulePathEditField = $("#modulePath_edit");
	    var ModuleParentEditField = $("#moduleParent_edit");

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



	    $("#saveData").click(function() {
	        saveData();
	    });

	    $("#compose-modal").on('shown.bs.modal', function() {
	        generateSelectparent();
	        populateNextCode();
	    });

	    $('#compose-modal').on('hidden.bs.modal', function() {
	        $("#myForm")[0].reset();
	    });

	    $(document).on("click", ".editData", function() {
	        var value = $(this).data("value");
	        moduleCodeValue = value;
	        populateModalEdit();
	    });

	    $(document).on("click", ".deleteData", function() {
	        var value = $(this).data("value");
	        moduleCodeValue = value;
	        $("#compose-modalDelete").modal("show");
	    });

	    $(document).on("click", "#deleteConfirm", function() {
	        deleteData();
	    });

	    function deleteData() {
	        var request = $.ajax({
	            type: "POST",
	            url: "<?=base_url();?>Module/delete",
	            data: {
	                moduleCode: moduleCodeValue
	            }
	        });

	        request.done(function(msg) {

	            if (msg.Status == false) {
	                buildFalse(msg);
	            } else {
	                $("#compose-modalDelete").modal('toggle');
	                myDatatable.ajax.reload();
	            }


	        });

	        request.fail(function(jqXHR, textStatus) {
	            alert("Request failed: " + textStatus);
	        });
	    }

	    function populateModal() {
	        $("#compose-modal").modal("show");
	    }

	    function generateSelectparent(existingData = "") {
	        var selectBox = $(".moduleParent");
	        selectBox.find('option')
	            .remove()
	            .end();
	        selectBox.append("<option value=''> --- </option>");
	        $.ajax({
	            type: "POST",
	            url: "<?=base_url();?>module/parentOnly",
	            success: function(data) {
	                var opts = $.parseJSON(data);
	                var selected;
	                $.each(opts, function(i, d) {
	                    selectBox.append('<option ' + selected + ' value="' + d.ModuleCode + '">' + d.ModuleName + '</option>');
	                });
	                selectBox.val(existingData);
	            }
	        });
	    }

	    function saveData() {
	        var moduleCode = moduleCodeField.val().replace(/(['"])/g, "\\$1");
	        var moduleName = moduleNameField.val().replace(/(['"])/g, "\\$1");
	        var moduleParent = moduleParentField.val().replace(/(['"])/g, "\\$1");
	        var modulePath = modulePathField.val().replace(/(['"])/g, "\\$1");

	        if (moduleCode == "") {
	            alert("All fields are required");
	            moduleCodeField.focus();
	            return;
	        }

	        if (moduleName == "") {
	            alert("All fields are required");
	            moduleNameField.focus();
	            return;
	        }

	        if (modulePath == "") {
	            alert("All fields are required ");
	            modulePathField.focus();
	            return;
	        }

	        var request = $.ajax({
	            type: "POST",
	            url: "<?=base_url();?>Module/save",
	            data: {
	                moduleCode: moduleCode,
	                moduleName: moduleName,
	                moduleParent: moduleParent,
	                modulePath: modulePath
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


	    function populateNextCode() {
	        $.ajax({
	            type: "POST",
	            url: "<?=base_url();?>Module/generateNextCode",
	            success: function(data) {
	                var opts = $.parseJSON(data);
	                moduleCodeField.val(opts);
	            }
	        });

	    }

	    function populateModalEdit() {
	        $("#editForm")[0].reset();
	        $("#edit-modal").modal('toggle');

	        $.ajax({
	            type: "POST",
	            url: "<?=base_url();?>Module/generateSingle",
	            data: {
	                moduleCode: moduleCodeValue
	            },
	            success: function(data) {
	                var opts = $.parseJSON(data);
	                ModuleCodeEditField.val(opts.ModuleCode);
	                ModuleNameEditField.val(opts.ModuleName);
	                ModulePathEditField.val(opts.ModulePath);
	                generateSelectparent(opts.ModuleParent);
	            }
	        });
	    }


	    $("#updateData").click(function() {
	        goEdit();
	    });

	    function goEdit() {

	        var moduleCode = ModuleCodeEditField.val();
	        var moduleName = ModuleNameEditField.val();
	        var modulePath = ModulePathEditField.val();
	        var moduleParent = ModuleParentEditField.val();

	        var request = $.ajax({
	            type: "POST",
	            url: "<?=base_url();?>Module/updateData",
	            data: {
	                moduleCode: moduleCode,
	                moduleName: moduleName,
	                moduleParent: moduleParent,
	                modulePath: modulePath
	            },
	        });

	        request.done(function(msg) {
	            var data = $.parseJSON(msg);
	            if (data.Status == false) {
	                buildFalse(data);
	            } else {
	                $("#edit-modal").modal('toggle');
	                myDatatable.ajax.reload();
	            }

	        });

	        request.fail(function(jqXHR, textStatus) {
	            alert("Request failed: " + textStatus);
	        });

	    }

	});
</script>