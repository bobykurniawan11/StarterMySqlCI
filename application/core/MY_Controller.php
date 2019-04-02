<?php
class MY_Controller extends CI_Controller
{
    function __construct()
    {
		parent::__construct();	
	}

	function populateView($data){
		$this->load->view("main_view",$data);
	}
	
	function loginChecker(){
		if(isset($_SESSION['username'])){
			if($_SESSION['username'] != ""){
				return true;
			}
			return false;
		}
		return false;
	}


	function generateSession($username,$tipe,$userid){
		$newdata = array(
	        'username'  => $username,
	        'user_type' => $tipe,
	        'userid'	=> $userid
		);

		$this->session->set_userdata($newdata);
	}

	function populateMenu(){
		$urlActive = $this->uri->segment(1);

		echo '<li class="header">MAIN NAVIGATION</li>';
		$usertype 							= $this->session->userdata('user_type');
		$parentModule						= $this->db->query("Select a.ModuleCode,a.ModuleName from Modules a 
																left join user_modules b on a.ModuleCode = b.ModuleCode where b.usertype = '".$usertype."' and ModuleParent = '' 
																order by a.ModuleName asc ")->result();
		foreach ($parentModule as $key) {
			$child[$key->ModuleCode]		=  $this->db->query("Select a.ModuleCode,a.ModuleName,a.ModulePath from Modules a 
																 left join user_modules b on a.ModuleCode = b.ModuleCode 
																 where b.usertype = '".$usertype."' and ModuleParent = '".$key->ModuleCode."'  order by a.ModuleName asc ")->result();
			$totalchild = count($child[$key->ModuleCode]);


			

			if($totalchild > 0) {
				echo '
				<li class="treeview">
					<a href="#"><i class="fa fa-link"></i> <span>'.$key->ModuleName.'</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
						</a>
					<ul class="treeview-menu">';
						foreach ($child[$key->ModuleCode] as $theChild) {

							if(strtolower($theChild->ModulePath) == strtolower($urlActive) ){
								$isActive ='class="active" ';
							}else{
								$isActive = "";
							}


							echo '<li '.$isActive.'><a href="'.base_url().$theChild->ModulePath.'">'.$theChild->ModuleName.'</a></li>';
						}
					echo '</ul></li>';

			}else{

				echo '
				 <li>
		          <a href="#"><i class="fa fa-link"></i> <span>'.$key->ModuleName.'</span></a>
		        </li>';

			}

		}
		echo '
				 <li>
		          <a href="'.base_url().'login/logout"><i class="fa fa-link"></i> <span> Logout </span></a>
		        </li>';

	}





}	