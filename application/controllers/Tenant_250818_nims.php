<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tenant extends CI_Controller {


	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct(){
			parent::__construct();
			$this->load->library('ssp');
			$this->load->model('Model_Tenant');
			check_session();
	}

	public function index()
	{
		
		//$this->load->view('template');
		$this->template->load('template','Tenant/list');
	}

	function data(){
		//nama table
		$table = 'Tenant';
		// nama pk
			$primaryKey='DeviceId';
		//list table
		$columns = array(
		
			
			
				array('db'=>'Tenant','dt'=>'Tenant'),
			array('db'=>'Location','dt'=>'Location'),
			array('db'=>'PIC','dt'=>'PIC'),
			array('db'=>'PhoneNumber','dt'=>'PhoneNumber'),
		
			array(
				'db'=>'id',
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
				'Tenant'	=> $this->input->post('txtTenant',TRUE),
				'Location' => $this->input->post('txtLocation',TRUE),
				'PIC' => $this->input->post('txtPIC',TRUE),
				'PhoneNumber' =>	 $this->input->post('txtPhoneNumber'),
				'MerkTypePOS' => $this->input->post('txtPOS',TRUE),
				'MerkTypePrinter' =>	 $this->input->post('txtPrinter'),
				'Cable' =>	 $this->input->post('txtCable'),
				'TextImage' => $this->input->post('txtJenis',TRUE),
				'Lat' =>	 $this->input->post('txtLat'),
				
				'Long' => $this->input->post('txtLong',TRUE)
				);
			$this->Model_Tenant->save($data);
			echo json_encode(array("status" =>true));

		
	}

	 public function ajax_edit($id)
    {
        $data = $this->Model_Tenant->get_by_id($id);
     
        echo json_encode($data);
    }
 

	public function ajax_update()
    {
      
     $data = array(
				'Tenant'	=> $this->input->post('txtTenant',TRUE),
				'Location' => $this->input->post('txtLocation',TRUE),
				'PIC' => $this->input->post('txtPIC',TRUE),
				'PhoneNumber' =>	 $this->input->post('txtPhoneNumber'),
				'Lat' =>	 $this->input->post('txtLat'),			
				'Long' => $this->input->post('txtLong',TRUE),
				'MerkTypePOS' => $this->input->post('txtPOS',TRUE),
				'Cable' =>	 $this->input->post('txtCable'),
				'MerkTypePrinter' =>	 $this->input->post('txtPrinter')

				);
   
        $this->Model_Tenant->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function delete($id){
    	$this->Model_Tenant->delete($id);
    	 echo json_encode(array("status" => TRUE));
    }

}
