<?php
require('./../database/connection.php');
require('../login/login_session.php');
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>GSO Asset Inventory System</title>
	<meta content="width-device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../bower_components/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="bower_components/Ionicons/css/ionicons.min.css">
	<link rel="stylesheet" type="text/css" href="../dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="../dist/css/skins/skin-blue-light.min.css">

	<!-- Favicons -->
	<link  href="img/baguiologo.png" rel="icon">
	<link rel="apple-touch-icon" href="img/baguiologo.png">

</head>
<body class="hold-transition skin-blue-light layout-top-nav">
	<div class="wrapper">
		<?php include_once("../user_page/header/header.php");?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1><i class="fa fa-file"></i> REPORTS</h1>
				<ol class="breadcrumb">
					<li><a href="dashboard.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
					<li class="active">Reports</li>
				</ol>
			</section>
			<section class="content container-fluid">
				<div class="box">
					<div class="box-header bg-blue" align="center">
						<h4 class="box-title">PRINTABLE REPORTS</h4>
					</div><br>

					<!-- <div class="row"> -->
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title"><strong>ARE Reports</strong></h3>
								<div class="box-tools pull-right">
								  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
								  </button>
								</div>
							</div>
							<!-- box header -->
							<div class="box-body">
								<div class="row">
									<!-- col -->
									<!-- Accountables -->
									<div class="col-md-4 col-sm-6 col-sx-12">
										<div class="info-box">
											<span class="info-box-icon bg-green"><i class="fa fa-files-o"></i></span>
											<div class="info-box-content">
												<span class="info-box-number">ACCOUNTABLES</span>
												<i class="fa fa-print"></i><a href="AREperAccountableEmployee.php" class="small-box-footer">Print ARE Accountable Employee Report</a>
											</div>
											<!-- info box content -->
										</div>
										<!-- info box -->
									</div>
									<!-- col --><!-- END Accountables -->
									<div class="col-md-4 col-sm-6 col-sx-12">
										<div class="info-box">
											<span class="info-box-icon bg-green"><i class="fa fa-files-o"></i></span>
											<div class="info-box-content">
												<span class="info-box-number">PER YEAR ARE REPORTS</span>
												<i class="fa fa-print"></i><a href="AREperYear.php" class="small-box-footer">ARE Report per Year</a>
											</div>
											<!-- info box content -->
										</div>
										<!-- info box -->
									</div>
									<!-- col --><!-- END ARE REPORTS -->

									<div class="col-md-4 col-sm-6 col-sx-12">
										<div class="info-box">
											<span class="info-box-icon bg-green"><i class="fa fa-files-o"></i></span>
											<div class="info-box-content">
												<span class="info-box-number">PER OFFICE/DEPARTMENT ARE REPORTS</span>
												<i class="fa fa-print"></i><a href="AREperOffice.php" class="small-box-footer">Print ARE Report Per Office/Department</a>
											</div>
											<!-- info box content -->
										</div>
										<!-- info box -->
									</div>
									<!-- col --><!-- END ARE REPORTS -->

									<div class="col-md-4 col-sm-6 col-sx-12">
										<div class="info-box">
											<span class="info-box-icon bg-green"><i class="fa fa-files-o"></i></span>
											<div class="info-box-content">
												<span class="info-box-number">PER ACCOUNT CODE ARE REPORTS</span>
												<i class="fa fa-print"></i><a href="AREperAccountCode.php" class="small-box-footer">Print ARE Report per Account Code</a>
											</div>
											<!-- info box content -->
										</div>
										<!-- info box -->
									</div>
									<!-- col --><!-- END ARE REPORTS -->

								</div>
							</div>
						</div><!-- End col-md-12 --><!-- End for ARE -->
						<br><br>
						<!-- for ICS -->
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title"><strong>ICS Reports</strong></h3>
								<div class="box-tools pull-right">
								  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
								  </button>
								</div>
							</div>
							<!-- box header -->
							<div class="box-body">
								<div class="row">
									<!-- col -->
									<!-- Accountables -->
									<div class="col-md-4 col-sm-6 col-sx-12">
										<div class="info-box">
											<span class="info-box-icon bg-orange"><i class="fa fa-files-o"></i></span>
											<div class="info-box-content">
												<span class="info-box-number">ACCOUNTABLES</span>
												<i class="fa fa-print"></i><a href="ICSperAccountableEmployee.php" class="small-box-footer">Print ICS Accountable Employee Report</a>
											</div>
											<!-- info box content -->
										</div>
										<!-- info box -->
									</div>
									<!-- col --><!-- END Accountables -->

									<div class="col-md-4 col-sm-6 col-sx-12">
										<div class="info-box">
											<span class="info-box-icon bg-orange"><i class="fa fa-files-o"></i></span>
											<div class="info-box-content">
												<span class="info-box-number">PER YEAR ICS REPORTS</span>
												<i class="fa fa-print"></i><a href="ICSperYear.php" class="small-box-footer">Print per Year ICS Report</a>
											</div>
											<!-- info box content -->
										</div>
										<!-- info box -->
									</div>
									<!-- col --><!-- END ARE REPORTS -->

									<div class="col-md-4 col-sm-6 col-sx-12">
										<div class="info-box">
											<span class="info-box-icon bg-orange"><i class="fa fa-files-o"></i></span>
											<div class="info-box-content">
												<span class="info-box-number">PER OFFICE/DEPARTMENT ICS REPORTS</span>
												<i class="fa fa-print"></i><a href="ICSperOffice.php" class="small-box-footer">Print per Office/Department ICS Report</a>
											</div>
											<!-- info box content -->
										</div>
										<!-- info box -->
									</div>
									<!-- col --><!-- END ARE REPORTS -->

									<div class="col-md-4 col-sm-6 col-sx-12">
										<div class="info-box">
											<span class="info-box-icon bg-orange"><i class="fa fa-files-o"></i></span>
											<div class="info-box-content">
												<span class="info-box-number">PER ACCOUNT ICS REPORTS</span>
												<i class="fa fa-print"></i><a href="ICSperAccountCode.php" class="small-box-footer">Print per Account ICS Report</a>
											</div>
											<!-- info box content -->
										</div>
										<!-- info box -->
									</div>
									<!-- col --><!-- END ARE REPORTS -->

								</div><!-- ICS row -->
							</div><!-- ICS box-body -->
						</div><!-- End col-md-12 --><!-- End for ARE -->
						<br><br>
						<!-- Start of PRS/WMR MASTER LIST REPORT -->
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title"><strong>PRS/WMR Master List Reports</strong></h3>
								<div class="box-tools pull-right">
								  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
								  </button>
								</div>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-md-4 col-sm-6 col-sx-12">
										<div class="info-box">
											<span class="info-box-icon bg-purple"><i class="fa fa-files-o"></i></span>
											<div class="info-box-content">
												<span class="info-box-number">PRS MASTER LIST</span>
												<i class="fa fa-print"></i><a href="prsPrintReport.php" class="small-box-footer" target="_blank">Print PRS Master List</a>
											</div><!-- info box content -->
										</div><!-- info box -->
									</div>
									<div class="col-md-4 col-sm-6 col-sx-12">
										<div class="info-box">
											<span class="info-box-icon bg-purple"><i class="fa fa-files-o"></i></span>
											<div class="info-box-content">
												<span class="info-box-number">WMR MASTER LIST</span>
												<i class="fa fa-print"></i><a href="wmrPrintReport.php" class="small-box-footer" target="_blank">Print WMR Master List</a>
											</div><!-- info box content -->
										</div><!-- info box -->
									</div>
								</div>
							</div>

						</div>
					<!-- </div> --><!-- row -->
				</div>
			</section>
		</div>	
	</div>


	<script src="../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../dist/js/moment.min.js"></script>
	<script src="../dist/js/fullcalendar.min.js"></script>
	<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="../bower_components/fastclick/lib/fastclick.js"></script>
	<script src="../dist/js/adminlte.min.js"></script>
	<script src="../bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
	        $("#year").change(function(){

	            var year  = $("#year option:selected").val();
	            $("#link").attr("href","includes/print_total_equipments.php?year="+year+"-"+10);  //-----this will change href 
	        });
	    });
	</script>
</body>
</html>