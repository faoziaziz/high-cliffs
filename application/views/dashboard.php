<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Home</a></li>
				<li class="active">Dashboard</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Tax Monitoring dashboard </h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
				<!-- begin col-3 -->
				<div class="col-md-4 col-sm-6">
					<div class="widget widget-stats bg-green">
						<div class="stats-icon"><i class="fa fa-desktop"></i></div>
						<div class="stats-info">
							<h4>Wajib Pajak</h4>
							<p><?php echo $devices; ?></p>	
						</div>
						<div class="stats-link">
							<a href="<?php echo site_url('Devices');?>">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>
					</div>
				</div>
				<!-- end col-3 -->
				<!-- begin col-3 -->
					<div class="col-md-4 col-sm-6">
					<div class="widget widget-stats bg-blue">
						<div class="stats-icon"><i class="fa fa-money"></i></div>
						<div class="stats-info">
							<h4>Transaksi Bulan Ini</h4>
							<script type="text/javascript">
							    var auto_refresh = setInterval(
							    function () {
							       $('#monthly_revenue').load('<?php echo site_url('dashboard/monthly_revenue');?>').fadeIn("slow");
							    }, 15000); // refresh setiap 10000 milliseconds
							    
							</script>
							<p id="monthly_revenue"></p>	
						</div>
						<div class="stats-link">
							<a href="<?php echo site_url('Transaction');?>">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>
					</div>
				</div>
				<!-- end col-3 -->
				<!-- begin col-3 -->
				<div class="col-md-4 col-sm-6">
					<div class="widget widget-stats bg-purple">
						<div class="stats-icon"><i class="fa fa-money"></i></div>
						<div class="stats-info">
							<h4>Transaksi Hari Ini</h4>
							<script type="text/javascript">
							    var auto_refresh = setInterval(
							    function () {
							       $('#daily_revenue').load('<?php echo site_url('dashboard/daily_revenue');?>').fadeIn("slow");
							    }, 15000); // refresh setiap 10000 milliseconds
							    
							</script>
							<p id="daily_revenue"></p>		
						</div>
						<div class="stats-link">
							<a href="<?php echo site_url('Transaction');?>">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>
					</div>
				</div>
			
				<!-- end col-3 -->
				<!-- begin col-3 -->
				<!--<div class="col-md-3 col-sm-6">
					<div class="widget widget-stats bg-red">
						<div class="stats-icon"><i class="fa fa-clock-o"></i></div>
						<div class="stats-info">
							<h4>ALARM</h4>
							<p><?php echo $alarm; ?></p>	
						</div>
						<div class="stats-link">
							<a href="<?php echo site_url('Devices');?>">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>
					</div>
				</div>-->
				<!-- end col-3 -->
			</div>
			<!-- end row -->
			<!-- begin row -->
			<div class="row">
				<!-- begin col-8 -->
				
				<!-- end col-8 -->
				<!-- begin col-4 -->
				<!--
				<div class="col-md-6">
					<div class="panel panel-inverse" data-sortable-id="index-7">
						<div class="panel-heading">
							<div class="panel-heading-btn">
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
									
							</div>
							<h4 class="panel-title">Last Capture Alarm</h4>
							<a href="<?php echo site_url('Alarm');?>">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>
						<div class="panel-body p-t-0">
							<table id="data-table" class="table table-striped table-bordered">
								<thead>
									<tr>	
										<th>Date</th>
										<th>Device Name</th>
										<th>Alarm</th>
									</tr>
								</thead>
								<tbody>

								<?php
									foreach($last_alarm as $row){
									
								?>
									<tr>
										<td><?php echo $row->date; ?>
										<td><?php echo $row->CompanyName; ?>
										<?php
											if($row->alarmtype>100){
												echo "<td><label class='label label-success'>$row->description</label</td>";
											}
											else{
												echo "<td><label class='label label-danger'>$row->description</label</td>";
											}
										}
										?>
									
									</tr>	

									
								</tbody>
							</table>
						</div>
					</div>
					
				
				</div>
				-->
				<!-- end col-4 -->
			</div>
			<div class="row">
					<div class="col-md-12 col-sm-12">
						<?php
						    /* Mengambil query report*/
						    if(!empty($chart)){
							    foreach($chart as $result){
							        $Device[] = $result->Tenant; 
							        $value[] = (float) $result->total; 
							    }
						    /* end mengambil query*/
						    }
						?>
						<div id="report"></div>
					</div>
					
			</div>
			<div class="row" style="margin-top:20px;">
				<div class="col-md-6">
						<?php
						    /* Mengambil query report*/
						    if(!empty($revenue_year)){
							    foreach($revenue_year as $result){
							        $month[] = $result->month; 
							        $value1[] = (float) $result->total; 
							    }
						    /* end mengambil query*/
						     }
						?>
						<div id="report1"></div>
					</div>
					<div class="col-md-6">
						<?php
							if(!empty($revenue_device)){
							    /* Mengambil query report*/
							    foreach($revenue_device as $result){
							        $Device2[] = $result->DeviceId; 
							        $value2[] = (float) $result->total; 
							    }
						    /* end mengambil query*/
						     }
						?>
						<div id="report2"></div>
					</div>
			</div>
			<!-- end row -->
		</div>

	<script src="<?php echo base_url(); ?>assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>

	<script type="text/javascript" src="<?php echo base_url('assets/highcharts/highcharts.js'); ?>"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>

	<script type="text/javascript">
		var auto_refresh = setInterval(
		function () {
			$.ajax({
				type:"POST",
				url : '<?php echo site_url('email/send2'); ?>',
				data :'',
				success:function(html){
					
				}
			});
		}, 33000); // refresh setiap 16000 milliseconds
		
		var auto_refresh2 = setInterval(
			function () {
			   location.reload();
			}, 180000); // refresh setiap 10000 milliseconds
	</script>
	
	<script type="text/javascript">
		$(function () {
			$('#report').highcharts({

				responsive: {
				  rules: [{
					condition: {
					  maxWidth: 500
					},
					chartOptions: {
					  legend: {
						enabled: false
					  }
					}
				  }]
				},

				chart: {
					type: 'column',
					margin: 75,
					options3d: {
						enabled: false,
						alpha: 10,
						beta: 25,
						depth: 70
					}
				},
				title: {
					text: 'Report Statistik Pendapatan Bulan Ini',
					style: {
							fontSize: '18px',
							fontFamily: 'Verdana, sans-serif'
					}
				},
				subtitle: {
				   text: 'Bulan <?php echo date('m') ?>',
				  //text:'Bulan Mei',
				   style: {
							fontSize: '15px',
							fontFamily: 'Verdana, sans-serif'
					}
				},
			   
				credits: {
					enabled: false
				},
				xAxis: {
					categories:  <?php echo json_encode($Device);?>
					
				},
			  
				yAxis: {
					title: {
						text: 'Total (Rp)'
					},

				},
				/*
				tooltip: {
					 formatter: function() {
						 return 'The value for <b>' + this.x + '</b> is <b>' + Highcharts.numberFormat(this.y,0) + '</b>, in '+ this.series.name;
					 }
				  },*/
				series: [{
					name: 'Tenant',
					data: <?php echo json_encode($value);?>,
					shadow : true,
					dataLabels: {
						enabled: true,
						color: '#045396',
						align: 'center',
						
						y: 0, // 10 pixels down from the top
						style: {
							fontSize: '8px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				}]
			});
		});
	</script>


	<script type="text/javascript">
		$(function () {
			$('#report1').highcharts({
				chart: {
					type: 'line',
					margin: 75,
					options3d: {
						enabled: false,
						alpha: 10,
						beta: 25,
						depth: 70
					}
				},
				title: {
					text: 'Report Statistik Pendapatan Tiap Bulan',
					style: {
							fontSize: '18px',
							fontFamily: 'Verdana, sans-serif'
					}
				},
				subtitle: {
				  // text: 'Bulan <?php echo date('m') ?>',
				  //text:'Bulan Mei',
				   style: {
							fontSize: '15px',
							fontFamily: 'Verdana, sans-serif'
					}
				},
				plotOptions: {
					column: {
						depth: 25
					}
				},
				credits: {
					enabled: false
				},
				xAxis: {
					categories:  <?php echo json_encode($month);?>
					
				},
			  
				yAxis: {
					title: {
						text: 'Total (Rp)'
					},

				},
				/*
				tooltip: {
					 formatter: function() {
						 return 'The value for <b>' + this.x + '</b> is <b>' + Highcharts.numberFormat(this.y,0) + '</b>, in '+ this.series.name;
					 }
				  },*/
				series: [{
					name: 'Tenant',
					data: <?php echo json_encode($value1);?>,
					shadow : true,
					dataLabels: {
						enabled: true,
						color: '#045396',
						align: 'center',
						
						y: 0, // 10 pixels down from the top
						style: {
							fontSize: '8px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				}]
			});
		});
	</script>

	<script type="text/javascript">
		$(function () {

			Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
				return {
					radialGradient: {
						cx: 0.5,
						cy: 0.3,
						r: 0.7
					},
					stops: [
						[0, color],
						[1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
					]
				};
			});

			$('#report2').highcharts({
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false,
					type: 'pie'
				},
				title: {
					text: 'Pendapatan Divais Tahun Ini',
					style: {
							fontSize: '18px',
							fontFamily: 'Verdana, sans-serif'
					}
				},
			  
				plotOptions: {
					column: {
						depth: 25
					}
				},
				credits: {
					enabled: false
				},
			   
				legend: {
					enabled: true
				},
			  
				  
				series: [{
				   name:'Pendapatan : ',
					data: [
						<?php
							if(count($revenue_device)>0){
								foreach($revenue_device as $data){
									echo "['" .$data->DeviceId . "'," . $data->total . "],\n";
									
								}
							}

						?>
					]
				   
				}]
			});
		});
	</script>