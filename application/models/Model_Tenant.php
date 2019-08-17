<?php
Class Model_Tenant extends CI_Model{
	public $table ="Tenant";

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

	public function update($where, $data){
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}
	
	public function get_tenant(){
		$this->db->from($this->table);
		$this->db->order_by('Tenant', 'ASC');
		$query = $this->db->get();
		
		return $query->result();
	}
	
	public function get_by_id($id){
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();
		
		return $query->row();
	}

	public function delete($id){
		$this->db->where('id',$id);
		$this->db->delete($this->table);
	}
	
	function get_tenant_card(){
		return $this->db->get('Tenant');
	}
	
	function get_notif(){
		$this->db->from('Transaksi',5,5);
		$this->db->where('DeviceId','APS010700040');
		$this->db->order_by('FileTime','DESC');
		$query = $this->db->get();
		
		return $query->row();
	}
}
