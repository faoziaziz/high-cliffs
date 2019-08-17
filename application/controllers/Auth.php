<?php

	class Auth extends CI_Controller{

		function __construct(){
			parent::__construct();
			$this->load->model('Model_User');
			
		}

		function login(){
			if(isset($_POST['submit'])){
				$username1 	= $this->input->post('txt_user');
				$pass1 		= $this->input->post('txt_pass');
				$result 	= $this->Model_User->checklogin($username1,$pass1);
				
				if(!empty($result)){
					/*
					//
					 $session = array(
	                    'nama_lengkap'  =>  $result['nama_lengkap'],
	                    'id_level_user' =>  $result['role'],
	                    'id'       =>  $result['id']);
	                    */
					$this->session->set_userdata($result);
					
					redirect('dashboard');
					
				}
				else{
					redirect('dashboard');
				}

			}else{
				
				$this->load->view('form_login');
			}
		}

	

		function login1(){
			if(isset($_POST['submit'])){
				$username1 = $this->input->post('txt_user');
				$pass1 = $this->input->post('txt_pass');
				if($username1=='admin' && $pass1=='admin'){
					$data_session = array(
						'nama' => $username,
						'stats' => "login_gto"
						);
					$this->session->set_userdata($data_session);
					redirect('dashboard');
				}
				else{
					redirect('auth/login');
				}
			}
			else{
				check_session_login();
				$this->load->view('form_login');
			}
		}

		function logout(){
			$this->session->sess_destroy();
			redirect('auth/login');
		}
	}

