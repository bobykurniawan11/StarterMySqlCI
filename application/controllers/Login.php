<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {


	function __construct()
    {
		parent::__construct();		
	}


	public function index()
	{
		if($this->loginChecker())
		{
			redirect("welcome","refresh");
		}
		$this->load->view("login");
	}

	function goLogin(){
		
		$username = $this->input->post("username");
		$password = $this->input->post("password");
		$cekUsername = $this->mainmodel->checkExist("users",array("username" => $username) );
		if($cekUsername < 1){
			$this->session->set_flashdata('msg', 'Username tidak terdaftar');
			redirect("Login","refresh");
			die();
		}

		$checkActive = $this->mainmodel->checkExist("users", array ("username" => $username, "password" => md5($password) , "flag" => 1));

		if($checkActive < 1){
			$this->session->set_flashdata('msg', 'Akun anda tidak aktif');
			redirect("Login","refresh");
			die();
		}

		$loginCheck = $this->mainmodel->checkExist("users", array ("username" => $username, "password" => md5($password)));
		if($loginCheck < 1){
			$this->session->set_flashdata('msg', 'Kombinasi email dan password salah');
			redirect("Login","refresh");
			die();
		}

		$datauser = $this->mainmodel->getRow("users", array("username" => $username) );
		$this->generateSession($username,$datauser->type,$datauser->userid);
		$this->updateLogindate($username);
		redirect("Welcome","refresh");

	}

	function logout(){
		$array_items = array('username', 'user_type','userid');
		$this->session->unset_userdata($array_items);
			redirect("login","refresh");
	}
	function updateLogindate($username){
		$dt 	= new DateTime("now", new DateTimeZone('Asia/Jakarta'));
		$now 	= $dt->format('m/d/Y H:i:s');

		$date 		= date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $now)));
		$update 	= array("lastlogin" => $date);
		$kondisi	= array("username" => $username);
		$table		= "users";

		$this->mainmodel->updateRow($kondisi,$table,$update);
	}

	

}