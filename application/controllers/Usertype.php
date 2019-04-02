<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usertype extends MY_Controller {

	function __construct()
    {
		parent::__construct();
		if(!$this->loginChecker())
		{
			$this->session->set_flashdata('msg', 'Harap login terlebih dahulu');
			redirect("login","refresh");
		}
	}

	function index(){
		$data['view'] 		= "Usertype/index";
		$data['js']			= "Usertype/Usertype_js";
		$this->populateView($data);
	}

	function lists(){
		$data = $this->db->query("SELECT * FROM user_types order by TypeCode asc")->result();
		echo json_encode($data);
	}

	function generateNextNo(){
			$data = $this->db->query("SELECT max(TypeCode)TypeCode FROM user_types order by TypeCode asc")->row();
			echo json_encode(++$data->TypeCode);
	}

	function savedata(){
		$typecode = $this->input->post("typecode");
		$typedesc = $this->input->post("typedesc");

		$save = $this->db->query("INSERT INTO user_types values ('".$typecode."','".$typedesc."') ");
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
		$typecode =  $this->input->post("typecode");
		$data = $this->db->query("SELECT * FROM user_types where typecode = '".$typecode."' ")->row();
		echo json_encode($data);
	}

	function updatedata(){
		$typecode =  $this->input->post("typecode");
		$typedesc = $this->input->post("typedesc");

		$updata  = $this->db->query("Update user_types set TypeDesc = '".$typedesc."' where typecode = '".$typecode."' ");
		if($updata){
			$msg = array ("Status" => true, "Message" => ""); 
			echo json_encode($msg);
			return;
		}
			$msg = array ("Status" => false, "Message" => "Something Wrong, please try again later"); 
			echo json_encode($msg);
			return;
	}

	function deletedata(){
		$typecode = $this->input->post("typecode");
		$this->db->query("DELETE FROM user_types where TypeCode = '".$typecode."' ");
	}

	function edit($type){
		$data['view'] 			= "Usertype/editmoduleaccess";
		$data['js']				= "Usertype/Usertype_js";
		$data['typecode']   	= $type;
	

		$data['listmodule']		= $this->db->query("SELECT * FROM modules where ModuleCode not in ( select ModuleCode from user_modules where usertype = '".$data['typecode']."' ) ")->result();
		$data['ownedModule']	= $this->db->query("SELECT a.*,b.insert,b.delete,b.edit,b.access_edit from modules a 
													inner join user_modules b on a.ModuleCode = b.ModuleCode where usertype = '".$data['typecode']."' order by a.ModuleCode ")->result();
		$this->populateView($data);
	}

	function checkAccessCRUD(){
		$user_type = $this->session->userdata('user_type');
		$datacheckAccessInsert = $this->db->query("SELECT * FROM user_modules where usertype = '".$user_type."' and ModuleCode = 'MD005' ")->row();
		echo json_encode($datacheckAccessInsert);
	}

	function updateaccess(){
		$dataModul = $this->input->post('ModuleCode');
		$field = array ("insert","edit","delete","access_edit");
		for($x=0;$x<count($dataModul);$x++){
				for($a=0;$a<count($field);$a++){
					$subcheck[$a] = (isset($this->input->post($dataModul[$x])[$field[$a]])) ? 1 : 0;
					$mynewarray[$dataModul[$x]][] = array($field[$a] => $subcheck[$a]);
				}
			foreach ($mynewarray as $key => $value) {
					  $forSave[$dataModul[$x]] = $this->custom_function($value);
			}
		}
		foreach ($forSave as $key2 => $values2) {
				$this->mainmodel->updateRow(array("ModuleCode" => $key2),"user_modules", $values2 );
		}
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function saveaccess($typecode){
			$ModuleCode = $this->input->post("ModuleCode");
			$maxId = $this->db->query("SELECT MAX(um_code) um_code from user_modules  ")->row();
			$nextID = ++ $maxId->um_code;
			$this->db->query("INSERT INTO user_modules (um_code,ModuleCode,usertype) values ('".$nextID."', '".$ModuleCode."','".$typecode."') ");
			header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function deleteaccess($tipe,$ModuleCode){
		$this->db->query("delete from user_modules where ModuleCode = '".$ModuleCode."' and usertype = '".$tipe."' ");
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function custom_function($input_array)
	{
	    $output_array = array();
	    for ($i = 0; $i < count($input_array); $i++) {
	        for ($j = 0; $j < count($input_array[$i]); $j++) {
	            $output_array[key($input_array[$i])] = $input_array[$i][key($input_array[$i])];
	        }
	    }
	    return $output_array;
	}

}