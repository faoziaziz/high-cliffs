<?php

	Class All_Transaction extends CI_Controller{

		function __construct(){
			parent::__construct();
			//$this->load->library('SSP');
			
			$this->load->model('Model_All_Transaction');
			check_session();
		}

		function index(){
			  
			$this->template->load('template','Transaction/list_all');
		}

		 public function ajax_list()
	    {
	        $list = $this->Model_All_Transaction->get_datatables();
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $r) {
	            $total = $r->total;
	            $amount = $r->Nilai;
	            $t;
	            $a;
	            if($total==null OR $amount==null){
	                $t='null';
	                $a='null';
	            }
	            else{
	                $t = "Rp. " .number_format($total,0,',','.');
	                $a = "Rp. " .number_format($amount,0,',','.');
	            }
	           // $t = number_format($total,0,',','.');
	            $no++;
	          
	            $row = array();
	              
	            $row[] = $no;
	            $row[] = $r->FileTime;
	            $row[] = $r->DeviceId;
	            $row[] = $r->CompanyName;
	            $row[] = $r->Nomor;
	            $row[] = $a;
	            $row[] = $r->Pajak;
	             $row[] = $t;
	             $row[] = $r->CustomField1;
	             $row[] = $r->CustomField2;
	             $row[] = $r->CustomField3;
	            $data[] = $row;
	        }
	 
	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->Model_All_Transaction->count_all(),
	                        "recordsFiltered" => $this->Model_All_Transaction->count_filtered(),
	                        "data" => $data,
	                );
	        //output to json format
	        echo json_encode($output);
	    }
					
	}

