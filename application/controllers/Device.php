<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Device extends CI_Controller {




	function __construct(){
			parent::__construct();
			$this->load->library('ssp');
			$this->load->model('Model_Device');
			check_session();
	}

	public function index()
	{
		
		//$this->load->view('template');
		$this->template->load('template','Devices/list');
	}

	function data(){
		//nama table
		$table = 'view_devices';
		// nama pk
			$primaryKey='DeviceId';
		//list table
		$columns = array(
			array('db'=>'DeviceId','dt'=>'DeviceId'),
			array('db'=>'SerialNumber','dt'=>'SerialNumber'),
			array('db'=>'PrivateKey','dt'=>'PrivateKey'),
			array('db'=>'Tenant','dt'=>'Tenant'),
			array(
				'db' => 'IsManual',
				'dt' => 'IsManual',
				'formatter'=> function($d){
					if($d==0){
						return 'True';
					}
					else{
						return 'False';
					}
				}
			),
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
			'DeviceId'	=> $this->input->post('txtDevice',TRUE),
			'SerialNumber' => $this->input->post('txtSerial',TRUE),
			'PrivateKey' => $this->input->post('txtPrivate',TRUE),
			'tenant' =>	 $this->input->post('tenant'),
		);
		$this->Model_Device->save($data);
		echo json_encode(array("status" =>true));
	}

	public function ajax_edit($id){
        $data = $this->Model_Device->get_by_id($id);
        echo json_encode($data);
    }
	
	public function ajax_update(){
		$data = array(
			'DeviceId'	=> $this->input->post('txtDevice',TRUE),
			'SerialNumber' => $this->input->post('txtSerial',TRUE),
			'PrivateKey' => $this->input->post('txtPrivate',TRUE),
			'tenant' =>	 $this->input->post('tenant'),
		);
   
        $this->Model_Device->update(array('DeviceId' => $this->input->post('id')), $data);
			$data_tenant = array(
      		'DeviceId' => $this->input->post('txtDevice',TRUE),
      	);
		$this->Model_Device->update_tenant(array('id'=>$this->input->post('tenant')),$data_tenant);
        echo json_encode(array("status" => TRUE));
    }

    public function delete($id){
    	$this->Model_Device->delete($id);
    	 echo json_encode(array("status" => TRUE));
    }

}
