<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mainmodel extends CI_Model {

	function checkExist($table,$kondisi){
			$this->db->select('*')->where($kondisi);
			return $this->db->get($table)->num_rows();
	}

	function getRow($table,$kondisi){
		$this->db->select('*')->where($kondisi);
		return $this->db->get($table)->row();
	}

	function getMultipleRows($table,$kondisi){
		$this->db->select('*')->where($kondisi);
		return $this->db->get($table)->result();
	}

	function updateRow($kondisi,$table,$data){
		$this->db->where($kondisi);
		$this->db->update($table, $data); 
	}	



}