<?php

Class Transaction extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->library('ssp');
		$this->load->model('Model_Transaction');
		$this->load->model('Model_Daily');
		check_session();

		date_default_timezone_set("Asia/Bangkok");
	}

	function index(){
		$data['info']= $this->Model_Daily->tenant();
		$this->template->load('template','Transaction/list',$data);
	}

	function transactionDetail(){
		$wp   = $_GET['datawp'];
		$bln  = $_GET['txtBulan'];
		$thn  = $_GET['txtTahun'];

		/*$sql = "select a.DeviceId, sum(a.total1) as total
		FROM(
		SELECT distinct nomor, date(filetime)as date, DeviceId , if(nilaidanpajak like '%,%',replace(nilaidanpajak,',',''),replace(nilaidanpajak,'.',''))as total1
		FROM Transaksi
		WHERE nomor<>''  and DeviceId='$wp' and ((MONTH(FileTime)='$bln') AND (YEAR(FileTime)='$thn'))
		union all
		SELECT nomor,  date(filetime)as date, DeviceId , if(nilaidanpajak like '%,%',replace(nilaidanpajak,',',''),replace(nilaidanpajak,'.','') )as total1
		FROM Transaksi
		WHERE nomor=''  and DeviceId='$wp' and ((MONTH(FileTime)='$bln') AND (YEAR(FileTime)='$thn'))
		) as a
		GROUP BY  a.DeviceId";
		*/
		$no = "";
		/*if ($wp=='SMT09160002' or $wp=='SMT09160012' or $wp=='SMT09160022' or $wp=='SMT09160017' or $wp=='SMT09160019' or $wp=='SMT09160020' or $wp=='SMT09160021' or $wp=='SMT09160005' ){
		$no = "GROUP BY Nomor";
		}
		elseif($wp=='SMT09160018'){
		$no = "And CustomField1='Bill Closed'";
		}
		else{
		$no="";
		}
		elseif($dev=='SMT09160029') //fish n co
		{
		$this->db->where('DeviceId', $this->input->post('DeviceId'));
		$this->db->where_in('CustomField1', array('Bill Closed','NETT SALES'));    
		$this->db->group_by(array('Nomor','Total'));  			
		}

		*/
		//grouping for avoid duplicate data
		if (  $wp=='SMT09160024' or $wp=='SMT09160025'  or $wp=='SMT09160034'){
			$no = "GROUP BY Nomor";
		}
		elseif($wp=='SMT09160021'){ //buns n meat
			$no = "And CustomField1 ='Closed Bill'";
		}
		elseif($wp=='SMT09160022'){ //buns n meat
			$no = "And CustomField1 ='Closed' GROUP BY Nomor ";
		}
		elseif( $wp=='SMT09160023'){ //barrel
			$no = "And CustomField1 ='Closed'";
		}
		elseif($wp=='SMT09160029'){
			$no = "And CustomField1='Bill Closed' GROUP BY Nomor";
		}
		elseif( $wp=='SMT09160028'){ //chir-chir
			$no = "And CustomField1='Closed'";	
		}
		
		else{
			$no="";
		}
		$sql = "SELECT a.DeviceId, sum(a.total1) as total,sum(a.amount) as amount,sum(a.Discount) as Discount
				FROM(
					SELECT distinct Nomor, date(FileTime)as DateTime, DeviceId ,if(nilai like '%,%',replace(nilai,',',''),replace(nilai,'.',''))as amount,if(nilaidanpajak like '%,%',replace(nilaidanpajak,',',''),replace(nilaidanpajak,'.',''))as total1,if(CustomField2 like '%,%',replace(CustomField2,',',''),replace(CustomField2,'.',''))as Discount
					FROM Transaksi
					WHERE DeviceId='$wp' and ((MONTH(FileTime)='$bln') AND (YEAR(FileTime)='$thn'))
				$no) as a
				GROUP BY  a.DeviceId 
			";
		
		$transaction = $this->db->query($sql)->result();
		$nomor = 1;
		foreach($transaction as $row){
			$total = $row->total;
			$amount = $row->amount;
			$Discount = $row->Discount;
			$t = number_format($total,0,',','.');
			$a = number_format($amount,0,',','.');
			$d = number_format($Discount,0,',','.');
			echo "<tr>
				<td>$nomor</td>
				<td width='20%'>$row->DeviceId</td>
				<td width='30%' align='right'>$a</td>
				<td width='30%' align='right'>$t</td>
				<td width='60%' align='right'>$d</td>	
				<td> <a href='#'' class='open_modal btn btn-xs btn-primary tooltips' onclick='detail()' id='$row->DeviceId'><span class='fa-stack'><i class='fa fa-eye'> </i></span>Detail</a></td>

				</tr>";
			$nomor++;
		}
	}

		
	public function ajax_edit(){
		$wp   = $_GET['datawp'];
		$bln  = $_GET['txtBulan'];
		$thn  = $_GET['txtTahun'];
		//$data = $this->Modal_->get_by_id($id);
		/*$data['record']=$this->Model_Transaction->view_detail($wp,$bln,$thn);
		// echo json_encode($data);
		$this->load->view('transaction/list_detail',$data);

		*/
		$no = "";
		if (  $wp=='SMT09160024' or $wp=='SMT09160025'  or $wp=='SMT09160034'){
			$no = "GROUP BY Nomor";
		}
		elseif($wp=='SMT09160021'){ //buns n meat
			$no = "And CustomField1 ='Closed Bill'";
		}
		elseif($wp=='SMT09160022'){ //buns n meat
			$no = "And CustomField1 ='Closed' GROUP BY Nomor ";
		}
		elseif( $wp=='SMT09160023'){ //barrel
			$no = "And CustomField1 ='Closed'";    
		}
		elseif($wp=='SMT09160029'){
			$no = "And CustomField1='Bill Closed' GROUP BY Nomor";
		}
		elseif( $wp=='SMT09160028'){ //chir-chir
			$no = "And CustomField1='Closed'";	
		}
		else{
			$no="";
		}
		$sql="SELECT a.DeviceId, a.date,sum(a.total1) as total,sum(a.amount) as amount,sum(a.Discount) as Discount
			FROM(
				SELECT distinct Nomor, date(FileTime)as date, DeviceId,if(nilai like '%,%',replace(nilai,',',''),replace(nilai,'.',''))as amount ,if(nilaidanpajak like '%,%',replace(nilaidanpajak,',',''),replace(nilaidanpajak,'.',''))as total1,if(CustomField2 like '%,%',replace(CustomField2,',',''),replace(CustomField2,'.',''))as Discount
				FROM Transaksi WHERE DeviceId='$wp' and ((MONTH(FileTime)='$bln') AND (YEAR(FileTime)='$thn')) $no) as a GROUP BY  a.DeviceId,a.date";
		$detail = $this->db->query($sql)->result();
		
		foreach($detail as $row){
			$total = $row->total;
			$amount = $row->amount;
			$Discount = $row->Discount;
			$t = number_format($total,0,',','.');
			$a = number_format($amount,0,',','.');
			$d = number_format($Discount,0,',','.');
			echo "<tr>
					<td>$row->DeviceId</td>
					<td>$row->date</td>
					<td>$a</td>
					<td>$t</td>
					<td>$d</td>
				</tr>";
		}
	}
	
	function export_excel(){
		$this->load->library('CPHP_Excel');
		$obj = new PHPExcel();
		
		$i=0;
		while ($i <=2) {
			// Add new sheet
			$objWorkSheet = $obj->createSheet($i); //Setting index when creating
			//Write cells
			// Rename sheet
			$tenant   	= (!empty($_POST['ddTenant']))? $_POST['ddTenant'] : ((!empty($_GET['ddTenant']))? $_GET['ddTenant']: '');
			$jnsPenjln	= (!empty($_POST['ddJnsPnjualan']))? $_POST['ddJnsPnjualan'] : '';
			$wp			= (!empty($_POST['wp']))? $_POST['wp'] : '';
			$jns  = $_POST['txtjenis'];
			$dt1  = $_POST['txtdt1'];
			$dt2  = $_POST['txtdt2'];
			
			//echo "Tenant = ".$tenant."<br />";
			//echo "Jenis Penjualan = ".$jnsPenjln."<br />";
			//echo "WP = ".$wp."<br />";
			//echo "Jenis = ".$jns."<br />";
			//echo "DT1 = ".$dt1."<br />";
			//echo "DT2 = ".$dt2."<br />";
			//die();
			
			$stats= "";

			if ( $wp=='SMT09160024' or $wp=='SMT09160025'  or $wp=='SMT09160034'){
				$no = "GROUP BY Nomor";
			}
			elseif($wp=='SMT09160021'){ //buns n meat   
				$no = "And CustomField1 ='Closed Bill'";
			}
			elseif($wp=='SMT09160022'){ //base2
				$no = "And CustomField1 ='Closed' GROUP BY Nomor ";
			}
			elseif( $wp=='SMT09160023'){ //barrel
				$no = "And CustomField1 ='Closed'";    
			}
			elseif($wp=='SMT09160029'){
				$no = "And CustomField1='Bill Closed'";
			}
			elseif( $wp=='SMT09160028'){ //chir-chir
				$no = "And CustomField1='Closed'";	
			}
			
			if($jns=='1'){
				//if ( $wp=='SMT09160022'  or $wp=='SMT09160024'  or $wp=='SMT09160025'  or $wp=='SMT09160034'){
				if ( $wp=='SMT09160022'  or $wp=='SMT09160024'){
					$stats="a.DeviceId ='$wp' and date(FileTime) Between date('$dt1') and date('$dt2') and a.CustomField1='Closed' GROUP BY a.Nomor";
				}
				/* elseif($wp=='SMT09160034'){
					$stats="a.DeviceId ='$wp' and date(FileTime) Between date('$dt1') and date('$dt2') and CustomField1='closing shift'";
				} */
				elseif($wp=='SMT09160021'){ //Buns n Meat
					$stats="a.DeviceId ='$wp' and date(FileTime) Between date('$dt1') and date('$dt2') and CustomField1='Closed Bill'";
				}
				elseif($wp=='SMT09160023'){ //Barrel
					$stats="a.DeviceId ='$wp' and date(FileTime) Between date('$dt1') and date('$dt2') and CustomField1='Closed' ";
				}
				elseif( $wp=='SMT09160028'){ //chir-chir
					$stats = "a.DeviceId ='$wp' and date(FileTime) Between date('$dt1') and date('$dt2') And CustomField1='Closed'";	
				}
				elseif($wp=='SMT09160029'){ //fish n co
					$stats="a.DeviceId ='$wp' and date(FileTime) Between date('$dt1') and date('$dt2')  and CustomField1='Bill Closed'";
				}
				elseif( $wp=='SMT09160036'){ //krisna
					$stats = "a.DeviceId ='$wp' and date(FileTime) Between date('$dt1') and date('$dt2') GROUP BY a.Nomor";	
				}
				else{
					if(!empty($tenant)){
						$stats="b.flag ='$tenant' and date(FileTime) Between date('$dt1') and date('$dt2')";
					}
					elseif(!empty($jnsPenjln)){
						$stats="b.JenisPenjualan ='$jnsPenjln' and date(FileTime) Between date('$dt1') and date('$dt2')";
					}
					else{
						$stats="a.DeviceId ='$wp' and date(FileTime) Between date('$dt1') and date('$dt2')";
					}
				}
			}
			if($jns=='0'){
				//if ( $wp=='SMT09160022'  or $wp=='SMT09160024'  or $wp=='SMT09160025'  or $wp=='SMT09160034'){
				if ( $wp=='SMT09160022'  or $wp=='SMT09160024'){
					$stats="a.DeviceId ='$wp' and DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' and DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' and a.CustomField1='Closed' GROUP BY a.Nomor ";
				}
				elseif( $wp=='SMT09160021'){ //Barrel
					$stats = "a.DeviceId ='SMT09160021' and DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' and DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' And CustomField1='Closed Bill'";	
				}
				elseif( $wp=='SMT09160023'){ //Barrel 
					$stats = "a.DeviceId ='SMT09160023' and DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' and DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' And CustomField1='Closed'";	
				}
				elseif( $wp=='SMT09160028'){ //chir-chir
					$stats = "a.DeviceId ='SMT09160028' and DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' and DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' And CustomField1='Closed'";	
				}
				elseif($wp=='SMT09160029'){
					$stats="a.DeviceId ='$wp' and DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' and DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2'  and CustomField1='Bill Closed'";
				}
				elseif($wp=='SMT09160036'){
					$stats="a.DeviceId ='$wp' and DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' and DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' GROUP BY a.Nomor";
				}
				else{
					if(!empty($tenant)){
						$stats="b.flag ='$tenant' and DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' and DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' ";
					}
					elseif(!empty($jnsPenjln)){
						$stats="b.JenisPenjualan ='$jnsPenjln' and DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' and DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' ";
					}
					else{
						$stats="a.DeviceId ='$wp' and DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' and DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' ";
					}
				}
			}
			
			if($i==0){
				$objWorkSheet->setCellValue('A1','DeviceId')
					->setCellValue('B1','Tenant')
					->setCellValue('C1','Date')
				->setCellValue('D1','Total Transaction');
				
				$sql="
					SELECT c.DeviceId,c.Tenant, c.DateTime , sum(c.total1) as total
					FROM(
						SELECT distinct a.Nomor, DATE_FORMAT(a.FileTime,'%Y-%m')as DateTime, a.DeviceId ,b.Tenant, 
							if(a.nilaidanpajak like '%,%',replace(a.nilaidanpajak,',',''),replace(a.nilaidanpajak,'.',''))as total1
						FROM Transaksi a JOIN Tenant b ON a.DeviceId=b.DeviceId
					WHERE $stats) as c
					GROUP BY c.DeviceId,c.Tenant,c.DateTime";
				
				$transaction = $this->db->query($sql)->result();
				$rows = 2;
				foreach($transaction as $row){
					//	$objPHPExcel->getActiveSheet()->setCellValue('A2',$row->DeviceId);
					//$objPHPExcel->getActiveSheet()->setCellValue('B2', $row->total);
					$objWorkSheet->setCellValue('A'.$rows,$row->DeviceId)
												->setCellValue('B'.$rows, $row->Tenant)
												->setCellValue('C'.$rows, $row->DateTime)
												->setCellValue('D'.$rows, $row->total);		
												$rows++;		
				}
				$objWorkSheet->setTitle("Monthly");
				$objWorkSheet->getColumnDimension('A')->setWidth(20);
				$objWorkSheet->getColumnDimension('B')->setWidth(20);
			}
			elseif($i==1){
				$objWorkSheet->setCellValue('A1','DeviceId')
							->setCellValue('B1','Tenant')
							->setCellValue('C1','Date')
							->setCellValue('D1','Total Transaction');
				
				$sql="
					SELECT c.DeviceId,c.Tenant, c.date,sum(c.total1) as total,sum(((c.totalN)-(c.Pajak))) as Total2
					FROM(
						SELECT distinct a.Nomor, date(a.FileTime)as date, a.DeviceId ,b.Tenant, 
							if(a.nilai like '%,%',replace(a.nilai,',',''),replace(a.nilai,'.',''))AS totalN,
							if(a.Pajak like '%,%',replace(a.Pajak,',',''),replace(a.Pajak,'.','')) AS Pajak,
							if(a.nilaidanpajak like '%,%',replace(a.nilaidanpajak,',',''),replace(a.nilaidanpajak,'.',''))as total1
						FROM Transaksi a 
						JOIN Tenant b ON a.DeviceId=b.DeviceId
						WHERE $stats
					) as c
					GROUP BY c.DeviceId,c.Tenant,c.date";
			
				$transaction = $this->db->query($sql)->result();
				$rows = 2;
				foreach($transaction as $row){
					$objWorkSheet->setCellValue('A'.$rows,$row->DeviceId)
												->setCellValue('B'.$rows, $row->Tenant)
												->setCellValue('C'.$rows, $row->date)
												->setCellValue('D'.$rows, $row->Total2);
					$rows++;
				}
				$objWorkSheet->setTitle("Daily");
				$objWorkSheet->getColumnDimension('A')->setWidth(20);
				$objWorkSheet->getColumnDimension('B')->setWidth(20);
				$objWorkSheet->getColumnDimension('C')->setWidth(20);
			}
			elseif($i==2){
				 $objWorkSheet->setCellValue('A1','DeviceId')
				 ->setCellValue('B1','Tenant')
				 ->setCellValue('C1','Date')
				 ->setCellValue('D1','Nomor')
				 ->setCellValue('E1','Amount')
				 ->setCellValue('F1','pajak')
				 ->setCellValue('G1','Total')
				 ->setCellValue('H1','Ket')
				 ->setCellValue('I1','Diskon')
				 ->setCellValue('J1','Net Sales');
				
			
				$sql="
					SELECT distinct a.Nomor, a.FileTime as date, a.DeviceId ,b.Tenant, 
						if(a.nilai like '%,%',replace(a.nilai,',',''),replace(a.nilai,'.',''))as total1,
						if(a.Pajak like '%,%',replace(a.Pajak,',',''),replace(a.Pajak,'.','')) AS Pajak,
						if((a.NilaiDanPajak like '%,%'),replace(a.NilaiDanPajak,',',''),replace(a.NilaiDanPajak,'.','')) AS total,
						a.CustomField1 AS CustomField1,
						if(CustomField2 like '%,%',replace(CustomField2,',',''),replace(CustomField2,'.',''))as Discount,
						a.CustomField3 AS CustomField3 
					FROM Transaksi a
					JOIN Tenant b ON a.DeviceId=b.DeviceId
					WHERE $stats
					ORDER BY date ASC";
				
				$transaction = $this->db->query($sql)->result();
				$rows = 2;
				foreach($transaction as $row){
					$objWorkSheet->setCellValue('A'.$rows,$row->DeviceId)
												->setCellValue('B'.$rows, $row->Tenant)
												->setCellValue('C'.$rows, $row->date)
												->setCellValue('D'.$rows, $row->Nomor)
												->setCellValue('E'.$rows, $row->total1)
												->setCellValue('F'.$rows, $row->Pajak)
												->setCellValue('G'.$rows, $row->total)
												->setCellValue('H'.$rows, $row->CustomField1)
												->setCellValue('I'.$rows, $row->Discount)
												->setCellValue('J'.$rows, $row->CustomField3);
					$rows++;
				}
					
				$objWorkSheet->setTitle("All");
				 
				$objWorkSheet->getColumnDimension('A')->setWidth(20);
				$objWorkSheet->getColumnDimension('B')->setWidth(20);
				$objWorkSheet->getColumnDimension('C')->setWidth(20);
			} 
			$i++;
		}
		
		$obj->removeSheetByIndex(3);
		$filename='Transaction.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($obj, 'Excel5');
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	}
		
	function getDeviceByTenanId($id){
		$devices = $this->Model_Daily->deviceByTenantId($id);
		echo json_encode($devices);
	}
	
	function addManualData(){
		//input deviceID and Tenant to tenant table
		$ddTenantHdn = $this->input->post('ddTenantHdn');
		$flag = str_replace(' ', '_', $ddTenantHdn);
		$flag = str_replace('-', '_', $flag);
		$qSql = $this->Model_Transaction->get_by_two_param('tenant','DeviceId',null,'Tenant',$ddTenantHdn);
		
		/*$qSql = "SELECT DeviceId FROM tenant WHERE Tenant='$ddTenantHdn' AND DeviceId='' ";
		$rSql = $this->db->query($qSql)->row();*/
		
		if(empty($qSql)){
			$dataTenant = array(
				'DeviceId' => $this->input->post('txtDevice', TRUE),
				'Tenant' => $ddTenantHdn,
				'flag' => strtoupper($flag)
			);
			$this->Model_Transaction->save($dataTenant, 'tenant');
		}
		else{
			$data = array(
				'DeviceId' => $this->input->post('txtDevice', TRUE),
				'flag' => strtoupper($flag)
			);
			$id = $qSql->id;
			$this->Model_Transaction->update('tenant', array('id' => $id), $data);
		}
		
		//input deviceID and Tenant to device table
		/*$dataDevice = array(
			'DeviceId' => $this->input->post('txtDevice', TRUE),
			'tenant' => $this->input->post('ddTenant', TRUE),
			'IsManual' => 1
		);
		$this->Model_Transaction->save($dataDevice, 'devicetable');*/
		
		//input transaction
		$dataTransaction = array(
			'DeviceId' => $this->input->post('txtDevice', TRUE),
			'RefSN' => $this->input->post('txtRefSN', TRUE),
			'FileTime' => date("Y-m-d H:i:s"),
			'Nomor' => $this->input->post('txtNoTransaction', TRUE),
			'Tanggal' => $this->input->post('txtTanggal', TRUE),
			'Jam' => $this->input->post('txtJam', TRUE),
			'Nilai' => $this->input->post('txtAmount', TRUE),
			'Pajak' => $this->input->post('txtTax', TRUE),
			'NilaiDanPajak' => $this->input->post('txtTotal', TRUE),
			'CustomField1' => $this->input->post('txtKeterangan', TRUE),
			'CustomField2' => $this->input->post('txtDiskon', TRUE),
			'CustomField3' => $this->input->post('txtNetSales', TRUE)
		);
		
		$this->Model_Transaction->save($dataTransaction, 'transaksi');
		echo json_encode(array("status" => true));
	}
}

