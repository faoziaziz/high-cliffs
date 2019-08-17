<?php

	Class Model_ALl_Transaction extends CI_Model{

		public $table="view_transc";
		 var $column_order = array(null, 'FileTime',' DeviceId','CompanyName','Nilai','Pajak','total','CustomField1','CustomField2','CustomField3'); //set column field database for datatable orderable
	    var $column_search = array('FileTime',' DeviceId','CompanyName','Nilai','Pajak','total','CustomField1','CustomField2','CustomField3');//set column field database for datatable searchable
	    var $order = array('FileTime' => 'DESC'); // default order 



	     private function _get_datatables_query()
    {
         
   
       
      $this->db->from($this->table);
      $this->db->limit(100);
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

		/*function showData(){
			//  $infoAlarm = "SELECT a.InsertTimeStamp, a.DeviceId, c.CompanyName, a.AlarmType, b.Description from alarm as a join alarmcode as b on a.AlarmType = b.Code join datawp as c on a.DeviceId = c.DeviceId  limit 100";

				 // $infoAlarm = "SELECT * from alarm limit 1000";
			    //$this->db->order_by('a.InsertTimeStamp','DESC');

				$this->db->select('alarm.InsertTimeStamp, alarm.DeviceId, datawp.CompanyName, alarm.AlarmType, alarmcode.Description');
				$this->db->from('alarm');
				$this->db->join('alarmcode','alarm.Alarmtype=alarmcode.Code');
				$this->db->join('datawp','alarm.DeviceId=datawp.DeviceId');
				//$this->db->order_by('alarm.InsertTimeStamp','DESC'); 
				$this->db->limit(100);

			// $result = $this->db->get('alarm as a join alarmcode as b on a.AlarmType = b.Code join datawp as c on a.DeviceId = c.DeviceId', 10);
				return $this->db->get();
			  //return $this->db->query();
			
		}
		*/
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
		        $this->db->from($this->table);
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


		    function tenant(){
		    	$this->db->order_by('DeviceId','ASC');
		    	$tenant = $this->db->get('Tenant');
		    	return $tenant->result_array();
		    }
			
	}


