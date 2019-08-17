<?php

	Class Model_User extends CI_Model{

		function checklogin($username,$password){
			$this->db->select('*');
            		$this->db->from('User');
            		$this->db->where('username',$username);
            		$this->db->where('password', md5($password));
            		$query = $this->db->get()->row_array();

			return $query;

			/*$this->db->where('username',$username);
			$this->db->where('password',md5($password));
			$user = $this->db->get('User')->row_array();
			return $user;*/

		}
	}


