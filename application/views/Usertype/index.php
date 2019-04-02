<div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Modules</h3>
              <div class="box-body">
              		 <table id="example1" class="table table-bordered table-striped table-striped table-hover table-responsive"> 
              		 	<thead>
              		 		<tr>
              		 			<th> Type Code </th>
              		 			<th> Type Desc </th>
		              		    <th> Action </th>
              		 		</tr>
              		 	</thead>
              		 </table>
              </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Add new record
                </h4>
            </div>
            
            <div class="modal-body">
                
                <form id="myForm" class="form-horizontal" role="form">

                <div class="form-group forMessage"  id="">
                  
                </div>

                  <div class="form-group">
                    <label  class="col-sm-2 control-label"
                              for="inputEmail3">Code</label>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control typecode" 
                			placeholder="Type Code"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"
                          for="inputPassword3" >Description</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control typedesc"
                            placeholder="Type Description"/>
                    </div>
                  </div>


                </form>
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                            Close
                </button>
                <button type="button" id="saveData" class="btn btn-primary">
                    Save
                </button>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Edit Record
                </h4>
            </div>
            
            <div class="modal-body">
                
                <form id="editForm" class="form-horizontal" role="form">

                <div class="form-group forMessage"  id="">
                  
                </div>

                  <div class="form-group">
                    <label  class="col-sm-2 control-label"
                              for="inputEmail3">Code</label>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control typecode" 
                			placeholder="Type Code"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"
                          for="inputPassword3" >Description</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control typedesc"
                            placeholder="Type Description"/>
                    </div>
                  </div>


                </form>
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                            Close
                </button>
                <button type="button" id="updateData" class="btn btn-primary">
                    Save
                </button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="compose-modalDelete" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
             
            </div>
            
            <div class="modal-body text-center">
         
            Are you sure ?       
         
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">  Cancel
                </button>
                <button type="button" id="deleteConfirm" class="btn btn-danger">
                    Delete
                </button>
            </div>

        </div>
    </div>
</div>

