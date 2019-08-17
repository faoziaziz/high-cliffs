<?php

	Class Model_Users extends CI_Model{
		public $table ="User";

		function save1(){
			$data = array(
				'nama_lengkap'	=> $this->input->post('txtnamalengkap',TRUE),
				'username' => $this->input->post('txtusername',TRUE),
				'password' => $this->input->post('txtpassword',TRUE),
				'role' => $this->input->post('txtlevel',TRUE),
				'foto' => $foto

				);
			$this->db->insert($this->table,$data);
			
		}
		function save($data){
			$this->db->insert($this->table,$data);
			return $this->db->insert_id();
		}

		public function update($where, $data)
		    {
		    	
		        $this->db->update($this->table, $data, $where);
		        return $this->db->affected_rows();
		    }

		  public function get_by_id($id)
		    {
		        $this->db->from($this->table);
		        $this->db->where('id',$id);
		        $query = $this->db->get();
		 
		        return $query->row();
		    }

		    public function delete($id){
		    	$this->db->where('id',$id);
		    	$this->db->delete($this->table);
		    }

		    	
			function log(){
			
				$query = $this->db->get_where('view_maintenance',array('id'=>$this->session->userdata('id')),5);
				if($query->num_rows()>0){
					foreach($query->result_array() as $row){
						$data[] = $row;
					}
					$query->free_result();
				} 
				else{
					$data = null;
				}
				return $data;
			}




	}
