	$(document).ready(function(){
 		populateDatatable();
	});


	function populateDatatable(){
		$('#example1').DataTable({
			"processing": true,
        	"ajax": {
		       "url": '../module/lists',
		       "dataSrc": ""
		    },
        	"columns": [
	            { "data": "ModuleCode" },
	            { "data": "ModuleName" },
	            { "data": "ModulePath" },
	            { "data": "ModuleParent" }
	        ]
   		 });
	}