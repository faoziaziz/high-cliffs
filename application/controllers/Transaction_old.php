<?php

	Class Transaction extends CI_Controller{

		function __construct(){
			parent::__construct();
			$this->load->library('ssp');
			$this->load->model('Model_Transaction');
			$this->load->model('Model_Daily');
			check_session();
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
					from(
					SELECT distinct nomor, date(filetime)as date, DeviceId , if(nilaidanpajak like '%,%',replace(nilaidanpajak,',',''),replace(nilaidanpajak,'.',''))as total1
					FROM Transaksi
					WHERE nomor<>''  and DeviceId='$wp' and ((MONTH(FileTime)='$bln') AND (YEAR(FileTime)='$thn'))
					union all
					SELECT nomor,  date(filetime)as date, DeviceId , if(nilaidanpajak like '%,%',replace(nilaidanpajak,',',''),replace(nilaidanpajak,'.','') )as total1
					FROM Transaksi
					WHERE nomor=''  and DeviceId='$wp' and ((MONTH(FileTime)='$bln') AND (YEAR(FileTime)='$thn'))
					) as a
					group by  a.DeviceId";
					*/
			$sql = "
				select a.DeviceId, sum(a.total1) as total
				from(
				SELECT distinct Nomor, date(FileTime)as DateTime, DeviceId ,if(nilaidanpajak like '%,%',replace(nilaidanpajak,',',''),replace(nilaidanpajak,'.',''))as total1
				FROM Transaksi
				WHERE DeviceId='$wp' and ((MONTH(FileTime)='$bln') AND (YEAR(FileTime)='$thn'))
				group by Nomor, DeviceId,total1,DateTime) as a
				group by  a.DeviceId
			";

			$transaction = $this->db->query($sql)->result();
			$nomor = 1;
			foreach($transaction as $row){
				$total = $row->total;
				$t = number_format($total,0,',','.');
				echo "<tr>
					<td>$nomor</td>
					<td width='30%'>$row->DeviceId</td>
					<td width='60%'>Rp. $t</td>
				
					<td> <a href='#'' class='open_modal btn btn-xs btn-primary tooltips' onclick='detail()' id='$row->DeviceId'><span class='fa-stack'><i class='fa fa-eye'> </i></span>Detail</a></td>
					
				</tr>";
				$nomor++;
			}


		}

		
		 public function ajax_edit()
		    {
		    	$wp   = $_GET['datawp'];
				$bln  = $_GET['txtBulan'];
				$thn  = $_GET['txtTahun'];
		        //$data = $this->Modal_->get_by_id($id);
		     	/*$data['record']=$this->Model_Transaction->view_detail($wp,$bln,$thn);
		       // echo json_encode($data);
		     	$this->load->view('transaction/list_detail',$data);

		     	*/
		     	$sql="select a.DeviceId, a.date,sum(a.total1) as total
						from(
						SELECT distinct Nomor, date(FileTime)as date, DeviceId ,if(nilaidanpajak like '%,%',replace(nilaidanpajak,',',''),replace(nilaidanpajak,'.',''))as total1
						FROM Transaksi WHERE DeviceId='$wp' and ((MONTH(FileTime)='$bln') AND (YEAR(FileTime)='$thn')) group by Nomor, DeviceId,total1,date) as a group by  a.DeviceId,a.date";

		     	$detail = $this->db->query($sql)->result();
				
				foreach($detail as $row){
						$total = $row->total;
						$t = number_format($total,0,',','.');
					echo "<tr>
					<td>$row->DeviceId</td>
						<td>$row->date</td>
						
						<td>Rp. $t</td>
						
					</tr>";
					
				}
		    }

		   
		    function Export_excel(){

		    $this->load->library('CPHP_Excel');
		    	$obj = new PHPExcel();

 
				 $i=0;
				 while ($i <=1) {
				 
				// Add new sheet
				 $objWorkSheet = $obj->createSheet($i); //Setting index when creating
				 
				//Write cells
				
				 
				// Rename sheet
							 $wp   = $_POST['datawp'];
				$bln  = $_POST['txtBulan'];
				$thn  = $_POST['txtTahun'];


				if($i==0){
					
					$objWorkSheet->setCellValue('A1','DeviceId')
				 	->setCellValue('B1','Total Transaction');
					$sql = "select a.DeviceId, sum(a.total1) as total
				from(
				SELECT distinct Nomor, date(FileTime)as DateTime, DeviceId ,if(nilaidanpajak like '%,%',replace(nilaidanpajak,',',''),replace(nilaidanpajak,'.',''))as total1
				FROM Transaksi
				WHERE DeviceId='$wp' and ((MONTH(FileTime)='$bln') AND (YEAR(FileTime)='$thn'))
				group by Nomor, DeviceId,total1,DateTime) as a
				group by  a.DeviceId";

						$transaction = $this->db->query($sql)->result();
						
						foreach($transaction as $row){
						//	$objPHPExcel->getActiveSheet()->setCellValue('A2',$row->DeviceId);
							//$objPHPExcel->getActiveSheet()->setCellValue('B2', $row->total);
							 $objWorkSheet->setCellValue('A2',$row->DeviceId)
						 						->setCellValue('B2', $row->total);
						}
						 $objWorkSheet->setTitle("Monthly");
						
				 	$objWorkSheet->getColumnDimension('A')->setWidth(20);

				$objWorkSheet->getColumnDimension('B')->setWidth(20);
				
					}
				elseif($i==1){

						
					 $objWorkSheet->setCellValue('A1','DeviceId')
					 ->setCellValue('B1','Tanggal')
					 ->setCellValue('C1','Total Transaction');
					
						$sql="select a.DeviceId, a.date,sum(a.total1) as total
						from(
						SELECT distinct Nomor, date(FileTime)as date, DeviceId ,if(nilaidanpajak like '%,%',replace(nilaidanpajak,',',''),replace(nilaidanpajak,'.',''))as total1
						FROM Transaksi WHERE DeviceId='$wp' and ((MONTH(FileTime)='$bln') AND (YEAR(FileTime)='$thn')) group by Nomor, DeviceId,total1,date) as a group by  a.DeviceId,a.date";


				$transaction = $this->db->query($sql)->result();
					$rows = 2;
				foreach($transaction as $row){
					 $objWorkSheet->setCellValue('A'.$rows,$row->DeviceId)
						 						->setCellValue('B'.$rows, $row->date)
						 						->setCellValue('C'.$rows, $row->total);
					$rows++;
				}
					
					 $objWorkSheet->setTitle("Daily");

				 	$objWorkSheet->getColumnDimension('A')->setWidth(20);

				$objWorkSheet->getColumnDimension('B')->setWidth(20);
				$objWorkSheet->getColumnDimension('C')->setWidth(20);
				}
				 
				$i++;
				 }
				  $obj->removeSheetByIndex(2);
		
				 $filename='transaction.xls'; //save our workbook as this file name
				 header('Content-Type: application/vnd.ms-excel'); //mime type
				 header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				 header('Cache-Control: max-age=0'); //no cache
				 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				 //if you want to save it as .XLSX Excel 2007 format
				 $objWriter = PHPExcel_IOFactory::createWriter($obj, 'Excel5');
				 //force user to download the Excel file without writing it to server's HD
				 $objWriter->save('php://output');
		    	
		    }


		    function tes(){

		    	$this->load->library('CPHP_Excel');
		    	$obj = new PHPExcel();

 
				 $i=0;
				 while ($i < 2) {
				 
				// Add new sheet
				 $objWorkSheet = $obj->createSheet($i); //Setting index when creating
				 
				//Write cells
				 $objWorkSheet->setCellValue('A1','DeviceId')
				 ->setCellValue('B1','Total Transaction');
				 
				// Rename sheet
				 $wp   = $_POST['datawp'];
				$bln  = $_POST['txtBulan'];
				$thn  = $_POST['txtTahun'];

			
				$sql = "select a.DeviceId, sum(a.total1) as total
						from(
						SELECT distinct nomor, date(filetime)as date, DeviceId , if(nilaidanpajak like '%,%',replace(nilaidanpajak,',',''),replace(nilaidanpajak,'.',''))as total1
						FROM Transaksi
						WHERE nomor<>''  and DeviceId='$wp' and ((MONTH(FileTime)='$bln') AND (YEAR(FileTime)='$thn'))
						union all
						SELECT nomor,  date(filetime)as date, DeviceId , if(nilaidanpajak like '%,%',replace(nilaidanpajak,',',''),replace(nilaidanpajak,'.',''))as total1
						FROM Transaksi
						WHERE nomor=''  and DeviceId='$wp' and ((MONTH(FileTime)='$bln') AND (YEAR(FileTime)='$thn'))
						) as a
						group by  a.DeviceId";

				$transaction = $this->db->query($sql)->result();
				
				foreach($transaction as $row){
				//	$objPHPExcel->getActiveSheet()->setCellValue('A2',$row->DeviceId);
					//$objPHPExcel->getActiveSheet()->setCellValue('B2', $row->total);
					 $objWorkSheet->setCellValue('A1',$row->DeviceId)
				 ->setCellValue('B1', $row->total);
				}
				 $objWorkSheet->setTitle("$i");
				 
				$i++;
				 }
				 
				 
				 
				 $filename='just_some_random_name.xls'; //save our workbook as this file name
				 header('Content-Type: application/vnd.ms-excel'); //mime type
				 header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				 header('Cache-Control: max-age=0'); //no cache
				 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				 //if you want to save it as .XLSX Excel 2007 format
				 $objWriter = PHPExcel_IOFactory::createWriter($obj, 'Excel5');
				 //force user to download the Excel file without writing it to server's HD
				 $objWriter->save('php://output');
						    }
					
	}

