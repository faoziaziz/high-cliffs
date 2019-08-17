<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Email extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->library('ssp');
		$this->load->model('Model_Email');
		
		check_session();
		//date_default_timezone_set("Asia/Bangkok");
	}
	
	public function index(){
		$q = $this->db->query("SELECT DayToSend FROM Email")->row();
		$data['dayToSend'] = $q->DayToSend;
		
		$this->template->load('template','Email/list', $data);
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

	public function ajax_edit($id){
        $data = $this->Model_Email->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_update(){
     	$data = array(
			'NamaEmail'	=> $this->input->post('txtEmail',TRUE),
			'NamaLengkap' => $this->input->post('txtNamaLengkap',TRUE)
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
		$detail=$this->db->query("select Alarm.*, AlarmCode.*, Tenant.Tenant as Tenant from Alarm INNER JOIN AlarmCode on Alarm.AlarmType = AlarmCode.Code INNER JOIN Tenant on Alarm.DeviceId = Tenant.DeviceId where Alarm.flag=0 order by Alarm.InsertTimeStamp DESC");
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

	function saveSendEmailDay($valDay){
		//update data
		$data = array(
			'DayToSend'=>$valDay
		);
		$query = $this->db->update('Email',$data);
		if($query){
			echo json_encode(array("status" =>true));
		}
		else{
			echo json_encode(array("status" =>false));
		}
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

		$detail=$this->db->query("SELECT Alarm.*, AlarmCode.*, Tenant.Tenant AS Tenant 
									FROM Alarm 
									INNER JOIN AlarmCode ON Alarm.AlarmType = AlarmCode.Code 
									INNER JOIN Tenant ON Alarm.DeviceId = Tenant.DeviceId 
									WHERE Alarm.flag=0 
									ORDER BY Alarm.InsertTimeStamp DESC
								");
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
			//echo"<ol>".$output."</ol>";
			 
			//collect nama email
			$email = $this->db->query("SELECT NamaEmail FROM Email");
			$receipents = array();
			$data="";

			//looping array nama email
			foreach($email->result() as $row){
				//$receipents[] = $row->NamaEmail;
				$receipents[] = "$row->NamaEmail" ;	
			}
			//buang tanda [] dan replace karakter
			$d 		= json_encode($receipents);
			$awal	= str_replace("\"","",trim($d,"[]"));
			$akhir 	= str_replace("'","",$awal);
		
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
			$this->email->to('nimsroot@gmail.com');
			// $this->email->to('muhammad.reza@prasimax.com, andra.riztyan@gmail.com, dean.iqbal@prasimax.com');
			//$this->email->to("$akhir");
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

	public function send2(){
		$dayNow = date('l');
		$detail=$this->db->query("SELECT Alarm.*, AlarmCode.*, Tenant.Tenant AS Tenant 
									FROM Alarm 
									INNER JOIN AlarmCode ON Alarm.AlarmType = AlarmCode.Code 
									INNER JOIN Tenant ON Alarm.DeviceId = Tenant.DeviceId 
									WHERE Alarm.flag=0 
									ORDER BY Alarm.InsertTimeStamp DESC
									LIMIT 100
								");
		$output="";
		$count  = $detail->num_rows();
		echo $count."<br />";
		//cek jika data ada data
		if($count>0){
			$q = $this->db->query("SELECT DayToSend FROM Email WHERE DayToSend='Monday'")->row();
			$dayToSend = $q->DayToSend;
			//$statSend = $q->StatSend;
			$dayNow = "Monday";
			if($dayToSend==$dayNow){
				foreach ($detail->result() as $row){
					$tenant =$row->Tenant;
					$datetime = $row->InsertTimeStamp;
					$AlarmType = $row->AlarmType;
					$Description = $row->Description;
					$DeviceId = $row->DeviceId;
					//echo"<li>Date : " . $datetime . " | Tenant : ".$tenant." | Alarm type : ".$AlarmType." | ".$Description. "</li>";
					$output .="<li>Date : " . $datetime . " | DeviceId : ".$DeviceId." | Tenant : ".$tenant." | Alarm type : ".$AlarmType." | ".$Description. "</li>";
				}
				//echo"<ol>".$output."</ol>";
			 
				//collect nama email
				$email = $this->db->query("SELECT NamaEmail FROM Email WHERE DayToSend='Monday'");
				$receipents = array();
				$data="";

				//looping array nama email
				foreach($email->result() as $row){
					//$receipents[] = $row->NamaEmail;
					$receipents[] = "$row->NamaEmail" ;	
				}
				//buang tanda [] dan replace karakter
				$d 		= json_encode($receipents);
				$awal	= str_replace("\"","",trim($d,"[]"));
				$akhir 	= str_replace("'","",$awal);
				
				//SEND EMAIL
				require_once "mail/Mail.php";
				require_once "mail/mime.php";
				
				//- port smtp = 25 / 465(ssl)
				$host       = "ssl://smtp.prasimax.com";
				$port       = "465";
				$username   = "notification@prasimax.com";
				$password   = "Terbang123";
				$from       = "notification@prasimax.com";
				$to			= $akhir;
				//$to         .= ",nimsroot@gmail.com"; // OPTIONAL
				$subject    = "[PRASIMAX] ALarm Alert [SAMASTA]"; 
				$headers    = array('From'=>$from,'To'=>$to,'Subject'=>$subject);
				$smtp       = Mail::factory('smtp',array ('host'=>$host,'port'=>$port,'auth'=>true,'username'=>$username,'password'=>$password));
				$html       = "Attention, There are alarms with details below : <br><ol>Output</ol>";
				$crlf       = "\n";
				$mime       = new Mail_mime($crlf);
				$mime->setHTMLBody($html);
				$body       = $mime->get();
				$headers    = $mime->headers($headers);
				$mail       =& Mail::factory('mail');
				if (PEAR::isError($mail)) {
					echo $mail->getMessage() . "\n" . $mail->getUserInfo() . "\n";
					die();
				}
				else{
					$mail->send($to, $headers, $body);
					echo "Success!!! ";
				}
					
				//update data
				foreach ($detail->result() as $row){
					$idAlarm 		= $row->idAlarm;
					
					$update=$this->db->query(" UPDATE Alarm SET FLag=1 WHERE FLag=0 AND idAlarm='$idAlarm' ");
					
					//cek jika data ada data
				}
				/* if(PEAR::isError($mail)) {
					echo json_encode($mail->getMessage()); */
					//echo "<script>alert('Sorry, Reservation Failed. please Repeat');</script>";
				/* } else {
					$emailStatus = "Sent";
					echo json_encode($mail->getMessage());  */
					//echo "<script>alert('We have receive your message. Thank you');</script>";
					//$URL=base_url();
					//echo "<script>location.href='$URL'</script>";
				/* } */
				
				//update data
				/* $data = array(
						'FLag'=>'1'
				);
				$this->db->where('Flag','0');
				$this->db->update('Alarm',$data);
				
				$dataEmail = array(
						'StatSend'=>'1'
				);
				$this->db->update('email',$dataEmail);*/
			}
			/*else{
				$data = array(
						'StatSend'=>'0'
				);
				$this->db->update('email',$data);
			}*/
		}
	}

	public function send3(){
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'nimrotletter@gmail.com',
			'smtp_pass' => 'gmaildotcom',
			'mailtype' => 'html',
			'charset' => 'iso-8859-1',
			'wordwrap' => TRUE
		);
		
		$email = 'nimsroot@gmail.com';

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from('notification@prasimax.com', 'PRASIMAX');
		$this->email->to($email);
		$this->email->subject('SOME SUBJECT');
		$this->email->message('<p>Some Content</p>');
		$this->email->send();
		echo $this->email->print_debugger();
	}

	public function send4(){
		$message = "Line 1\r\nLine 2\r\nLine 3";

		// In case any of our lines are larger than 70 characters, we should use wordwrap()
		$message = wordwrap($message, 70, "\r\n");

		// Send
		mail('nimsroot@gmail.com', 'My Subject', $message);
	}
}