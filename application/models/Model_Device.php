<?php

	Class Model_Device extends CI_Model{
		public $table ="DeviceTable";

		function save1(){
			$data = array(
				'DeviceId'	=> $this->input->post('txt_device',TRUE),
				'CompanyName' => $this->input->post('txt_tenant',TRUE),
				'Address' => $this->input->post('txt_alamat',TRUE),
				'PhoneNumber' => $this->input->post('txt_telp',TRUE)


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
		        $this->db->where('DeviceId',$id);
		        $query = $this->db->get();
		 
		        return $query->row();
		    }

		    public function delete($id){
		    	$this->db->where('DeviceId',$id);
		    	$this->db->delete($this->table);
		    }
		 public function update_tenant($where,$data){
		 	$this->db->update("Tenant", $data, $where);
		 	return $this->db->affected_rows();
		 }

	}
