    </section>
  </div>
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      Anything you want
    </div>
    <strong>Copyright &copy; 2016 <a href="#">Company</a>.</strong> All rights reserved.
  </footer>
</div>

<script src="<?=base_url();?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?=base_url();?>assets/jquery.redirect.js"></script>
<script src="<?=base_url();?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?=base_url();?>assets/dist/js/adminlte.min.js"></script>
<script src="<?=base_url();?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url();?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>

<?php 
	if(isset($js)){
		$this->load->view($js);
	}
?>

<script>
    $(document).ready(function(){
      
      var child_li_active =  $("ul.treeview-menu li.active");
      
      child_li_active.closest("ul").closest("li").addClass("active");

    });
</script>


</body>
</html>