<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

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
		$data['view'] 		= "user/index";
		$data['js']			= "user/user_js";
		$this->populateView($data);
	}

	function lists(){
		$data = $this->db->query("SELECT * FROM USERS order by Type asc")->result();
		echo json_encode($data);
	}

	function getListType(){
		$data = $this->db->query("SELECT * FROM user_types order by TypeCode asc")->result();
		echo json_encode($data);
	}
	function saveData(){
		$username  = $this->input->post("username");
		$password = $this->input->post("password");
		$type  = $this->input->post("type");

		if($username == ""){
			$msg = array ("Status" => false, "Message" => "Please Fill Username"); 
			echo json_encode($msg);
			return;
		}

		if($password == ""){
			$msg = array ("Status" => false, "Message" => "Please Fill Password"); 
			echo json_encode($msg);
			return;
		}

		if($type == ""){
			$msg = array ("Status" => false, "Message" => "Please Fill User type"); 
			echo json_encode($msg);
			return;
		}


		$checkExist = $this->mainmodel->checkExist("Users",array("username" => $username) );
		if($checkExist > 0){ 
			$msg = array ("Status" => false, "Message" => "Username is already in used"); 
			echo json_encode($msg);
			return;
		}

		$save = $this->db->query("INSERT INTO USERS values ('".$username."','".md5($password)."','".$type."', '' , 1) ");
		if($save){
			$msg = array ("Status" => true, "Message" => ""); 
			echo json_encode($msg);
			return;
		}

			$msg = array ("Status" => false, "Message" => "Something Wrong, please try again later"); 
			echo json_encode($msg);
			return;
	}

	function getSingle(){
		$username = $this->input->post("username");
		$data = $this->db->query("SELECT * FROM USERS where username = '".$username."' ")->row();
		echo json_encode($data);
	}

	function updateData(){
		$username 	= $this->input->post("username");
		$type 		= $this->input->post("type");
		$update 	= $this->db->query("update Users set type = '".$type."' where username = '".$username."' ");

		if($update) {
			$msg = array ("Status" => true, "Message" => ""); 
			echo json_encode($msg);
			return;
		}
		$msg = array ("Status" => false, "Message" => "Something wrong, please try again later"); 
		echo json_encode($msg);
		return;
	}

	function deleteUser(){
		$username = $this->input->post("username");
		$flag = $this->input->post("flag");
		if($flag == "1"){
			$this->db->query("UPDATE users set flag = 0 where username = '".$username."' ");
		}else{
			$this->db->query("UPDATE users set flag = 1 where username = '".$username."' ");
		}
	}
	function checkAccessCRUD(){
		$user_type = $this->session->userdata('user_type');
		$datacheckAccessInsert = $this->db->query("SELECT * FROM user_modules where usertype = '".$user_type."' and ModuleCode = 'MD002' ")->row();
		echo json_encode($datacheckAccessInsert);
	}

	

}