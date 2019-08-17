<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ft2 extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('ssp');
		//$this->load->model('Model_Ft2');

	}
	public function index()
	{
		//$this->load->view('welcome_message');
		$this->template->load('template','ft2/list');
	}

	function data(){
		//nama table
		$table = 'view_cek_capture';
		// nama pk
			$primaryKey='DeviceId';
		//list table
		$columns = array(
		
			
			array('db'=>'InsertTimeStamp','dt'=>'InsertTimeStamp'),
			array('db'=>'DeviceId','dt'=>'DeviceId'),
			array('db'=>'CompanyName','dt'=>'CompanyName'),
			
		
			
			);

		$sql_details=array(
			'user'=>$this->db->username,
			'pass' => $this->db->password,
			'db' => $this->db->database,
			'host' => $this->db->hostname
			);

		 echo json_encode(
                SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
        );
	}
}