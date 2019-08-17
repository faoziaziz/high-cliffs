<?php

	Class Model_Transaction extends CI_Model{
	

		
		 /* public function get_by_id($id,$year,$month)
		    {
		        $this->db->Select("DATE(FileTime) as DATE, SUM(if(nilaidanpajak like '%,%',replace(nilaidanpajak,',',''),replace(nilaidanpajak,'.',''))) as total, DeviceId");
		        $this->db->from('Transaksi')
		        $this->db->where('DeviceId',$id);
		         $this->db->where('DATE_FORMAT(FileTime,"%Y")',$year);
		          $this->db->where('DATE_FORMAT(FileTime,"%m")',$month);
		        $query = $this->db->get();
		 
		        return $query->row();
		    }
		    */

		    function view_detail($id,$year,$month){
		    	$sql="SELECT date(filetime)as date, DeviceId , sum(if(nilaidanpajak like '%,%',replace(nilaidanpajak,',',''),replace(nilaidanpajak,'.',''))) as total FROM `Transaksi` WHERE nomor<>''  and DeviceId='$id' and ((MONTH(FileTime)='$month') AND (YEAR(FileTime)='$year'))group by date(filetime)";

		    	return $this->db->query($sql)->result();
		    }

	}


?>