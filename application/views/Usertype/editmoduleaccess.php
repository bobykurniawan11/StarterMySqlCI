<div class="row">
<div class="col-md-12">
   <div class="box">
      <div class="box-header with-border">
         <h3 class="box-title">Edit Acceess <?=$typecode;?> </h3>
      </div>
      <div class="box-body">
         <div class="col-md-5">
            <div class="box-header">
               <h3> Add Module </h3>
            </div>
            <div class="box-body">
               <form id="myForm" class="form-horizontal" method="POST" action="<?=base_url();?>Usertype/saveaccess/<?=$typecode;?>" role="form">
                  <div class="form-group">
                     <label class="col-sm-2 control-label"
                        for="inputPassword3"> Module </label>
                     <div class="col-sm-10">
                        <select name="ModuleCode" id="module" class="form-control">
                           <option value=""> --- </option>
                           <?php foreach ($listmodule as $key ) { ?>
                           <option value="<?=$key->ModuleCode;?>"> <?=$key->ModuleName;?> </option>
                           <?php } ?>
                        </select>
                     </div>
                  </div>
                  <div class="form-group">
                     <button class="pull-right btn btn-info" style="margin-right: 14px"> Save </button>
                  </div>
               </form>
            </div>
         </div>
         <div class="col-md-6">
            <div class="box-header">
               <h3>  </h3>
            </div>
            <div class="box-body">
                <form action="<?=base_url();?>Usertype/updateaccess/<?=$typecode;?>" method="POST">
                   <table class="table table-responsive">
                      <thead>
                         <tr>
                            <th> Module Name </th>
                            <th> Insert </th>
                            <th> Edit </th>
                            <th> Delete </th>
                            <th> Access_edit </th>
                            <th> Delete </th>
                         </tr>
                      </thead>
                      <tbody>
                         <?php foreach ($ownedModule as $key) { ?>
                         <input type="hidden" value="<?=$key->ModuleCode;?>" name="ModuleCode[]">
                         <tr>
                            <td><?=$key->ModuleName;?></td>
                            <td>
                               <?php 
                                  $checked ="";
                                  if($key->insert == 1 ){
                                      $checked = "checked";
                                  }
                                  ?>
                                <input <?=$checked;?> name="<?=$key->ModuleCode;?>[insert]"  type="checkbox"/>
                            </td>
                            <td>
                               <?php 
                                  $checked ="";
                                  if($key->edit == 1 ){
                                      $checked = "checked";
                                  }
                                  ?>
                               <input <?=$checked;?> name="<?=$key->ModuleCode;?>[edit]" type="checkbox"/>
                            </td>
                            <td>
                               <?php 
                                  $checked ="";
                                  if($key->delete == 1 ){
                                      $checked = "checked";
                                  }
                                  ?>
                               <input <?=$checked;?> name="<?=$key->ModuleCode;?>[delete]" type="checkbox"/>
                            </td>
                            <td>
                               <?php 
                                  $checked ="";
                                  if($key->access_edit == 1 ){
                                      $checked = "checked";
                                  }
                                  ?>
                               <input <?=$checked;?> name="<?=$key->ModuleCode;?>[access_edit]" type="checkbox"/>
                            </td>
                            <td> <a href="<?=base_url();?>Usertype/deleteaccess/<?=$typecode;?>/<?=$key->ModuleCode;?>"> Delete </a> </td>
                         </tr>
                         <?php } ?>
                      </tbody>
                   </table>

                        <div class="form-group">
                         <button class="pull-right btn btn-info" style="margin-right: 14px"> Update Access </button>
                      </div>
                
                </form>
            </div>
         </div>
      </div>
   </div>
</div>