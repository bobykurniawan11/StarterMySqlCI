<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Module extends MY_Controller {

	function __construct()
    {
		parent::__construct();
		if(!$this->loginChecker())
		{
			$this->session->set_flashdata('msg', 'Harap login terlebih dahulu');
			redirect("login","refresh");
		}
	}

	public function index()
	{
		$data['view'] 		= "Module/index";
		$data['js']			= "module/module_js";
		$this->populateView($data);
	}

	public function lists(){
		$data				= $this->db->query("SELECT a.*, b.ModuleName ParentName FROM Modules a left join Modules b on a.ModuleParent = b.ModuleCode")->result();
		echo json_encode($data);
	}

	public function parentOnly(){

			$data				= $this->db->query("SELECT * FROM Modules where ModuleParent = '' order by ModuleName asc")->result();

		echo json_encode($data);
	}

	public function save(){
		$moduleCode 	= $this->input->post("moduleCode");
		$moduleName 	= $this->input->post("moduleName");
		$moduleParent 	= $this->input->post("moduleParent");
		$modulePath 	= $this->input->post("modulePath");


		if($moduleName == ""){
			$msg = array ("Status" => false, "Message" => "Please Fill ModuleName"); 
			echo json_encode($msg);
			return;
		}
		if($modulePath == ""){
			$msg = array ("Status" => false, "Message" => "Please Fill modulePath"); 
			echo json_encode($msg);
			return;
		}

		$checkExist = $this->mainmodel->checkExist("modules",array("ModuleCode" => $moduleCode) );
		if($checkExist > 0){ 
			$msg = array ("Status" => false, "Message" => "Module Code is already in used"); 
			echo json_encode($msg);
			return;
		}

		$checkExist = $this->mainmodel->checkExist("modules",array("ModuleName" => $moduleName) );
		if($checkExist > 0){ 
			$msg = array ("Status" => false, "Message" => "Module Name is already in used"); 
			echo json_encode($msg);
			return;
		}

		$this->db->query("Insert into Modules values ('".$moduleCode."','".$moduleName."' , '".$modulePath."' , '".$moduleParent."') ");
		$msg = array ("Status" => true, "Message" => "Saving module Success"); 
		echo json_encode($msg);
		return;

	}

	function delete(){
		$moduleCode = $this->input->post("moduleCode");
		$this->db->query("Delete from modules where modulecode = '".$moduleCode."' ");
		$this->db->query("Delete from user_modules  where modulecode = '".$moduleCode."' ");

	}

	function generateNextCode(){
		$data = $this->db->query("SELECT max(ModuleCode) ModuleCode FROM `modules` ORDER BY `ModuleCode` ASC")->row();
		echo json_encode(++ $data->ModuleCode);
	}

	function generateSingle(){
		$moduleCode = $this->input->post("moduleCode");
		$data = $this->db->query("SELECT * FROM `modules` where ModuleCode = '".$moduleCode."'")->row();
		echo json_encode($data);
	}

	function updateData(){
		$moduleCode 	= $this->input->post("moduleCode");
		$moduleName 	= $this->input->post("moduleName");
		$moduleParent 	= $this->input->post("moduleParent");
		$modulePath 	= $this->input->post("modulePath");

		$update = $this->db->query("Update modules set ModuleName = '".$moduleName."', 
									moduleParent = '".$moduleParent."', modulePath = '".$modulePath."' where ModuleCode = '".$moduleCode."' ");

		if($update)
		{

			$msg = array ("Status" => true, "Message" => "Update module Success "); 
			echo json_encode($msg);
			return;

		}else {

			$msg = array ("Status" => false, "Message" => "Failed to update. Please try again later "); 
			echo json_encode($msg);
			return;
		}
	}

	function checkAccessCRUD(){
		$user_type = $this->session->userdata('user_type');
		$datacheckAccessInsert = $this->db->query("SELECT * FROM user_modules where usertype = '".$user_type."' and ModuleCode = 'MD004' ")->row();
		echo json_encode($datacheckAccessInsert);
	}


}
