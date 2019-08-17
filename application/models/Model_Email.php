<?php

	Class Model_Email extends CI_Model{
		public $table = "Email";
		
		function save($data){
			
			$this->db->insert($this->table,$data);
			return $this->db->insert_id();
		}

		 public function delete($id){
		   	$this->db->where('Id',$id);
		    $this->db->delete($this->table);
		}

		 public function get_by_id($id){
		   	  $this->db->from($this->table);
		        $this->db->where('Id',$id);
		        $query = $this->db->get();
		 
		        return $query->row();
		}

			public function update($where, $data)
		    {
		    	
		        $this->db->update($this->table, $data, $where);
		        return $this->db->affected_rows();
		    }
	}