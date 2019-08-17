<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Report extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->library('ssp');
		$this->load->model('Model_Alarm');
		check_session();
	}

	function index(){
		//$data['record'] = $this->Model_Alarm->showData()->result();
		//$this->template->load('template','Alarm/list',$data);
		$this->template->load('template','Report/list');
	}
}
