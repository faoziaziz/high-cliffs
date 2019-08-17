<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Email extends CI_Controller{

	function __construct(){
		parent::__construct();
			$this->load->library('ssp');
		$this->load->model('Model_Email');
		   
		  
	}
	public function index(){
		$this->template->load('template','Email/list');
	}


	function data(){
		//nama table
		$table = 'Email';
		// nama pk
			$primaryKey='Id';
		//list table
		$columns = array(
		
			
			//tes
			array('db'=>'NamaEmail','dt'=>'NamaEmail'),
		
			array('db'=>'NamaLengkap','dt'=>'NamaLengkap'),
			array(
				'db'=>'Id',
				'dt'=>'aksi',
				'formatter'=>function ($d){
					//return "<a href='edit.php?id=$d'>EDIT</a>";
					return '<a class="btn btn-xs btn-primary tooltips" href="javascript:void(0)" title="Edit" onclick="edit('."'".$d."'".')"><i class="glyphicon glyphicon-pencil"></i></a> <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_data('."'".$d."'".')"><i class="glyphicon glyphicon-trash"></i></a>';

						
				}

				)
			
			);

		$sql_details=array(
			'user'=>$this->db->username,
			'pass' => $this->db->password,
			'db' => $this->db->database,
			'host' => $this->db->hostname
			);

		 echo json_encode(
                SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
        );
	}

	function add(){
	
			$data = array(
				'NamaEmail'	=> $this->input->post('txtEmail',TRUE),
				'NamaLengkap' => $this->input->post('txtNamaLengkap',TRUE),
				
				
				);
			$this->Model_Email->save($data);
			echo json_encode(array("status" =>true));

		
	}

	 public function delete($id){
    	$this->Model_Email->delete($id);
    	 echo json_encode(array("status" => TRUE));
    }

     public function ajax_edit($id)
    {
        $data = $this->Model_Email->get_by_id($id);
     
        echo json_encode($data);
    }

    public function ajax_update()
    {
      
     	$data = array(
				'NamaEmail'	=> $this->input->post('txtEmail',TRUE),
				'NamaLengkap' => $this->input->post('txtNamaLengkap',TRUE),
				


				);
   
        $this->Model_Email->update(array('Id' => $this->input->post('id')), $data);
      
        echo json_encode(array("status" => TRUE));
    }


	function getEmail(){
		$email = $this->db->query("SELECT NamaEmail from Email");
		$receipents = array();
		$data="";

		
		foreach($email->result() as $row){
			//$receipents[] = $row->NamaEmail;
			$receipents[] = "$row->NamaEmail" ;
			
		}
		$d = json_encode($receipents);
		$awal= str_replace("\"","",trim($d,"[]"));
		$akhir = str_replace("'","",$awal);
		echo $awal;
		
		
	}

	function checkData(){
		   $sql="SELECT a.idAlarm AS idAlarm,a.InsertTimeStamp AS InsertTimeStamp,a.DeviceId AS DeviceId,c.Tenant AS Tenant,a.AlarmType AS AlarmType,b.description AS description from ((Alarm a join AlarmCode b on((a.AlarmType = b.code))) join Tenant c on((a.DeviceId = c.DeviceId))) where  a.InsertTimeStamp in (select max(Alarm.InsertTimeStamp) from Alarm group by Alarm.DeviceId) order by a.InsertTimeStamp ";
		 
		  // $detail = $this->db->query("SELECT a.idAlarm AS idAlarm,a.InsertTimeStamp AS InsertTimeStamp,a.DeviceId AS DeviceId,c.Tenant AS Tenant,a.AlarmType AS AlarmType,b.description AS description from ((Alarm a join AlarmCode b on((a.AlarmType = b.code))) join Tenant c on((a.DeviceId = c.DeviceId))) where  a.InsertTimeStamp in (select max(Alarm.InsertTimeStamp) from Alarm group by Alarm.DeviceId) order by a.InsertTimeStamp desc limit 5 ");
		   $detail=$this->db->query("select Alarm.*, AlarmCode.*, Tenant.Tenant as Tenant from Alarm inner join AlarmCode on Alarm.AlarmType = AlarmCode.Code inner join Tenant on Alarm.DeviceId = Tenant.DeviceId where Alarm.flag=0 order by Alarm.InsertTimeStamp DESC");
		  $output="";

		  $count  = $detail->num_rows();
		  if($count>0){


		   foreach ($detail->result() as $row){
		   		$tenant =$row->Tenant;
		   		 $datetime = $row->InsertTimeStamp;
		   		 $AlarmType = $row->AlarmType;
		   		 $Description = $row->Description;
		   		 $DeviceId = $row->DeviceId;
		   		//echo"<li>Date : " . $datetime . " | Tenant : ".$tenant." | Alarm type : ".$AlarmType." | ".$Description. "</li>";
		   		 $output .="<li>Date : " . $datetime . " | DeviceId : ".$DeviceId." | Tenant : ".$tenant." | Alarm type : ".$AlarmType." | ".$Description. "</li>";

		   }
		   echo"<ol>".$output."</ol>";
		  }



		   //update data
		 	/*$data = array(
		 		'FLag'=>'1'
		 	);
		 	$this->db->where('Flag','0');
		 	$this->db->update('Alarm',$data);
		  */
	}

	public function send(){

		/* $config = Array(  
		   'protocol' => 'smtp',  
		    'smtp_host' => 'ssl://smtp.googlemail.com',  
		    'smtp_port' => 465,  
		    'smtp_user' => 'andra.riztyan@gmail.com',   
		    'smtp_pass' => 'wannabeProgrammer91',   
		    'mailtype' => 'html',   
		    'charset' => 'iso-8859-1'  
		   );  
		*/

		  /*  $detail = $this->db->query("SELECT a.idAlarm AS idAlarm,a.InsertTimeStamp AS InsertTimeStamp,a.DeviceId AS DeviceId,c.Tenant AS Tenant,a.AlarmType AS AlarmType,b.description AS description from ((Alarm a join AlarmCode b on((a.AlarmType = b.code))) join Tenant c on((a.DeviceId = c.DeviceId))) where  a.InsertTimeStamp in (select max(Alarm.InsertTimeStamp) from Alarm group by Alarm.DeviceId) order by a.InsertTimeStamp desc Limit 1");
		   foreach ($detail->result() as $row){
		   		 $tenant =$row->Tenant;
		   		 $datetime = $row->InsertTimeStamp;
		   		 $AlarmType = $row->AlarmType;
		   		 $Description = $row->description;
		   		 $DeviceId = $row->DeviceId;

		   }*/

		    $detail=$this->db->query("select Alarm.*, AlarmCode.*, Tenant.Tenant as Tenant from Alarm inner join AlarmCode on Alarm.AlarmType = AlarmCode.Code inner join Tenant on Alarm.DeviceId = Tenant.DeviceId where Alarm.flag=0 order by Alarm.InsertTimeStamp DESC");
		  $output="";

		   $count  = $detail->num_rows();
		   //cek jika data ada data
		  if($count>0){
			   foreach ($detail->result() as $row){
			   		$tenant =$row->Tenant;
			   		 $datetime = $row->InsertTimeStamp;
			   		 $AlarmType = $row->AlarmType;
			   		$Description = $row->Description;
		   			 $DeviceId = $row->DeviceId;
			   		//echo"<li>Date : " . $datetime . " | Tenant : ".$tenant." | Alarm type : ".$AlarmType." | ".$Description. "</li>";
			   		  $output .="<li>Date : " . $datetime . " | DeviceId : ".$DeviceId." | Tenant : ".$tenant." | Alarm type : ".$AlarmType." | ".$Description. "</li>";

			   }
			 //  echo"<ol>".$output."</ol>";
			 
			 //collect nama email
			$email = $this->db->query("SELECT NamaEmail from Email");
			$receipents = array();
			$data="";

			//looping array nama email
			foreach($email->result() as $row){
				//$receipents[] = $row->NamaEmail;
				$receipents[] = "$row->NamaEmail" ;
				
			}
			//buang tanda [] dan replace karakter
			$d = json_encode($receipents);
			$awal= str_replace("\"","",trim($d,"[]"));
			$akhir = str_replace("'","",$awal);
		
			  $config = Array(  
			   'protocol' => 'smtp',  
			    'smtp_host' => 'ssl://gator4140.hostgator.com',  
			    'smtp_port' => 465,  
			    'smtp_user' => 'notification@prasimax.com',   
			    'smtp_pass' => 'untukdashboard10',   
			    'mailtype' => 'html',   
			    'charset' => 'iso-8859-1'  
			   );  
			   $this->load->library('email', $config);  
	  		   $this->email->set_newline("\r\n");  
			   $this->email->from('andra.riztyan@prasimax.com', 'Admin [Alarm]');   
			  // $this->email->to('andra.riztyan@gmail.com');   
			  // $this->email->to('muhammad.reza@prasimax.com, andra.riztyan@gmail.com, dean.iqbal@prasimax.com');
			   $this->email->to("$akhir");
			   $this->email->subject('[PRASIMAX] ALarm Alert');   
			   $this->email->message('Attention, There are alarms with details below : <br><ol>' . $output. '</ol>');  
			   if (!$this->email->send()) {  
			    show_error($this->email->print_debugger());   
			   }else{  
			    echo 'Success to send email';   
			   } 

			    //update data
			 	$data = array(
			 		'FLag'=>'1'
			 	);
			 	$this->db->where('Flag','0');
			 	$this->db->update('Alarm',$data);
			  
		 } 
		   
	}


}