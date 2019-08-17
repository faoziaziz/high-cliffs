<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends CI_Controller{

		function __construct(){
			parent::__construct();
			$this->load->library('ssp');
			$this->load->model('Model_Maintenance');
		   
		    check_session();
		}

		public function index(){
			$this->template->load('template','Maintenance/list');
		}

		public function search(){

			$keyword = $this->uri->segment(3);
			$data = $this->db->from('Tenant')->like('DeviceId',$keyword)->get();
			foreach($data->result() as $row){
				$arr['query'] = $keyword;
				$arr['suggestions'][]=array(
						'value' => $row->DeviceId,
						'Tenant' => $row->Tenant

					);
			}
			echo json_encode($arr);
		}

		function add(){
				$now = date('Y-m-d H:i:s');
				$jam = date('H:i:s');
				$idUser = $this->session->userdata('id');
				$data = array(
					'Date'	=> $this->input->post('txtTanggal'). " " . $jam,
					'DeviceId' => $this->input->post('txtDeviceId'),
					'Masalah' => $this->input->post('txtMasalah'),
					'Tindakan' => $this->input->post('txtTindakan'),
					'Status' => $this->input->post('txtStatus'),
					'IDUser' => $idUser,
					
				);

				

					$insert = $this->Model_Maintenance->save($data);

					echo json_encode(array("status" => TRUE));
					
		}

		 public function Ajax_list()
	    {
	        $list = $this->Model_Maintenance->get_datatables();
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $r) {
	          
	               // $t = number_format($total,0,',','.');
	                $no++;
	            $row = array();
	              
	             $row[] = $no;
	                $row[] = $r->tanggal;
	                $row[] = $r->jam;
	                $row[] = $r->DeviceId;
	                $row[] = $r->Tenant;
	                $row[] = $r->Masalah;
	                $row[] = $r->Tindakan;
	                 $row[] = $r->Status;
	                 
	                $data[] = $row;
	        }
	 
	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->Model_Maintenance->count_all(),
	                        "recordsFiltered" => $this->Model_Maintenance->count_filtered(),
	                        "data" => $data,
	                );
	        //output to json format
	        echo json_encode($output);
	    }

}