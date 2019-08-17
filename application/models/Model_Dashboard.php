<?php

	Class Model_Dashboard extends CI_Model{

	
		function count_Devices(){
			 $query = $this->db->query("SELECT * FROM Tenant");
			  return $query->num_rows();
			
		}
		function count_alarm(){
			 $query = $this->db->query("SELECT * FROM Alarm limit 1000");
			  return $query->num_rows();
			
		}
		function monthly_revenue(){
			return $this->db->query("SELECT sum(a.total1) as total
									from(
									SELECT distinct nomor, date(filetime)as date, DeviceId , if(nilaidanpajak like '%,%',replace(nilaidanpajak,',',''),replace(nilaidanpajak,'.',''))as total1
									FROM Transaksi
									WHERE MONTH(FileTIme) = MONTH(CURRENT_DATE()) and YEAR(FILETIME) = YEAR(CURRENT_DATE())
									
									) as a

									");

		}
		function daily_revenue(){
			return $this->db->query("SELECT  sum(a.total1) as total
										from(
										SELECT distinct nomor, date(filetime)as date, DeviceId , if(nilaidanpajak like '%,%',replace(nilaidanpajak,',',''),replace(nilaidanpajak,'.',''))as total1
										FROM Transaksi
										WHERE nomor<>'' AND DATE(`filetime`) = CURDATE()
										
										) as a
									");

		}

		function last_alarm(){
			return $this->db->query("SELECT * FROM view_last_alarm Order By date DESC");
		}

		function chart(){
			$query = $this->db->query("
					SELECT a.DeviceId,  a.tenant, sum(a.dpp) as dpp,sum(a.pajak) as pajak, sum(a.total) as total
					from(
						select   a.Nomor, (a.FileTime)as DateTime, a.DeviceId, c.Tenant, if(a.nilai like '%,%',replace(a.nilai,',',''),replace(a.nilai,'.',''))as dpp,if(a.pajak like '%,%',replace(a.pajak,',',''),replace(a.pajak,'.',''))as pajak, if(a.nilaidanpajak like '%,%',replace(a.nilaidanpajak,',',''),replace(a.nilaidanpajak,'.',''))as total
									from Transaksi a join DeviceTable b on (a.DeviceId = b.DeviceId) join Tenant c on  (b.tenant = c.id)
						WHERE ((MONTH(a.FileTime)=MONTH(CURDATE())) AND (YEAR(a.FileTime)=YEAR(CURDATE()))) 
						) as a
					group by  a.DeviceId,a.tenant

				");
			if($query->num_rows() > 0){
	            foreach($query->result() as $data){
	                $hasil[] = $data;
	            }
	            return $hasil;
       		 }
		}

		function pendapatan_tahun (){
			$query = $this->db->query("
					SELECT  concat(MONTH(a.datetime),'-',Year(a.datetime)) as month, sum(a.dpp) as dpp,sum(a.pajak) as pajak, sum(a.total) as total
					from(
						select   a.Nomor, (a.FileTime)as DateTime, a.DeviceId, c.Tenant, if(a.nilai like '%,%',replace(a.nilai,',',''),replace(a.nilai,'.',''))as dpp,if(a.pajak like '%,%',replace(a.pajak,',',''),replace(a.pajak,'.',''))as pajak, if(a.nilaidanpajak like '%,%',replace(a.nilaidanpajak,',',''),replace(a.nilaidanpajak,'.',''))as total
						from Transaksi a join DeviceTable b on (a.DeviceId = b.DeviceId) join Tenant c on  (b.tenant = c.id) where YEAR(a.FileTIme) = YEAR(CURDATE())
					) as a
					group by year(a.datetime),MONTH(a.datetime),month");
			if($query->num_rows() > 0){
	            foreach($query->result() as $data){
	                $hasil[] = $data;
	            }
	            return $hasil;
       		 }
		}

		function pendapatan_device(){
			
			$query = $this->db->query("
					SELECT a.DeviceId,  sum(a.dpp) as dpp,sum(a.pajak) as pajak, sum(a.total) as total
					from(
						select   a.Nomor, (a.FileTime)as DateTime, a.DeviceId, c.Tenant, if(a.nilai like '%,%',replace(a.nilai,',',''),replace(a.nilai,'.',''))as dpp,if(a.pajak like '%,%',replace(a.pajak,',',''),replace(a.pajak,'.',''))as pajak, if(a.nilaidanpajak like '%,%',replace(a.nilaidanpajak,',',''),replace(a.nilaidanpajak,'.',''))as total
										from Transaksi a join DeviceTable b on (a.DeviceId = b.DeviceId) join Tenant c on  (b.tenant = c.id) where YEAR(a.FileTIme) = YEAR(CURDATE())
					) as a
					group by year(a.datetime),a.DeviceId");
			if($query->num_rows() > 0){
	            foreach($query->result() as $data){
	                $hasil[] = $data;
	            }
	            return $hasil;
       		 }
		}
	
	}


