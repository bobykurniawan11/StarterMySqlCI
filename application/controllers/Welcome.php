<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

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
		$data['view'] 		= "default";
		$this->populateView($data);
	}

	function get(){
		$this->populateMenu();
	}

}
