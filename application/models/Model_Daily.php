<?php

	Class Model_Daily extends CI_Model{

		public $table="view_transc";
		var $column_order = array(null, 'FileTime','DeviceId','CompanyName','Nilai','Pajak','total','CustomField1','CustomField2','CustomField3'); //set column field database for datatable orderable
	    var $column_search = array('FileTime','DeviceId','CompanyName','Nilai','Pajak','total','CustomField1'.'CustomField2','CustomField3');//set column field database for datatable searchable
	    var $order = array('FileTime' => 'DESC'); // default order 



		 private function _get_datatables_query(){
			$jenis = $this->input->post('txtjenis');
			//$dev = 	$this->input->post('DeviceId');
			$dev = 	$this->input->post('DeviceId');
			$dt1 = $this->input->post('txtdt1');
			$dt2 = $this->input->post('txtdt2');
			
			if ($this->input->post('DeviceId')=='all'){
				
			}
			else if ($this->input->post('DeviceId')<>'all'){
				if (  $dev=='SMT09160027' or $dev=='SMT09160030'  or $dev=='SMT09160025') {
					$this->db->where('DeviceId', $this->input->post('DeviceId'));
					$this->db->where('Nomor<>', "");
					$this->db->group_by('Nomor');
				}
				elseif($dev=='SMT09160021'){ //buns n meat
					$this->db->where('DeviceId', $this->input->post('DeviceId'));
					$this->db->where('Nomor<>', "");
					$this->db->where_in('CustomField1', array('Closed Bill','Sales Day Report'));
				}
				elseif($dev=='SMT09160022') //base2
				{
					$this->db->where('DeviceId', $this->input->post('DeviceId'));
					$this->db->where_in('CustomField1', array('Closed','END OF DAY REPORT')); 
					$this->db->where('Nomor<>', ""); 
					$this->db->group_by(array('Nomor','Total'));  	
				}
		
				elseif($dev=='SMT09160029') //fish n co
				{
					$this->db->where('DeviceId', $this->input->post('DeviceId'));
					$this->db->where_in('CustomField1', array('Bill Closed','NETT SALES'));  
					$this->db->where('Nomor<>', "");
					$this->db->group_by(array('Nomor','Total'));  			
				}
				elseif( $dev=='SMT09160023') //barrel
				{
					$this->db->where('DeviceId', $this->input->post('DeviceId'));
					$this->db->where_in('CustomField1', array('Closed','SUMMARY SALES REPORT','CASHIER SHIFT REPORT'));	 			
				}
				elseif( $dev=='SMT09160028')//chir-chir
				{
					$this->db->where('DeviceId', $this->input->post('DeviceId'));
					$this->db->where_in('CustomField1', array('Closed','SUMMARY SALES REPORT','CASHIER SHIFT REPORT'));
				}
				elseif( $dev=='SMT09160024')//Pat Bing Soo
				{
					$this->db->where('DeviceId', $this->input->post('DeviceId'));
					$this->db->where_in('CustomField1', array('Closed','SUMMARY SALES REPORT','CASHIER SHIFT REPORT','END OF DAY REPORT'));
				}
				elseif($dev=='SMT09160034'){ //periplus
					$this->db->where('DeviceId', $dev);
					$this->db->where_in('CustomField1', array('CLOSING HARIAN','CLOSING SHIFT',''));    
					$this->db->where('Nomor<>', "");
					$this->db->group_by(array('Nomor','CustomField3'));
				}
				elseif($dev=='SMT09160036' || $dev=='SMT09160039'){ //krisna / KRISNA
					$this->db->where('DeviceId', $dev);
					$this->db->group_by(array('Nomor','Tanggal','Jam'));
				}
				else{
					$this->db->where('DeviceId', $this->input->post('DeviceId'));
				}
			}
			
			if($this->input->post('txtJenis')=='1'){
				$this->db->where("date(FileTime) Between date('$dt1') and date('$dt2')");
			}
			if($this->input->post('txtJenis')=='0'){
				if($this->input->post('txtdt1')){
					$this->db->where("DATE_FORMAT(FileTime,'%Y-%m')>=", $this->input->post('txtdt1'));
				}
				if($this->input->post('txtdt2')){
					$this->db->where("DATE_FORMAT(FileTime,'%Y-%m')<=", $this->input->post('txtdt2'));
				}
			}
		
			$this->db->from($this->table);
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
			
			if(isset($_POST['order'])){ // here order processing
				$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			}
			else if(isset($this->order)){
				$order = $this->order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}
		
		public function get_datatables(){
			$this->_get_datatables_query();
			if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
			return $query->result();
		}
		 
		public function count_filtered(){
			$this->_get_datatables_query();
			$query = $this->db->get();
			return $query->num_rows();
		}
	 
		public function count_all(){
			$this->db->from($this->table);
			return $this->db->count_all_results();
		}

		public function get_list_countries(){
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

		function tenant(){
			$this->db->group_by('Id');
			//$this->db->order_by('Tenant','ASC');
			$tenant = $this->db->get('Tenant');
			return $tenant->result();
		}
		
		function deviceByTenantId($id){
			$this->db->where('tenant', $id);
			$tenant = $this->db->get('DeviceTable');
			return $tenant->result();
		}
	}


