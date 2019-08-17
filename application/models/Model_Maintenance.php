<?php

class Model_Maintenance extends CI_Model{
		public $table ="Maintenance";
		public $table2="view_maintenance";
		var $column_order = array(null, 'tanggal','jam','DeviceId','Tenant','Masalah','Tindakan','Status','nama_lengkap'); //set column field database for datatable orderable
		var $column_search = array('tanggal','jam','DeviceId','Tenant','Masalah','Tindakan','Status','nama_lengkap');//set column field database for datatable searchable
		var $order = array('tanggal' => 'DESC'); // defau
		function __construct(){
			parent::__construct();
		}
		function save($data){
				$this->db->insert($this->table,$data);
				return $this->db->insert_id();
		}


		 private function _get_datatables_query()
	    {
	    
	    	$jenis = $this->input->post('txtjenis');
	     	$dev = 	$this->input->post('DeviceId');
	    	$dt1 = $this->input->post('txtdt1');
	    	$dt2 = $this->input->post('txtdt2');
	    
	    	if ($this->input->post('DeviceId')=='all')
	    	{

	    	}
	    	
	    	else if ($this->input->post('DeviceId')<>'all')
	    	{
	    		
		    $this->db->where('DeviceId', $this->input->post('DeviceId'));

	    	}
	    	
	        
	    	
	        if($this->input->post('txtJenis')=='1'){
	        	 /*if($this->input->post('txtdt1'))
			        {
			            $this->db->where("FileTime>=", $this->input->post('txtdt1'));
			        }
			          if($this->input->post('txtdt2'))
			        {
			            $this->db->where("FileTime<=", $this->input->post('txtdt2'));
			        }
			        */
			        $this->db->where("date(tanggal) Between date('$dt1') and date('$dt2')");
	        }
	        if($this->input->post('txtJenis')=='0'){
	        	 if($this->input->post('txtdt1'))
			        {
			             $this->db->where("DATE_FORMAT(tanggal,'%Y-%m')>=", $this->input->post('txtdt1'));
			        }
			          if($this->input->post('txtdt2'))
			        {
			            $this->db->where("DATE_FORMAT(tanggal,'%Y-%m')<=", $this->input->post('txtdt2'));
			        }
	        }

	    
	     $this->db->from($this->table2);
					//$this->db->query($sql);
	        $i = 0;
	     
	        foreach ($this->column_search as $item) // loop column 
	        {
	            if($_POST['search']['value']) // if datatable send POST for search
	            {
	                 
	                if($i===0) // first loop
	                {
	                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
	                    $this->db->like($item, $_POST['search']['value']);
	                }
	                else
	                {
	                    $this->db->or_like($item, $_POST['search']['value']);
	                }
	 
	                if(count($this->column_search) - 1 == $i) //last loop
	                    $this->db->group_end(); //close bracket
	            }
	            $i++;
	        }
	         
	        if(isset($_POST['order'])) // here order processing
	        {
	            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
	        } 
	        else if(isset($this->order))
	        {
	            $order = $this->order;
	            $this->db->order_by(key($order), $order[key($order)]);
	        }
	    }
		 public function get_datatables()
		    {
		        $this->_get_datatables_query();
		        if($_POST['length'] != -1)
		        $this->db->limit($_POST['length'], $_POST['start']);
		        $query = $this->db->get();
		        return $query->result();
		    }
		 
		    public function count_filtered()
		    {
		        $this->_get_datatables_query();
		        $query = $this->db->get();
		        return $query->num_rows();
		    }
		 
		    public function count_all()
		    {
		        $this->db->from($this->table2);
		        return $this->db->count_all_results();
		    }

		    public function get_list_countries()
		    {
		        $this->db->select('DeviceId');
		        $this->db->from('DataWP');
		        $this->db->order_by('DeviceId','asc');
		        $query = $this->db->get();
		        $result = $query->result();
		 
		        $DeviceId = array();
		        foreach ($result as $row) 
		        {
		            $DeviceId[] = $row->DeviceId;
		        }
		        return $DeviceId;
		    }
}