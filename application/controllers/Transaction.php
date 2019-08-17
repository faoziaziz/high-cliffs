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
		//$this->template->load('template','Transaction/list',$data);
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
		WHERE nomor<>''  AND DeviceId='$wp' AND ((MONTH(FileTime)='$bln') AND (YEAR(FileTime)='$thn'))
		union all
		SELECT nomor,  date(filetime)as date, DeviceId , if(nilaidanpajak like '%,%',replace(nilaidanpajak,',',''),replace(nilaidanpajak,'.','') )as total1
		FROM Transaksi
		WHERE nomor=''  AND DeviceId='$wp' AND ((MONTH(FileTime)='$bln') AND (YEAR(FileTime)='$thn'))
		) as a
		GROUP BY  a.DeviceId";
		*/
		$no = "";
		/*if ($wp=='SMT09160002' or $wp=='SMT09160012' or $wp=='SMT09160022' or $wp=='SMT09160017' or $wp=='SMT09160019' or $wp=='SMT09160020' or $wp=='SMT09160021' or $wp=='SMT09160005' ){
		$no = "GROUP BY Nomor";
		}
		elseif($wp=='SMT09160018'){
		$no = "AND CustomField1='Bill Closed'";
		}
		else{
		$no="";
		}
		elseif($dev=='SMT09160029') //FISH_N_CO
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
		elseif($wp=='SMT09160021'){ //BUNS_N_MEAT
			$no = "AND CustomField1 ='Closed Bill'";
		}
		elseif($wp=='SMT09160022'){ //BUNS_N_MEAT
			$no = "AND CustomField1 ='Closed' GROUP BY Nomor ";
		}
		elseif( $wp=='SMT09160023'){ //BARREL
			$no = "AND CustomField1 ='Closed'";
		}
		elseif($wp=='SMT09160029'){
			$no = "AND CustomField1='Bill Closed' GROUP BY Nomor";
		}
		elseif( $wp=='SMT09160028'){ //CHIR_CHIR
			$no = "AND CustomField1='Closed'";	
		}
		
		else{
			$no="";
		}
		$sql = "SELECT a.DeviceId, sum(a.total1) as total,sum(a.amount) as amount,sum(a.Discount) as Discount
				FROM(
					SELECT distinct Nomor, date(FileTime)as DateTime, DeviceId ,if(nilai like '%,%',replace(nilai,',',''),replace(nilai,'.',''))as amount,if(nilaidanpajak like '%,%',replace(nilaidanpajak,',',''),replace(nilaidanpajak,'.',''))as total1,if(CustomField2 like '%,%',replace(CustomField2,',',''),replace(CustomField2,'.',''))as Discount
					FROM Transaksi
					WHERE DeviceId='$wp' AND ((MONTH(FileTime)='$bln') AND (YEAR(FileTime)='$thn'))
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
		elseif($wp=='SMT09160021'){ //BUNS_N_MEAT
			$no = "AND CustomField1 ='Closed Bill'";
		}
		elseif($wp=='SMT09160022'){ //BUNS_N_MEAT
			$no = "AND CustomField1 ='Closed' GROUP BY Nomor ";
		}
		elseif( $wp=='SMT09160023'){ //BARREL
			$no = "AND CustomField1 ='Closed'";    
		}
		elseif($wp=='SMT09160029'){
			$no = "AND CustomField1='Bill Closed' GROUP BY Nomor";
		}
		elseif( $wp=='SMT09160028'){ //CHIR_CHIR
			$no = "AND CustomField1='Closed'";	
		}
		else{
			$no="";
		}
		$sql="SELECT a.DeviceId, a.date,sum(a.total1) as total,sum(a.amount) as amount,sum(a.Discount) as Discount
			FROM(
				SELECT distinct Nomor, date(FileTime)as date, DeviceId,if(nilai like '%,%',replace(nilai,',',''),replace(nilai,'.',''))as amount ,if(nilaidanpajak like '%,%',replace(nilaidanpajak,',',''),replace(nilaidanpajak,'.',''))as total1,if(CustomField2 like '%,%',replace(CustomField2,',',''),replace(CustomField2,'.',''))as Discount
				FROM Transaksi WHERE DeviceId='$wp' AND ((MONTH(FileTime)='$bln') AND (YEAR(FileTime)='$thn')) $no) as a GROUP BY  a.DeviceId,a.date";
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
		while ($i <=3) {
			// Add new sheet
			$objWorkSheet = $obj->createSheet($i); //Setting index when creating
			//Write cells
			// Rename sheet
			$tenant   	= (!empty($_POST['ddTenant']))? $_POST['ddTenant'] : ((!empty($_GET['ddTenant']))? $_GET['ddTenant']: '');
			$jnsPenjln	= (!empty($_POST['ddJnsPnjualan']))? $_POST['ddJnsPnjualan'] : '';
			$wp			= (!empty($_POST['wp']))? $_POST['wp'] : ((!empty($_GET['wp']))? $_GET['wp']: '' );
			$jns  = (!empty($_POST['txtjenis']))? $_POST['txtjenis'] : ((!empty($_GET['txtjenis']))? $_GET['txtjenis']: 0 );
			$dt1  = (!empty($_POST['txtdt1']))? $_POST['txtdt1'] : ((!empty($_GET['txtdt1']))? $_GET['txtdt1']: date("Y-m") );
			$dt2  = (!empty($_POST['txtdt2']))? $_POST['txtdt2'] : ((!empty($_GET['txtdt2']))? $_GET['txtdt2']: date("Y-m") );
			
			$fldTotPerTnt= "";
			$qTotPerTnt= "";
			$fieldTotSheetAllTnt= "";
			$fieldTotal= "";
			$qTotal= "";
			$stats= "";
			$statsAmountAndTask= "";
			$fieldDailySumNilai= "";

			if ( $wp=='SMT09160024' or $wp=='SMT09160025'  or $wp=='SMT09160034'){
				$no = "GROUP BY Nomor";
			}
			elseif($wp=='SMT09160021'){ //BUNS_N_MEAT   
				$no = "AND CustomField1 ='Closed Bill'";
			}
			elseif($wp=='SMT09160022'){ //BASE_BASE
				$no = "AND CustomField1 ='Closed' GROUP BY Nomor ";
			}
			elseif( $wp=='SMT09160023'){ //BARREL
				$no = "AND CustomField1 ='Closed'";    
			}
			elseif($wp=='SMT09160029'){
				$no = "AND CustomField1='Bill Closed'";
			}
			elseif( $wp=='SMT09160028'){ //CHIR_CHIR
				$no = "AND CustomField1='Closed'";	
			}
			
			//####//
			
			$fieldTotalOne = "SUM((c.Nilai)-(c.Diskon))"; //BASE_BASE, PAT_BING_SOO, BARREL, CHIR_CHIR, PERIPLUS
			$fieldTotalTwo = "SUM(c.Nilai)"; //SEREH_GOURMET, FISH_N_CO
			$fieldTotalThree = "(CASE WHEN SUM(((c.Nilai)-(c.Diskon))) = 0 THEN c.Nilai ELSE SUM(((c.Nilai)-(c.Diskon))) END)"; //KRISNA
			
			$qTotalOne = "if(a.nilai like '%,%',replace(a.nilai,',',''),replace(a.nilai,'.',''))AS Nilai,
							if(a.Pajak like '%,%',replace(a.Pajak,',',''),replace(a.Pajak,'.','')) AS Pajak,
							if(a.CustomField2 like '%,%',replace(a.CustomField2,',',''),replace(a.CustomField2,'.','')) AS Diskon";
			
			$fieldTotalSheetAllOne = "(if(a.nilai like '%,%',replace(a.nilai,',',''),replace(a.nilai,'.',''))) - (if(a.CustomField2 like '%,%',replace(a.CustomField2,',',''),replace(a.CustomField2,'.','')))";
			$fieldTotalSheetAllTwo = "if(a.nilai like '%,%',replace(a.nilai,',',''),replace(a.nilai,'.',''))";
			$fieldTotalSheetAllThree = "(CASE WHEN (a.nilai)-(a.CustomField2) = 0 THEN a.nilai ELSE (a.Nilai)-(a.CustomField2) END)";
			
			//####//
			
			//####//
			if(!empty($tenant)){
				if($tenant=='BUNS_N_MEAT' or $tenant=='BASE_BASE' or $tenant=='BARREL' or $tenant=='PAT_BING_SOO' or $tenant=='CHIR_CHIR' or $tenant=='PERIPLUS'){
					$fldTotPerTnt = "$fieldTotalOne";
					$qTotPerTnt = "$qTotalOne";
					$fieldTotSheetAllTnt = "$fieldTotalSheetAllOne";
				}
				elseif($tenant=='SEREH_GOURMET' or $tenant=='FISH_N_CO'){
					$fldTotPerTnt = "$fieldTotalTwo";
					$qTotPerTnt = "$qTotalOne";
					$fieldTotSheetAllTnt = "$fieldTotalSheetAllTwo";
				}
				elseif($tenant=='KRISNA'){
					$fldTotPerTnt = "$fieldTotalThree";
					$qTotPerTnt = "$qTotalOne";
					$fieldTotSheetAllTnt = "$fieldTotalSheetAllThree";
				}
				else{
					$fldTotPerTnt = "$fieldTotalTwo";
					$qTotPerTnt = "$qTotalOne";
					$fieldTotSheetAllTnt = "$fieldTotalSheetAllTwo";
				}
			}
			//####//
			
			if($jns=='0'){ //Monthly
				if ( $wp=='SMT09160022'  or $wp=='SMT09160024'){ //BASE_BASE, PAT_BING_SOO
					$fieldTotal = "$fieldTotalOne";
					$fieldTotalSheetAll= "$fieldTotalSheetAllOne";
					$qTotal = "$qTotalOne";
					$stats="a.DeviceId ='$wp' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' AND a.CustomField1='Closed' GROUP BY a.Nomor ";
					//$statsAmountAndTask = "c.DeviceId ='$wp' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='SUMMARY SALES REPORT' OR c.DeviceId ='$wp' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='END OF DAY REPORT' ";
					$statsAmountAndTask = "c.DeviceId ='$wp' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='END OF DAY REPORT' GROUP BY c.FileTime ORDER BY c.Jam DESC";
					$fieldDailySumNilai = "c.CustomField3 as dailySumNilai";
				}
				elseif($wp=='SMT09160025' or $wp=='SMT09160027'){ //SEREH_GOURMET  or $wp=='SMT09160030' //210619 kode SMT09160030 kepunyaan STAR
					$fieldTotal = "$fieldTotalTwo";
					$fieldTotalSheetAll= "$fieldTotalSheetAllTwo";
					$qTotal = "$qTotalOne";
					$stats = "a.DeviceId ='$wp' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2'";	
					$statsAmountAndTask = "c.DeviceId ='$wp' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='' GROUP BY c.FileTime ORDER BY c.Jam DESC";
					$fieldDailySumNilai = "'' as dailySumNilai";
				}
				elseif($wp=='SMT09160032'){ //STAR
					$fieldTotal = "$fieldTotalTwo";
					$fieldTotalSheetAll= "$fieldTotalSheetAllTwo";
					$qTotal = "$qTotalOne";
					$stats = "a.DeviceId ='$wp' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2'";	
					$statsAmountAndTask = "c.DeviceId ='$wp' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='' GROUP BY c.FileTime ORDER BY c.Jam DESC ";
					$fieldDailySumNilai = "'' as dailySumNilai";
				}
				elseif($wp=='SMT09160030'){ //STAR
					$fieldTotal = "$fieldTotalTwo";
					$fieldTotalSheetAll= "$fieldTotalSheetAllTwo";
					$qTotal = "$qTotalOne";
					$stats = "a.DeviceId ='$wp' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2'";	
					$statsAmountAndTask = "c.DeviceId ='$wp' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='' GROUP BY c.FileTime ORDER BY c.Jam DESC ";
					$fieldDailySumNilai = "'' as dailySumNilai";
				}
				elseif($wp=='SMT09160021'){ //BUNS_N_MEAT
					$fieldTotal = "$fieldTotalTwo";
					$fieldTotalSheetAll= "$fieldTotalSheetAllOne";
					$qTotal = "$qTotalOne";
					$stats = "a.DeviceId ='$wp' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' AND CustomField1='Closed Bill'";
					$statsAmountAndTask = "c.DeviceId ='$wp' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='' GROUP BY c.FileTime ORDER BY c.Jam DESC ";
					$fieldDailySumNilai = "'' as dailySumNilai";
				}
				elseif($wp=='SMT09160023'){ //BARREL
					$fieldTotal= "$fieldTotalOne";
					$fieldTotalSheetAll= "$fieldTotalSheetAllOne";
					$qTotal= "$qTotalOne";
					$stats = "a.DeviceId ='$wp' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' AND CustomField1='Closed'";	
					//$statsAmountAndTask = "c.DeviceId ='$wp' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='SUMMARY SALES REPORT' OR c.DeviceId ='$wp' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='END OF DAY REPORT' ";
					$statsAmountAndTask = "c.DeviceId ='$wp' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='END OF DAY REPORT' GROUP BY c.FileTime ORDER BY c.Jam DESC ";
					$fieldDailySumNilai = "c.Nilai as dailySumNilai";
				}
				elseif($wp=='SMT09160028'){ //CHIR_CHIR
					$fieldTotal = "$fieldTotalOne";
					$fieldTotalSheetAll= "$fieldTotalSheetAllOne";
					$qTotal = "$qTotalOne";
					$stats = "a.DeviceId ='$wp' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' AND CustomField1='Closed'";
					//$statsAmountAndTask = "c.DeviceId ='$wp' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='SUMMARY SALES REPORT' OR c.DeviceId ='$wp' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='END OF DAY REPORT' ";
					$statsAmountAndTask = "c.DeviceId ='$wp' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='END OF DAY REPORT' GROUP BY c.FileTime ORDER BY c.Jam DESC ";
					$fieldDailySumNilai = "c.CustomField3 as dailySumNilai";
				}
				elseif($wp=='SMT09160029'){ //FISH_N_CO
					$fieldTotal = "$fieldTotalTwo";
					$fieldTotalSheetAll= "$fieldTotalSheetAllOne";
					$qTotal = "$qTotalOne";
					$stats="a.DeviceId ='$wp' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' AND CustomField1='Bill Closed' AND a.Nomor <> '' GROUP BY a.Nomor";
					$statsAmountAndTask = "c.DeviceId ='$wp' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='NETT SALES' AND c.Nomor <> '' GROUP BY c.FileTime ORDER BY c.Jam DESC";
					$fieldDailySumNilai = "c.CustomField3 as dailySumNilai";
				}
				elseif($wp=='SMT09160034'){ //PERIPLUS
					$fieldTotal = "$fieldTotalOne";
					$fieldTotalSheetAll= "$fieldTotalSheetAllOne";
					$qTotal = "$qTotalOne";
					$stats="a.DeviceId ='$wp' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' GROUP BY a.Nomor,a.Tanggal,a.Jam";
					$statsAmountAndTask = "c.DeviceId ='$wp' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='CLOSING HARIAN' GROUP BY c.FileTime ORDER BY c.Jam DESC ";
					$fieldDailySumNilai = "c.CustomField3 as dailySumNilai";
				}
				elseif($wp=='SMT09160036'){ //krisna
					$fieldTotal = "$fieldTotalThree";
					$fieldTotalSheetAll= "$fieldTotalSheetAllThree";
					$qTotal = "$qTotalOne";
					$stats="a.DeviceId ='$wp' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' GROUP BY a.Nomor,a.Tanggal,a.Jam";
					$statsAmountAndTask = "c.DeviceId ='$wp' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='Laporan Penjualan Harian Total' OR c.DeviceId ='$wp' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='' GROUP BY c.FileTime ORDER BY c.Jam DESC ";
					$fieldDailySumNilai = "'' as dailySumNilai";
				}
				elseif($wp=='SMT09160039'){ //KRISNA
					$fieldTotal = "$fieldTotalThree";
					$fieldTotalSheetAll= "$fieldTotalSheetAllThree";
					$qTotal = "$qTotalOne";
					$stats="a.DeviceId ='$wp' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' GROUP BY a.Nomor,a.Tanggal,a.Jam";
					$statsAmountAndTask = "c.DeviceId ='$wp' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='Laporan Penjualan Harian Total' OR c.DeviceId ='$wp' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='' GROUP BY c.FileTime ORDER BY c.Jam DESC ";
					$fieldDailySumNilai = "c.CustomField3 as dailySumNilai";
				}
				else{
					if(!empty($tenant)){
						$fieldTotal = "$fldTotPerTnt";
						$fieldTotalSheetAll= "$fieldTotSheetAllTnt";
						$qTotal = "$qTotPerTnt";
						if($tenant=='BUNS_N_MEAT'){
							$stats = "b.flag ='$tenant' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' AND CustomField1='Closed Bill'";
							$statsAmountAndTask = "b.flag ='$tenant' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='' GROUP BY c.FileTime ORDER BY c.Jam DESC ";
							$fieldDailySumNilai = "'' as dailySumNilai";
						}
						elseif($tenant=='BASE_BASE'){
							$stats = "b.flag ='$tenant' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' AND a.CustomField1='Closed' GROUP BY a.Nomor";
							//$statsAmountAndTask = "b.flag ='$tenant' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='SUMMARY SALES REPORT' OR b.flag ='$tenant' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='END OF DAY REPORT' GROUP BY c.Nomor ";
							$statsAmountAndTask = "b.flag ='$tenant' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND ( (c.CustomField1 = 'END OF DAY REPORT') OR c.CustomField1 = 'CASHIER SHIFT REPORT') GROUP BY c.FileTime ORDER BY c.Jam DESC ";
							$fieldDailySumNilai = "c.CustomField3 as dailySumNilai";
						}
						elseif($tenant=='PAT_BING_SOO'){
							$stats = "b.flag ='$tenant' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' AND a.CustomField1='Closed' GROUP BY a.Nomor";
							//$statsAmountAndTask = "b.flag ='$tenant' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='SUMMARY SALES REPORT' OR b.flag ='$tenant' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='END OF DAY REPORT' GROUP BY c.Nomor ";
							$statsAmountAndTask = "b.flag ='$tenant' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='END OF DAY REPORT' GROUP BY c.FileTime ORDER BY c.Jam DESC ";
							$fieldDailySumNilai = "c.CustomField3 as dailySumNilai";
						}
						elseif($tenant=='BARREL'){
							$stats = "b.flag ='$tenant' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' AND a.CustomField1='Closed'";
							//$stats = "b.flag ='$tenant' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2'";
							//$statsAmountAndTask = "b.flag ='$tenant' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='SUMMARY SALES REPORT' OR b.flag ='$tenant' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='END OF DAY REPORT' ";
							$statsAmountAndTask = "b.flag ='$tenant' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND ( (c.CustomField1 = 'END OF DAY REPORT') OR c.CustomField1 = 'SUMMARY SALES REPORT' ) GROUP BY c.FileTime ORDER BY c.Jam DESC ";
							$fieldDailySumNilai = "c.Nilai as dailySumNilai";
						}
						elseif($tenant=='CHIR_CHIR'){
							$stats = "b.flag ='$tenant' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' AND a.CustomField1='Closed'";
							//$stats = "b.flag ='$tenant' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2'";
							//$statsAmountAndTask = "b.flag ='$tenant' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='SUMMARY SALES REPORT' OR b.flag ='$tenant' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='END OF DAY REPORT' ";
							$statsAmountAndTask = "b.flag ='$tenant' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='END OF DAY REPORT' ";
							$fieldDailySumNilai = "c.CustomField3 as dailySumNilai";
						}
						elseif($tenant=='PERIPLUS'){
							$stats = "b.flag ='$tenant' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' GROUP BY a.Nomor,a.Tanggal,a.Jam";
							$statsAmountAndTask = "b.flag ='$tenant' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='CLOSING HARIAN' GROUP BY c.Nomor,c.Tanggal,c.Jam ";
							$fieldDailySumNilai = "c.CustomField3 as dailySumNilai";
						}
						elseif($tenant=='FISH_N_CO'){
							$stats = "b.flag ='$tenant' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' GROUP BY a.Nomor,a.Tanggal,a.Jam";
							$statsAmountAndTask = "b.flag ='$tenant' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='NETT SALES' AND c.Nomor <> '' GROUP BY c.FileTime ORDER BY c.Jam DESC";
							$fieldDailySumNilai = "c.CustomField3 as dailySumNilai";
						}
						elseif($tenant=='Krisna2'){
							$stats = "b.flag ='$tenant' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' GROUP BY a.Nomor,a.Tanggal,a.Jam";
							$statsAmountAndTask = "b.flag ='$tenant' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='Laporan Penjualan Harian Total' OR b.flag ='$tenant' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='' GROUP BY c.FileTime ORDER BY c.Jam DESC";
							$fieldDailySumNilai = "'' as dailySumNilai";
						}
						elseif($tenant=='Krisna1' or $tenant=='KRISNA'){
							$stats = "b.flag ='$tenant' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' GROUP BY a.Nomor,a.Tanggal,a.Jam";
							$statsAmountAndTask = "b.flag ='$tenant' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 ='Laporan Penjualan Harian Total' GROUP BY c.FileTime ORDER BY DATE_FORMAT(c.FileTime,'%H:%i:%s') DESC";
							$fieldDailySumNilai = "c.CustomField3 as dailySumNilai";
						}
						elseif($tenant=='SEREH_GOURMET'){
							$stats = "b.flag ='$tenant' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2'";
							$statsAmountAndTask = "b.flag ='$tenant' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 =''GROUP BY c.FileTime ORDER BY c.Jam DESC";
							$fieldDailySumNilai = "'' as dailySumNilai";
						}
						elseif($tenant=='STAR'){
							$stats = "b.flag ='$tenant' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2'";
							$statsAmountAndTask = "b.flag ='$tenant' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' AND c.CustomField1 =''GROUP BY c.FileTime ORDER BY c.Jam DESC";
							$fieldDailySumNilai = "'' as dailySumNilai";
						}
						else{
							//$stats = "b.flag ='$tenant' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' AND CustomField1='Closed'";
							$stats = "b.flag ='$tenant' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2'";
							$fieldDailySumNilai = "'' as dailySumNilai";
						}
					}
					elseif(!empty($jnsPenjln)){
						$fieldTotal = "$fieldTotalOne";
						$fieldTotalSheetAll= "$fieldTotalSheetAllOne";
						$qTotal = "$qTotalOne";
						$stats="b.JenisPenjualan ='$jnsPenjln' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' ";
						$statsAmountAndTask = "b.JenisPenjualan ='$jnsPenjln' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' GROUP BY c.FileTime ORDER BY c.Jam DESC";
						$fieldDailySumNilai = "'' as dailySumNilai";
					}
					else{
						$fieldTotal = "$fieldTotalOne";
						$fieldTotalSheetAll= "$fieldTotalSheetAllOne";
						$qTotal = "$qTotalOne";
						$stats="a.DeviceId ='$wp' AND DATE_FORMAT(a.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(a.FileTime,'%Y-%m') <='$dt2' ";
						$statsAmountAndTask = "c.DeviceId ='$wp' AND DATE_FORMAT(c.FileTime,'%Y-%m') >='$dt1' AND DATE_FORMAT(c.FileTime,'%Y-%m') <='$dt2' GROUP BY c.FileTime ORDER BY c.Jam DESC";
						$fieldDailySumNilai = "'' as dailySumNilai";
					}
				}
			}
			if($jns=='1'){ //Daily
				if ( $wp=='SMT09160022'  or $wp=='SMT09160024'){ //BASE_BASE, PAT_BING_SOO
					$fieldTotal = "$fieldTotalOne";
					$fieldTotalSheetAll= "$fieldTotalSheetAllOne";
					$qTotal = "$qTotalOne";
					$stats="a.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2') AND a.CustomField1='Closed' GROUP BY a.Nomor";
					//$statsAmountAndTask = "c.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='SUMMARY SALES REPORT' OR c.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='END OF DAY REPORT' GROUP BY c.Nomor";
					$statsAmountAndTask = "c.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='END OF DAY REPORT' GROUP BY c.FileTime ORDER BY c.Jam DESC";
					$fieldDailySumNilai = "c.CustomField3 as dailySumNilai";
				}
				elseif($wp=='SMT09160025' or $wp=='SMT09160027'){ //SEREH_GOURMET //210619 kode  or $wp=='SMT09160030' kepunyaan STAR
					$fieldTotal = "$fieldTotalTwo";
					$fieldTotalSheetAll= "$fieldTotalSheetAllTwo";
					$qTotal = "$qTotalOne";
					$stats="a.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2')";
					$statsAmountAndTask = "c.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2') AND c.Nomor <> '' GROUP BY c.FileTime ORDER BY c.Jam DESC";
					$fieldDailySumNilai = "'' as dailySumNilai";
				}
				elseif($wp=='SMT09160032'){ //STAR
					$fieldTotal = "$fieldTotalTwo";
					$fieldTotalSheetAll= "$fieldTotalSheetAllTwo";
					$qTotal = "$qTotalOne";
					$stats="a.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2')";
					$statsAmountAndTask = "c.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2') AND c.Nomor <> '' GROUP BY c.FileTime ORDER BY c.Jam DESC";
					$fieldDailySumNilai = "'' as dailySumNilai";
				}
				elseif($wp=='SMT09160030'){ //STAR
					$fieldTotal = "$fieldTotalTwo";
					$fieldTotalSheetAll= "$fieldTotalSheetAllTwo";
					$qTotal = "$qTotalOne";
					$stats="a.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2')";
					$statsAmountAndTask = "c.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2') AND c.Nomor <> '' GROUP BY c.FileTime ORDER BY c.Jam DESC";
					$fieldDailySumNilai = "'' as dailySumNilai";
				}
				elseif($wp=='SMT09160021'){ //BUNS_N_MEAT
					$fieldTotal = "$fieldTotalTwo";
					$fieldTotalSheetAll= "$fieldTotalSheetAllTwo";
					$stats="a.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2') AND CustomField1='Closed Bill'";
					$statsAmountAndTask = "c.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='' GROUP BY c.FileTime ORDER BY c.Jam DESC ";
					$fieldDailySumNilai = "'' as dailySumNilai";
				}
				elseif($wp=='SMT09160023'){ //BARREL
					$fieldTotal= "$fieldTotalOne";
					$fieldTotalSheetAll= "$fieldTotalSheetAllOne";
					$qTotal= "$qTotalOne";
					$stats="a.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2') AND CustomField1='Closed' ";
					//$statsAmountAndTask = "c.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='SUMMARY SALES REPORT' OR c.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='END OF DAY REPORT' ";
					$statsAmountAndTask = "c.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2') AND ( (c.CustomField1 = 'END OF DAY REPORT') OR c.CustomField1 = 'SUMMARY SALES REPORT') GROUP BY c.FileTime ORDER BY c.Jam DESC ";
					$fieldDailySumNilai = "c.Nilai as dailySumNilai";
				}
				elseif( $wp=='SMT09160028'){ //CHIR_CHIR
					$fieldTotal = "$fieldTotalOne";
					$fieldTotalSheetAll= "$fieldTotalSheetAllOne";
					$qTotal = "$qTotalOne";
					$stats = "a.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2') AND CustomField1='Closed'";
					//$statsAmountAndTask = "c.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='SUMMARY SALES REPORT' OR c.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='END OF DAY REPORT' ";
					$statsAmountAndTask = "c.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='END OF DAY REPORT' GROUP BY c.FileTime ORDER BY c.Jam DESC ";
					$fieldDailySumNilai = "c.CustomField3 as dailySumNilai";
				}
				elseif($wp=='SMT09160029'){ //FISH_N_CO
					$fieldTotal = "$fieldTotalTwo";
					$fieldTotalSheetAll= "$fieldTotalSheetAllOne";
					$qTotal = "$qTotalOne";
					$stats="a.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2') AND a.CustomField1='Bill Closed' AND a.Nomor <> '' GROUP BY a.Nomor";
					$statsAmountAndTask = "c.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='NETT SALES' AND c.Nomor <> '' GROUP BY c.FileTime ORDER BY c.Jam DESC";
					$fieldDailySumNilai = "c.CustomField3 as dailySumNilai";
				}
				elseif($wp=='SMT09160034'){ //PERIPLUS
					//$stats="a.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2') AND CustomField1='closing shift'";
					$fieldTotal = "$fieldTotalOne";
					$fieldTotalSheetAll= "$fieldTotalSheetAllOne";
					$qTotal = "$qTotalOne";
					$stats="a.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2')";
					$statsAmountAndTask = "c.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='CLOSING HARIAN' GROUP BY c.FileTime ORDER BY c.Jam DESC ";
					$fieldDailySumNilai = "c.CustomField3 as dailySumNilai";
				}
				elseif( $wp=='SMT09160036'){ //krisna
					$fieldTotal = "$fieldTotalThree";
					$fieldTotalSheetAll = "$fieldTotalSheetAllThree";
					$qTotal = "$qTotalOne";
					$stats = "a.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2') GROUP BY a.Nomor,a.Tanggal,a.Jam";
					$statsAmountAndTask = "c.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='Laporan Penjualan Harian Total' OR c.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='' GROUP BY c.FileTime ORDER BY c.Jam DESC";
					$fieldDailySumNilai = "'' as dailySumNilai";
				}
				elseif($wp=='SMT09160039'){ // KRISNA
					$fieldTotal = "$fieldTotalThree";
					$fieldTotalSheetAll = "$fieldTotalSheetAllThree";
					$qTotal = "$qTotalOne";
					$stats = "a.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2') GROUP BY a.Nomor,a.Tanggal,a.Jam";
					$statsAmountAndTask = "c.DeviceId ='$wp' AND date(FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='Laporan Penjualan Harian Total' GROUP BY c.FileTime ORDER BY  DATE_FORMAT(c.FileTime,'%H:%i:%s') DESC";
					$fieldDailySumNilai = "c.CustomField3 as dailySumNilai";
				}
				else{
					if(!empty($tenant)){
						$fieldTotal = "$fldTotPerTnt";
						$fieldTotalSheetAll= "$fieldTotSheetAllTnt";
						$qTotal = "$qTotPerTnt";
						if($tenant=='BUNS_N_MEAT'){
							$stats = "b.flag ='$tenant' AND date(a.FileTime) Between date('$dt1') AND date('$dt2') AND CustomField1='Closed Bill'";
							$statsAmountAndTask = "c.flag ='$tenant' AND date(a.FileTime) Between date('$dt1') AND date('$dt2') AND a.CustomField1 ='' GROUP BY c.FileTime ORDER BY c.Jam DESC ";
							$fieldDailySumNilai = "'' as dailySumNilai";
						}
						elseif($tenant=='BASE_BASE'){
							$stats = "b.flag ='$tenant' AND date(a.FileTime) Between date('$dt1') AND date('$dt2') AND a.CustomField1='Closed' GROUP BY a.Nomor";
							//$statsAmountAndTask = "c.flag ='$tenant' AND date(a.FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='SUMMARY SALES REPORT' OR b.flag ='$tenant' AND date(c.FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='END OF DAY REPORT' GROUP BY c.Nomor";
							$statsAmountAndTask = "b.flag ='$tenant' AND date(c.FileTime) Between date('$dt1') AND date('$dt2') AND ( (c.CustomField1 = 'END OF DAY REPORT') OR c.CustomField1 = 'CASHIER SHIFT REPORT') GROUP BY c.FileTime ORDER BY c.Jam DESC";
							$fieldDailySumNilai = "c.CustomField3 as dailySumNilai";
						}
						elseif($tenant=='PAT_BING_SOO'){
							$stats = "b.flag ='$tenant' AND date(a.FileTime) Between date('$dt1') AND date('$dt2') AND a.CustomField1='Closed' GROUP BY a.Nomor";
							//$statsAmountAndTask = "c.flag ='$tenant' AND date(a.FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='SUMMARY SALES REPORT' OR b.flag ='$tenant' AND date(c.FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='END OF DAY REPORT' GROUP BY c.Nomor";
							$statsAmountAndTask = "b.flag ='$tenant' AND date(c.FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='END OF DAY REPORT' GROUP BY c.FileTime ORDER BY c.Jam DESC";
							$fieldDailySumNilai = "c.CustomField3 as dailySumNilai";
						}
						elseif($tenant=='BARREL'){
							$stats = "b.flag ='$tenant' AND date(a.FileTime) Between date('$dt1') AND date('$dt2') AND a.CustomField1='Closed'";
							//$statsAmountAndTask = "b.flag ='$tenant' AND date(c.FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='SUMMARY SALES REPORT' OR b.flag ='$tenant' AND date(c.FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='END OF DAY REPORT' ";
							//$statsAmountAndTask = "b.flag ='$tenant' AND date(c.FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='END OF DAY REPORT' GROUP BY c.FileTime ORDER BY c.Jam DESC ";
							$statsAmountAndTask = "b.flag ='$tenant' AND date(c.FileTime) Between date('$dt1') AND date('$dt2') AND ( (c.CustomField1 = 'END OF DAY REPORT') OR c.CustomField1 = 'SUMMARY SALES REPORT' ) GROUP BY c.FileTime ORDER BY c.Jam DESC ";
							$fieldDailySumNilai = "c.Nilai as dailySumNilai";
						}
						elseif($tenant=='CHIR_CHIR'){
							$stats = "b.flag ='$tenant' AND date(a.FileTime) Between date('$dt1') AND date('$dt2') AND a.CustomField1='Closed'";
							//$statsAmountAndTask = "b.flag ='$tenant' AND date(c.FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='SUMMARY SALES REPORT' OR b.flag ='$tenant' AND date(c.FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='END OF DAY REPORT' ";
							$statsAmountAndTask = "b.flag ='$tenant' AND date(c.FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='END OF DAY REPORT' GROUP BY c.FileTime ORDER BY c.Jam DESC ";
							$fieldDailySumNilai = "c.CustomField3 as dailySumNilai";
						}
						elseif($tenant=='PERIPLUS'){
							$stats = "b.flag ='$tenant' AND date(a.FileTime) Between date('$dt1') AND date('$dt2') GROUP BY a.Nomor,a.Tanggal,a.Jam";
							$statsAmountAndTask = "b.flag ='$tenant' AND date(c.FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='CLOSING HARIAN' GROUP BY c.FileTime ORDER BY c.Jam DESC";
							$fieldDailySumNilai = "c.CustomField3 as dailySumNilai";
						}
						elseif($tenant=='FISH_N_CO'){
							$stats = "b.flag ='$tenant' AND date(a.FileTime) Between date('$dt1') AND date('$dt2') AND a.CustomField1='Bill Closed' AND a.Nomor <> '' GROUP BY a.Nomor";
							$statsAmountAndTask = "b.flag ='$tenant' AND date(c.FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='NETT SALES' AND c.Nomor <> '' GROUP BY c.FileTime ORDER BY c.Jam DESC";
							$fieldDailySumNilai = "c.CustomField3 as dailySumNilai";
						}
						elseif($tenant=='Krisna2'){
							$stats = "b.flag ='$tenant' AND date(a.FileTime) Between date('$dt1') AND date('$dt2') GROUP BY a.Nomor,a.Tanggal,a.Jam";
							$statsAmountAndTask = "b.flag ='$tenant' AND date(c.FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='Laporan Penjualan Harian Total' OR b.flag ='$tenant' AND date(c.FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='' GROUP BY c.FileTime ORDER BY c.Jam DESC";
							$fieldDailySumNilai = "'' as dailySumNilai";
						}
						elseif($tenant=='Krisna1' or $tenant=='KRISNA'){
							$stats = "b.flag ='$tenant' AND date(a.FileTime) Between date('$dt1') AND date('$dt2') GROUP BY a.Nomor,a.Tanggal,a.Jam";
							$statsAmountAndTask = "b.flag ='$tenant' AND date(c.FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='Laporan Penjualan Harian Total' GROUP BY c.FileTime ORDER BY DATE_FORMAT(c.FileTime,'%H:%i:%s') DESC";
							$fieldDailySumNilai = "c.CustomField3 as dailySumNilai";
						}
						elseif($tenant=='SEREH_GOURMET'){
							$stats = "b.flag ='$tenant' AND date(a.FileTime) Between date('$dt1') AND date('$dt2')";
							$statsAmountAndTask = "b.flag ='$tenant' AND date(c.FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='' GROUP BY c.FileTime ORDER BY c.Jam DESC";
							$fieldDailySumNilai = "'' as dailySumNilai";
						}
						elseif($tenant=='STAR'){
							$stats = "b.flag ='$tenant' AND date(a.FileTime) Between date('$dt1') AND date('$dt2')";
							$statsAmountAndTask = "b.flag ='$tenant' AND date(c.FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='' GROUP BY c.FileTime ORDER BY c.Jam DESC";
							$fieldDailySumNilai = "'' as dailySumNilai";
						}
						else{
							$stats = "b.flag ='$tenant' AND date(a.FileTime) Between date('$dt1') AND date('$dt2') AND CustomField1='Closed'";
							//$stats = "b.flag ='$tenant' AND date(a.FileTime) Between date('$dt1') AND date('$dt2')"; 
							$statsAmountAndTask = "b.flag ='$tenant' AND date(c.FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='' GROUP BY c.FileTime ORDER BY c.Jam DESC ";
							$fieldDailySumNilai = "'' as dailySumNilai";
						}
					}
					elseif(!empty($jnsPenjln)){
						$fieldTotal = "$fieldTotalOne";
						$fieldTotalSheetAll= "$fieldTotalSheetAllOne";
						$qTotal = "$qTotalOne";
						$stats="b.JenisPenjualan ='$jnsPenjln' AND date(a.FileTime) Between date('$dt1') AND date('$dt2')"; 
						$statsAmountAndTask = "b.JenisPenjualan ='$jnsPenjln' AND date(c.FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='' GROUP BY c.FileTime ORDER BY c.Jam DESC ";
						$fieldDailySumNilai = "'' as dailySumNilai";
					}
					else{
						$fieldTotal = "$fieldTotalOne";
						$fieldTotalSheetAll= "$fieldTotalSheetAllOne";
						$qTotal = "$qTotalOne";
						$stats="a.DeviceId ='$wp' AND date(a.FileTime) Between date('$dt1') AND date('$dt2')"; 
						$statsAmountAndTask = "c.DeviceId ='$wp' AND date(c.FileTime) Between date('$dt1') AND date('$dt2') AND c.CustomField1 ='' GROUP BY c.FileTime ORDER BY c.Jam DESC ";
						$fieldDailySumNilai = "'' as dailySumNilai";
					}
				}
			}
			
			if($i==0){ //sheet monthly
				$objWorkSheet->setCellValue('A1','DeviceId')
					->setCellValue('B1','Tenant')
					->setCellValue('C1','Date')
				->setCellValue('D1','Total Transaction');
				
				$sql="
					SELECT c.DeviceId,c.Tenant, c.DateTime , sum(c.total1) as total, $fieldTotal as Total2
					FROM(
						SELECT distinct a.Nomor, DATE_FORMAT(a.FileTime,'%Y-%m')as DateTime, a.DeviceId ,b.Tenant, 
							$qTotal
							,if(a.nilaidanpajak like '%,%',replace(a.nilaidanpajak,',',''),replace(a.nilaidanpajak,'.',''))as total1
						FROM Transaksi a JOIN Tenant b ON a.DeviceId=b.DeviceId
					WHERE $stats) as c
					GROUP BY c.DeviceId,c.Tenant,c.DateTime";
				
				$transaction = $this->db->query($sql)->result();
				$rows = 2;
				foreach($transaction as $row){
					$objWorkSheet->setCellValue('A'.$rows,$row->DeviceId)
												->setCellValue('B'.$rows, $row->Tenant)
												->setCellValue('C'.$rows, $row->DateTime)
												->setCellValue('D'.$rows, $row->Total2);		
												$rows++;		
				}
				$objWorkSheet->setTitle("Monthly");
				$objWorkSheet->getColumnDimension('A')->setWidth(20);
				$objWorkSheet->getColumnDimension('B')->setWidth(20);
			}
			elseif($i==1){ //sheet daily
				$objWorkSheet->setCellValue('A1','DeviceId')
							->setCellValue('B1','Tenant')
							->setCellValue('C1','Date')
							->setCellValue('D1','Total Transaction');
				
				$sql="
					SELECT c.DeviceId,c.Tenant, c.date,sum(c.total1) as total,$fieldTotal as Total2
					FROM(
						SELECT distinct a.Nomor, date(a.FileTime)as date, a.DeviceId ,b.Tenant, 
							$qTotal
							,if(a.nilaidanpajak like '%,%',replace(a.nilaidanpajak,',',''),replace(a.nilaidanpajak,'.',''))as total1
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
			elseif($i==2){ //sheet all
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
						if(a.nilai like '%,%',replace(a.nilai,',',''),replace(a.nilai,'.',''))as Amount,
						if(a.Pajak like '%,%',replace(a.Pajak,',',''),replace(a.Pajak,'.','')) AS Pajak,
						$fieldTotalSheetAll as total,
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
												->setCellValue('E'.$rows, $row->Amount)
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
			elseif($i==3){ //sheet daily summary
				$objWorkSheet->setCellValue('A1','DeviceId')
							->setCellValue('B1','Tenant')
							->setCellValue('C1','Date')
							->setCellValue('D1','Date Bills')
							->setCellValue('E1','Nilai')
							->setCellValue('F1','Keterangan');
				
				/* $sql="SELECT c.Jam, c.Nomor, date(c.FileTime)as date, c.Tanggal as date_bills, c.DeviceId ,b.Tenant
						, if(c.nilaidanpajak like '%,%',replace(c.nilaidanpajak,',',''),replace(c.nilaidanpajak,'.','')) as AmountWithTask
						, $fieldDailySumNilai
						, c.CustomField1 as Description
						FROM Transaksi c 
						JOIN Tenant b ON c.DeviceId=b.DeviceId
						WHERE $statsAmountAndTask
					"; */
				
				$sql="SELECT * FROM (
						SELECT c.Jam, c.Nomor, date(c.FileTime)as date, c.Tanggal as date_bills, c.DeviceId, b.Tenant,c.CustomField3,
						$fieldDailySumNilai,
						c.CustomField1 as Description
						FROM Transaksi c 
						JOIN Tenant b ON c.DeviceId=b.DeviceId 
						WHERE $statsAmountAndTask
					) tmp
					GROUP BY date
					ORDER BY date ASC
				";
				
				$transaction = $this->db->query($sql)->result();
				$rows = 2;
				foreach($transaction as $row){
					$objWorkSheet->setCellValue('A'.$rows,$row->DeviceId)
												->setCellValue('B'.$rows, $row->Tenant)
												->setCellValue('C'.$rows, $row->date)
												->setCellValue('D'.$rows, $row->date_bills)
												->setCellValue('E'.$rows, $row->dailySumNilai)
												->setCellValue('F'.$rows, $row->Description);
					$rows++;
				}
				$objWorkSheet->setTitle("Daily Summary");
				$objWorkSheet->getColumnDimension('A')->setWidth(20);
				$objWorkSheet->getColumnDimension('B')->setWidth(20);
				$objWorkSheet->getColumnDimension('C')->setWidth(20);
			}
			$i++;
		}
		
		$obj->removeSheetByIndex(4);
		$filename='Transaction.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (AND adjust the filename extension, also the header mime type)
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
		//input deviceID AND Tenant to tenant table
		$ddTenantHdn = $this->input->post('ddTenantHdn');
		$tenanReplace = preg_replace('/\s+/', '', $ddTenantHdn);
		
		$deviceId = $tenanReplace."-MANUAL";
		$flag = str_replace(' ', '_', $ddTenantHdn);
		$flag = str_replace('-', '_', $flag);
		$qSql = $this->Model_Transaction->get_by_two_param(TBL_TENANT,'DeviceId',$deviceId,'Tenant',$ddTenantHdn);
		
		/*$qSql = "SELECT DeviceId FROM tenant WHERE Tenant='$ddTenantHdn' AND DeviceId='' ";
		$rSql = $this->db->query($qSql)->row();*/
		
		if(empty($qSql)){
			$dataTenant = array(
				//'DeviceId' => $this->input->post('txtDevice', TRUE),
				'DeviceId' => $deviceId,
				'Tenant' => $ddTenantHdn,
				'flag' => strtoupper($flag)
			);
			$this->Model_Transaction->save($dataTenant, TBL_TENANT);
		}
		else{
			$data = array(
				//'DeviceId' => $this->input->post('txtDevice', TRUE),
				'DeviceId' => $deviceId,
				'flag' => strtoupper($flag)
			);
			$id = $qSql->id;
			$this->Model_Transaction->update(TBL_TENANT, array('id' => $id), $data);
		}
		
		//input deviceID AND Tenant to device table
		/*$dataDevice = array(
			'DeviceId' => $this->input->post('txtDevice', TRUE),
			'tenant' => $this->input->post('ddTenant', TRUE),
			'IsManual' => 1
		);
		$this->Model_Transaction->save($dataDevice, 'devicetable');*/
		
		//input transaction
		$dataTransaction = array(
			//'DeviceId' => $this->input->post('txtDevice', TRUE),
			'DeviceId' => $deviceId,
			'RefSN' => $this->input->post('txtRefSN', TRUE),
			'FileTime' => date("Y-m-d H:i:s"),
			'Nomor' => $this->input->post('txtNoTransaction', TRUE),
			'Tanggal' => $this->input->post('txtTanggal', TRUE),
			//'Jam' => $this->input->post('txtJam', TRUE),
			'Jam' => date('h:i:s'),
			'Nilai' => $this->input->post('txtAmount', TRUE),
			'Pajak' => $this->input->post('txtTax', TRUE),
			'NilaiDanPajak' => $this->input->post('txtTotal', TRUE),
			'CustomField1' => $this->input->post('txtKeterangan', TRUE),
			'CustomField2' => $this->input->post('txtDiskon', TRUE),
			'CustomField3' => $this->input->post('txtNetSales', TRUE)
		);
		
		$this->Model_Transaction->save($dataTransaction, TBL_TRANSAKSI);
		echo json_encode(array("status" => true));
	}
}