<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Devices extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('ssp');
		$this->load->model('Model_Devices');
		check_session();

	}
	public function index()
	{
		//$this->load->view('welcome_message');
		$this->template->load('template','Devices/list');
	}

	function data(){
		//nama table
		$table = 'DataWP';
		// nama pk
		$primaryKey='DeviceId';
		//list table
		$columns = array(			
			array('db'=>'DeviceId','dt'=>'DeviceId'),
			array('db'=>'CompanyName','dt'=>'CompanyName'),
			array('db'=>'Address','dt'=>'Address'),
			array('db'=>'PhoneNumber','dt'=>'PhoneNumber'),
			array(
				'db'=>'DeviceId',
				'dt'=>'aksi',
				'formatter'=>function ($d){
					//return "<a href='edit.php?id=$d'>EDIT</a>";
					return '<a class="btn btn-xs btn-primary tooltips" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$d."'".')"><i class="glyphicon glyphicon-pencil"></i></a> <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$d."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
				}

				)
			
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

	
	function add(){
	
			$data = array(
				'DeviceId'	=> $this->input->post('DeviceId',TRUE),
				'CompanyName' => $this->input->post('CompanyName',TRUE),
				'Address' => $this->input->post('Address',TRUE),
				'PhoneNumber' =>	 $this->input->post('PhoneNumber')


				);
			$this->Model_Devices->save($data);
			echo json_encode(array("status" =>true));

		
	}

	 public function ajax_edit($id)
    {
        $data = $this->Model_Devices->get_by_id($id);
     
        echo json_encode($data);
    }
 

	public function ajax_update()
    {
      
     	 $data = array(
				'DeviceId'	=> $this->input->post('DeviceId',TRUE),
				'CompanyName' => $this->input->post('CompanyName',TRUE),
				'Address' => $this->input->post('Address',TRUE),
				'PhoneNumber' =>	 $this->input->post('PhoneNumber')


				);
   
        $this->Model_Devices->update(array('DeviceId' => $this->input->post('DeviceId')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function delete($id){
    	$this->Model_Devices->delete($id);
    	 echo json_encode(array("status" => TRUE));
    }
}
