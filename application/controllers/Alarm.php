<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Alarm extends CI_Controller{

    	function __construct(){
    		  parent::__construct();
    		  $this->load->library('ssp');
    		  $this->load->model('Model_Alarm');
          $this->load->model('Model_Map');
          $this->load->model('Model_Dashboard');
          $this->load->library('Googlemaps');
          check_session();
    	}

    	function index(){
    	
        $this->load->library('Googlemaps');
        $config['center'] = 'Samasta Lifestyle Village, Indonesia';
        $config['zoom'] = 'auto';
        $this->googlemaps->initialize($config);

        $coord = $this->Model_Map->get_coordinates();

        // foreach($coord as $coordinate){
        //   $marker = array();
        //   $marker['position']=$coordinate->Lat.','.$coordinate->Long;
        //   $marker['infowindow_content']= "<h4>Status Perangkat</h4>Nama Tenant : <b>".$coordinate->Tenant."</b></br>"."Keterangan : ".$coordinate->description;
        //   $marker['animation'] = 'DROP';
        //   if($coordinate->AlarmType==1 OR $coordinate->AlarmType==2 OR  $coordinate->AlarmType==4 OR $coordinate->AlarmType==5 OR $coordinate->AlarmType==6 OR $coordinate->AlarmType==7 OR $coordinate->AlarmType==8 OR $coordinate->AlarmType==9 OR $coordinate->AlarmType==10 ){

        //    $tanda = base_url()."assets/img/marker/red.png";

        //   }
        //   else{
        //      $tanda = base_url()."assets/img/marker/green.png";
        //   }
        //    $marker['icon'] = $tanda;
        //   $this->googlemaps->add_marker($marker);
        // }
        $data['last_alarm'] = $this->Model_Dashboard->last_alarm()->result();
        // $data['map'] = $this->googlemaps->create_map();
        $this->template->load('template','Alarm/list',$data);

    	}


    	function alarmDetail(){
            $wp   = $_GET['datawp'];
            $sql = "SELECT a.AlarmTime, a.InsertTimeStamp, a.DeviceId, a.AlarmType, c.Tenant, b.Description from Alarm as a join AlarmCode as b on a.AlarmType = b.Code  join Tenant as c on a.DeviceId = c.DeviceId where a.DeviceId='$wp' ORDER by a.InsertTimeStamp DESC limit 100";
            $alarm = $this->db->query($sql)->result();
            $nomor=1;
            foreach($alarm as $row){
                echo "<tr>
                      <td>$nomor</td>
                      <td>$row->InsertTimeStamp</td>
                      <td>$row->AlarmTime</td>
                      <td>$row->DeviceId</td>
                      <td>$row->Tenant</td>
                    	<td>$row->AlarmType</td>
           			      <td>$row->Description</td>
                      </tr>";
              $nomor++;
          }
            
      }
    	

}
