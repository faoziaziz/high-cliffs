<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Daily_Transaction extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->library('Ssp');
		$this->load->model('Model_Daily');
        check_session();
	}

	function index(){
		//$data['record'] = $this->Model_Alarm->showData()->result();
		//$this->template->load('template','Alarm/list',$data);
         $countries = $this->Model_Daily->get_list_countries();
 
        $opt = array('' => 'All');
        foreach ($countries as $DeviceId) {
            $opt[$DeviceId] = $DeviceId;
        }

      
        $data['info']= $this->Model_Daily->tenant();
 
        //$data['form_country'] = cmb_dinamis('DeviceId','DataWP','CompanyName','DeviceId', null,"id='datawp'") ;

		$this->template->load('template','Daily_transaction/list');
	}
	
    public function Ajax_list()
    {
		$list = $this->Model_Daily->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $r) {
			$total = $r->total;
			$amount = $r->Nilai;
			$tax = $r->Pajak;
			$disc = $r->CustomField2;
			$netSales = $r->CustomField3;
			$t;
			$a;
			$pajak;
			$d;
			$n;
			if($total==null || empty($total)){ $t='null'; } else{ $t = number_format($total,0,',','.'); }
			if($amount==null || empty($amount)) { $a='null'; } else{ $a = number_format($amount,0,',','.'); }
			if($tax==null || empty($tax)){ $pajak='null'; } else{ $pajak = number_format($tax,0,',','.'); }
			//if($disc==null || empty($disc) || $disc==''){ $d='null'; } else{ $d = number_format($disc,0,',','.'); }
			if($disc==null || empty($disc) || $disc==''){ $d='null'; } else{ $d = $disc; }
			if($netSales==null || empty($netSales)) { $n='null'; } else{ $n = number_format($netSales,0,',','.'); }
		   // $t = number_format($total,0,',','.');
			$no++;
            $row = array();
              
			$row[] = $no;
			$row[] = (!empty($r->Tanggal))? $r->Tanggal : $r->FileTime;
			$row[] = $r->DeviceId;
			$row[] = $r->CompanyName;
			$row[] = $r->Nomor;
			$row[] = $a;
			$row[] = $pajak;
			$row[] = $t;
			$row[] = $r->CustomField1;
			$row[] = $d;
			$row[] = $n;
			
			$data[] = $row;
        }
 
        $output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_Daily->count_all(),
			"recordsFiltered" => $this->Model_Daily->count_filtered(),
			"data" => $data,
		);
        //output to json format
        echo json_encode($output);
    }
}