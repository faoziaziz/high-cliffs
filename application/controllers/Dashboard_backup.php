<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {


	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct(){
			parent::__construct();
			
			$this->load->model('Model_Dashboard');
			$this->load->model('Model_Map');
			 $this->load->library('Googlemaps');
  
			check_session();
	}
	function chart2(){
			$query = $this->db->query("
					SELECT a.DeviceId,  a.tenant, sum(a.dpp) as dpp,sum(a.pajak) as pajak, sum(a.total) as total from(
			select   a.Nomor, (a.FileTime)as DateTime, a.DeviceId, c.Tenant, if(a.nilai like '%,%',replace(a.nilai,',',''),replace(a.nilai,'.',''))as dpp,if(a.pajak like '%,%',replace(a.pajak,',',''),replace(a.pajak,'.',''))as pajak, if(a.nilaidanpajak like '%,%',replace(a.nilaidanpajak,',',''),replace(a.nilaidanpajak,'.',''))as total
			from Transaksi a join DeviceTable b on (a.DeviceId = b.DeviceId) join Tenant c on  (b.tenant = c.id)
			WHERE ((MONTH(a.FileTime)=MONTH(CURDATE())) AND (YEAR(a.FileTime)=YEAR(CURDATE()))) and a.DeviceId in ('APS010700020','APS010700030','APS010700040') group by a.Nomor,a.nilaidanpajak
			union all
			select   a.Nomor, (a.FileTime)as DateTime, a.DeviceId, c.Tenant, if(a.nilai like '%,%',replace(a.nilai,',',''),replace(a.nilai,'.',''))as dpp,if(a.pajak like '%,%',replace(a.pajak,',',''),replace(a.pajak,'.',''))as pajak, if(a.nilaidanpajak like '%,%',replace(a.nilaidanpajak,',',''),replace(a.nilaidanpajak,'.',''))as total
			from Transaksi a join DeviceTable b on (a.DeviceId = b.DeviceId) join Tenant c on  (b.tenant = c.id)
			WHERE ((MONTH(a.FileTime)=MONTH(CURDATE())) AND (YEAR(a.FileTime)=YEAR(CURDATE()))) and a.DeviceId ='APS010800090'
			union all
			select   a.Nomor, (a.FileTime)as DateTime, a.DeviceId, c.Tenant, if(a.nilai like '%,%',replace(a.nilai,',',''),replace(a.nilai,'.',''))as dpp,if(a.pajak like '%,%',replace(a.pajak,',',''),replace(a.pajak,'.',''))as pajak, if(a.nilaidanpajak like '%,%',replace(a.nilaidanpajak,',',''),replace(a.nilaidanpajak,'.',''))as total
			from Transaksi a join DeviceTable b on (a.DeviceId = b.DeviceId) join Tenant c on  (b.tenant = c.id)
			WHERE ((MONTH(a.FileTime)=MONTH(CURDATE())) AND (YEAR(a.FileTime)=YEAR(CURDATE()))) and a.DeviceId not in('APS010700020','APS010800090','APS010700030','APS010700040')
						) as a
					group by  a.DeviceId,a.tenant

				");
			if($query->num_rows() > 0){
	            foreach($query->result() as $data){
	                $hasil[] = $data;
	            }
	            echo json_encode($hasil);
       		 }
		}
		

	function chart(){
			$query = $this->db->query("
					SELECT a.DeviceId,  a.tenant, sum(a.dpp) as dpp,sum(a.pajak) as pajak, sum(a.total) as total from(
			select   a.Nomor, (a.FileTime)as DateTime, a.DeviceId, c.Tenant, if(a.nilai like '%,%',replace(a.nilai,',',''),replace(a.nilai,'.',''))as dpp,if(a.pajak like '%,%',replace(a.pajak,',',''),replace(a.pajak,'.',''))as pajak, if(a.nilaidanpajak like '%,%',replace(a.nilaidanpajak,',',''),replace(a.nilaidanpajak,'.',''))as total
			from Transaksi a join DeviceTable b on (a.DeviceId = b.DeviceId) join Tenant c on  (b.tenant = c.id)
			WHERE ((MONTH(a.FileTime)=MONTH(CURDATE())) AND (YEAR(a.FileTime)=YEAR(CURDATE()))) and a.DeviceId='APS010700020' group by a.Nomor,a.nilaidanpajak
			union all
			select   a.Nomor, (a.FileTime)as DateTime, a.DeviceId, c.Tenant, if(a.nilai like '%,%',replace(a.nilai,',',''),replace(a.nilai,'.',''))as dpp,if(a.pajak like '%,%',replace(a.pajak,',',''),replace(a.pajak,'.',''))as pajak, if(a.nilaidanpajak like '%,%',replace(a.nilaidanpajak,',',''),replace(a.nilaidanpajak,'.',''))as total
			from Transaksi a join DeviceTable b on (a.DeviceId = b.DeviceId) join Tenant c on  (b.tenant = c.id)
			WHERE ((MONTH(a.FileTime)=MONTH(CURDATE())) AND (YEAR(a.FileTime)=YEAR(CURDATE()))) and a.DeviceId <>'APS010700020'
						) as a
					group by  a.DeviceId,a.tenant

				");
			/*
			if($query->num_rows() > 0){
	            foreach($query->result() as $data){
	                $hasil[] = $data;
	            }
	            return $hasil;
       		 }*/
       		 $Device=array();
       		 $value=array();
       		 if($query->num_rows() > 0){
	            foreach($query->result() as $data){
	                $Device[] = $data->tenant; 
					$value[] = (float) $data->total; 
	            }
	           	$data=array();
	            array_push($result,$Device);
        		array_push($result,$value);
        		print json_encode($data);
       		 }
       		 
		}
		/*public function index()
		{



			$this->load->library('Googlemaps');
	    $config['center'] = 'Terminal 3, Indonesia';
	    $config['zoom'] = '16';
	   $config['cluster'] = TRUE;
	    $this->googlemaps->initialize($config);

	    $coord = $this->Model_Map->get_coordinates();

	    foreach($coord as $coordinate){
	      $marker = array();
	      $marker['position']=$coordinate->Lat.','.$coordinate->Long;
	      $marker['infowindow_content']= " <h4>Status Perangkat</h4>Nama Tenant : <b>".$coordinate->Tenant."</b></br>"."Keterangan : ".$coordinate->description;
	      $marker['animation'] = 'DROP';
	      if($coordinate->AlarmType==1 OR $coordinate->AlarmType==2 OR  $coordinate->AlarmType==4 OR $coordinate->AlarmType==5 OR $coordinate->AlarmType==6 OR $coordinate->AlarmType==7 OR $coordinate->AlarmType==8 OR $coordinate->AlarmType==9 OR $coordinate->AlarmType==10 ){

	       $tanda = base_url()."assets/img/marker/red.png";

	      }
	      else{
	         $tanda = base_url()."assets/img/marker/green.png";
	      }
	       $marker['icon'] = $tanda;

	      $this->googlemaps->add_marker($marker);
	    }
	   	 $data['last_alarm'] = $this->Model_Dashboard->last_alarm()->result();
	    //$data['map'] = $this->googlemaps->create_map();


			$data['devices'] = $this->Model_Dashboard->count_Devices();
			//$data['tenants'] = $this->Model_Dashboard->count_tenants();
			$data['alarm'] = $this->Model_Dashboard->count_alarm();
			$data['transaction'] = $this->Model_Dashboard->monthly_revenue()->result();
			$data['daily'] = $this->Model_Dashboard->daily_revenue()->result();
			//$data['last_alarm'] = $this->Model_Dashboard->last_alarm()->result();
			//$this->load->view('template');

			$data['chart']=$this->Model_Dashboard->chart();
			//$data['chart']=$this->chart3();
				

			$data['revenue_year']=$this->Model_Dashboard->pendapatan_tahun();
			$data['revenue_device']=$this->Model_Dashboard->pendapatan_device();
			$this->template->load('template','dashboard',$data);
		}*/
			public function index()
			{
				$data['devices'] = $this->Model_Dashboard->count_Devices();
				$data['alarm'] = $this->Model_Dashboard->count_alarm();
				$data['transaction'] = $this->Model_Dashboard->monthly_revenue()->result();
				$data['daily'] = $this->Model_Dashboard->daily_revenue()->result();
				//$data['last_alarm'] = $this->Model_Dashboard->last_alarm()->result();
				//$this->load->view('template');
				$data['chart']=$this->Model_Dashboard->chart();
				$data['revenue_year']=$this->Model_Dashboard->pendapatan_tahun();
				$data['revenue_device']=$this->Model_Dashboard->pendapatan_device();
				$this->template->load('template','dashboard',$data);
			}
			function daily_revenue(){
					/*return $this->db->query("SELECT  sum(a.total1) as total
												from(
												SELECT nomor, date(filetime)as date, DeviceId , if(nilaidanpajak like '%,%',replace(nilaidanpajak,',',''),replace(nilaidanpajak,'.',''))as total1
												FROM Transaksi
												WHERE nomor<>'' AND DATE(`filetime`) = CURDATE()  and DeviceId='APS010700020' group by Nomor,nilaidanpajak
												union all
												SELECT nomor, date(filetime)as date, DeviceId , if(nilaidanpajak like '%,%',replace(nilaidanpajak,',',''),replace(nilaidanpajak,'.',''))as total1
												FROM Transaksi
												WHERE nomor<>'' AND DATE(`filetime`) = CURDATE()  
												
												) as a
											");
						*/
						
					$query=	$this->db->query("SELECT  sum(a.total1) as total
												from(
												SELECT distinct nomor, date(filetime)as date, DeviceId , if(nilaidanpajak like '%,%',replace(nilaidanpajak,',',''),replace(nilaidanpajak,'.',''))as total1
												FROM Transaksi
												WHERE nomor<>'' AND DATE(`filetime`) = CURDATE()
												
												) as a
											");				
						foreach($query->result() as $row){
							$total = $row->total;
							$t = number_format($total,0,',','.');
							print $t;
						}
			}

			function monthly_revenue(){
					$query= $this->db->query("SELECT sum(a.total1) as total
											from(
											SELECT distinct nomor, date(filetime)as date, DeviceId , if(nilaidanpajak like '%,%',replace(nilaidanpajak,',',''),replace(nilaidanpajak,'.',''))as total1
											FROM Transaksi
											WHERE MONTH(FileTIme) = MONTH(CURRENT_DATE()) and YEAR(FILETIME) = YEAR(CURRENT_DATE())
											
											) as a


											");

					foreach($query->result() as $row){
							$total = $row->total;
							$t = number_format($total,0,',','.');
							print $t;

					}

			}

}
