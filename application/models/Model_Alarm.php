<?php

	Class Model_Alarm extends CI_Model{

		public $table="Alarm";
	
		function showData(){
			//  $infoAlarm = "SELECT a.InsertTimeStamp, a.DeviceId, c.CompanyName, a.AlarmType, b.Description from alarm as a join alarmcode as b on a.AlarmType = b.Code join datawp as c on a.DeviceId = c.DeviceId  limit 100";

				 // $infoAlarm = "SELECT * from alarm limit 1000";
			    //$this->db->order_by('a.InsertTimeStamp','DESC');

				$this->db->select('Alarm.InsertTimeStamp, Alarm.DeviceId, DataWP.CompanyName, Alarm.AlarmType, AlarmCode.Description');
				$this->db->from('Alarm');
				$this->db->join('alarmcode','Alarm.Alarmtype=AlarmCode.Code');
				$this->db->join('Tenant','Alarm.DeviceId=Tenant.DeviceId');
				//$this->db->order_by('alarm.InsertTimeStamp','DESC'); 
				$this->db->limit(100);

			// $result = $this->db->get('alarm as a join alarmcode as b on a.AlarmType = b.Code join datawp as c on a.DeviceId = c.DeviceId', 10);
				return $this->db->get();
			  //return $this->db->query();
			
		}
	
	}


