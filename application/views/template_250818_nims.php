
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<!-- Mirrored from seantheme.com/color-admin-v2.0/admin/html/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 18 Nov 2016 02:17:40 GMT -->
<head>
	<meta charset="utf-8" />
	<title>Dashboard | Trumon</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	
	<link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/plugins/Material-Design-Iconic-font/css/material-design-iconic-font.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/css/animate.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/css/style.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/css/style-responsive.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/css/theme/default.css" rel="stylesheet" id="theme" />
	<!-- ================== END BASE CSS STYLE ================== -->
	<link href="<?php echo base_url(); ?>assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
	<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
	<link href="<?php echo base_url(); ?>assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" />
	  

    <link href="<?php echo base_url(); ?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
        
	<!-- ================== END PAGE LEVEL STYLE ================== -->

		<!-- Important Owl stylesheet -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/owl-carousel/owl.carousel.css">
	 
	<!-- Default Theme -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/owl-carousel/owl.theme.css">
	 
	<!--  jQuery 1.7+  -->

	 
<!-- Include js plugin -->

	
	<link href="<?php echo base_url(); ?>assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />


	<link href="<?php echo base_url(); ?>assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />

	<link href="<?php echo base_url(); ?>assets/css/MonthPicker.min.css" rel="stylesheet" />

	<!-- ================== BEGIN BASE JS ================== -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-1.9.1.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/pace/pace.min.js"></script>


	


   <script src="<?php echo base_url(); ?>assets/jquery-ui/jquery-ui.min.js"></script>
 
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/jquery-ui/jquery-ui.css">
 
	<script src="<?php echo base_url(); ?>assets/js/MonthPicker.min.js"></script>
	
	<style>
.ui-datepicker-calendar {
    display: none;
    }
</style>
	
	<!-- ================== END BASE JS ================== -->
</head>
<body>
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	
	<!-- begin #page-container -->
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<!-- begin #header -->
		<div id="header" class="header navbar navbar-default navbar-fixed-top">
			<!-- begin container-fluid -->
			<div class="container-fluid">
				<!-- begin mobile sidebar expand / collapse button -->
				<div class="navbar-header">
					<a href="<?php echo site_url('Welcome');?>" class="navbar-brand"></span> SAMASTA </a>
					<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<!-- end mobile sidebar expand / collapse button -->
				
				<!-- begin header navigation right -->
				<ul class="nav navbar-nav navbar-right">
					
					<li class="dropdown navbar-user">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
								<img src="<?php echo base_url() ."uploads/" ?><?php echo $this->session->userdata('foto') ?> " alt="" />
							<span class="hidden-xs"><?php echo $this->session->userdata('nama_lengkap') ?></span> <b class="caret"></b>
						</a>
						<ul class="dropdown-menu animated fadeInLeft">
						
							<li><a href="<?php echo site_url('auth/logout');?>">Log Out</a></li>
						</ul>
					</li>
				</ul>
				<!-- end header navigation right -->
			</div>
			<!-- end container-fluid -->
		</div>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<div id="sidebar" class="sidebar">
			<!-- begin sidebar scrollbar -->
			<div data-scrollbar="true" data-height="100%">
				<!-- begin sidebar user -->
				<ul class="nav">
					<li class="nav-profile">
						<div class="image">
							<a href="javascript:;"><img src="<?php echo base_url() ."uploads/" ?><?php echo $this->session->userdata('foto') ?> " alt="" /></a>
						</div>
						<div class="info">
							<?php echo $this->session->userdata('nama_lengkap') ?>
							<small><?php echo $this->session->userdata('nip') ?></small>
						</div>
					</li>
				</ul>
				<!-- end sidebar user -->
				<!-- begin sidebar nav -->
				<ul class="nav">
					<li class="nav-header">Navigation</li>
						<?php
					 	 $id_level_user = $this->session->userdata('id_level_user');
                        $sql_menu = "SELECT * FROM tabel_menu WHERE id in(select id_menu from user_rule where id_level_user='$id_level_user') and is_main_menu=0";
						 $main_menu = $this->db->query($sql_menu)->result();
						foreach($main_menu as $main){
							$sub_menu = $this->db->get_where('tabel_menu',array('is_main_menu'=>$main->id));
							if($sub_menu->num_rows()>0){
								//tampilkan submenu disini

								echo "<li class='has-sub'><a href='javascript:;'>
										<i class='".$main->icon."'></i>
						    			<span>".$main->judul_menu."</span>

										</a>
										 <ul class='sub-menu'>";
										foreach($sub_menu->result() as $sub){
											echo "<li>".anchor($sub->link," <i class='".$sub->icon."'></i>". $sub->judul_menu)."</li>";
										}
									echo" </ul>
									</li>";
							}
							else{

							?>
								   <li class="<?php if ($this->uri->uri_string()== $main->link){echo 'active';} ?>" >
							<?php		
								//tampilkan main menu
								echo anchor($main->link," <i class='".$main->icon." '></i>"."<span>".$main->judul_menu."</span>" )."</li>


								";
							}
							
						}
					?>
					
			        <!-- begin sidebar minify button -->
					<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
			        <!-- end sidebar minify button -->
				</ul>
				<!-- end sidebar nav -->
			</div>
			<!-- end sidebar scrollbar -->
		</div>
		<div class="sidebar-bg"></div>
		<!-- end #sidebar -->
		
		<!-- begin #content -->
			<?php echo $contents; ?>
		<!-- end #content -->
		
        <!-- begin theme-panel -->
        
        <!-- end theme-panel -->
		
		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->
	
	<!-- ================== BEGIN BASE JS ================== -->

	<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	
	<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
		<script src="<?php echo base_url(); ?>assets/crossbrowserjs/html5shiv.js"></script>
		<script src="<?php echo base_url(); ?>assets/crossbrowserjs/respond.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="<?php echo base_url(); ?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/jquery-cookie/jquery.cookie.js"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->

<script src="<?php echo base_url(); ?>assets/js/jquery.autocomplete.js"></script>
	
	<script src="<?php echo base_url(); ?>assets/js/dashboard.min.js"></script>

	<script src="<?php echo base_url(); ?>assets/plugins/flot/jquery.flot.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/flot/jquery.flot.time.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/flot/jquery.flot.resize.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/flot/jquery.flot.pie.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/flot/jquery.flot.stack.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/flot/jquery.flot.crosshair.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/flot/jquery.flot.categories.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/apps.min.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	<script src="<?php echo base_url(); ?>assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/table-manage-default.demo.min.js"></script>
	<!--==============================HIGH CHART========================= -->
	
	<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

	 <script src="<?php echo base_url(); ?>assets/plugins/morris/raphael.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/morris/morris.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/chart-morris.demo.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/my.js"></script>
	<script>
		$(document).ready(function() {
			App.init();
			MorrisChart.init();
			Chart.init();
		});
		 /* $('#NoIconDemo').datepicker({
         	 changeMonth: true,
	        changeYear: true,
	        showButtonPanel: true,
	        dateFormat: 'mm-yy',
		        onClose: function(dateText, inst) { 
		            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
		        }
                }); 
		*/
	</script>

	

<script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','../../../../www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-53034621-1', 'auto');
      ga('send', 'pageview');

    </script>
</body>

<!-- Mirrored from seantheme.com/color-admin-v2.0/admin/html/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 18 Nov 2016 02:20:47 GMT -->
</html>
