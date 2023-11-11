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
	<meta content="" name="keywords">
	<meta content="" name="description">

	<!-- Favicons -->
	<link  href="img/baguiologo.png" rel="icon">
	<link rel="apple-touch-icon" href="img/baguiologo.png">
	
	<meta content="width-device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="bower_components/Ionicons/css/ionicons.min.css">
	<link rel="stylesheet" type="text/css" href="../dist/css/AdminLTE.min.css">
	<link rel="stylesheet" type="text/css" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../dist/css/skins/skin-blue-light.min.css">
	<link rel="stylesheet" type="text/css" href="../bower_components/font-awesome/css/font-awesome.min.css">

	<style>
		.big-text {
		    font-size: 30px; /* Adjust the font size as needed */
		}
	</style>

	
	
</head>
<body class="hold-transition skin-blue-light layout-top-nav">
	<div class="wrapper">
		<?php include_once("../user_page1/header/header.php");
		?>
		<div class="content-wrapper">
		<section class="content-header">
			<h1><i class="fa fa fa-tachometer"></i>
			DASHBOARD</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"> DASHBOARD</i></a></li>
			</ol>
		</section>
		<section class="content container-fluid">
			<div class="box box-primary">
				<div class="box-header with-border bg-blue text-center">
					<h3 class="box-title">PPE AND SEMI-EXPENDABLE PROPERTIES</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-lg-3 col-sx-3">
							<a href="active_PPE.php" class="box-link">
								<div class="small-box bg-green">
									<div class="inner">
										<h3><?php
											$query = "SELECT COUNT(*) as total FROM are_properties WHERE currentconditionid IN ('Serviceable', 'Continued In Service', 'Transferred Without Cost')";
											$stmt = $connect->prepare($query);
											$stmt->execute();
											$result = $stmt->get_result();
											$row = $result->fetch_assoc();
											$count = $row['total'];

											// Check if $count is null or zero, and provide a default value if necessary
											if ($count === null || $count == 0) {
											    $count = 0;
											}
											echo $count;
											?>
										</h3>
										<h4 class="big-text">ACTIVE ARE</h4>
									</div>
									<div class="icon">
										<i class="fa fa-book"></i>
									</div>
								</div>
							</a>
						</div><!-- END Of ACTIVE ARE -->
						<div class="col-lg-3 col-sx-6">
							<a href="active_semi_expendable.php" class="box-link">
								<div class="small-box bg-green">
									<div class="inner">
										<h3><?php
											$query = "SELECT COUNT(*) as total FROM ics_properties WHERE currentcondition IN ('Serviceable', 'Continued In Service', 'Transferred Without Cost')";
											$stmt = $connect->prepare($query);
											$stmt->execute();
											$result = $stmt->get_result();
											$row = $result->fetch_assoc();
											$count = $row['total'];

											// Check if $count is null or zero, and provide a default value if necessary
											if ($count === null || $count == 0) {
											    $count = 0;
											}
											echo $count;
											?>
										</h3>
										<h4 class="big-text">ACTIVE ICS</h4>
									</div>
									<div class="icon">
										<i class="fa fa-book"></i>
									</div>
								</div>
							</a>
						</div><!-- END Of ACTIVE ICS -->
						<div class="col-lg-3 col-sx-6">
							<a href="inactivePPE.php" class="box-link">
								<div class="small-box bg-red">
									<div class="inner">
										<h3><?php
											$query = "SELECT COUNT(*) as total FROM are_properties WHERE currentconditionid IN ('Returned', '
											Destroyed Or Condemned')";
											$stmt = $connect->prepare($query);
											$stmt->execute();
											$result = $stmt->get_result();
											$row = $result->fetch_assoc();
											$count = $row['total'];

											// Check if $count is null or zero, and provide a default value if necessary
											if ($count === null || $count == 0) {
											    $count = 0;
											}
											echo $count;
											?>
										</h3>
										<h4 class="big-text">INACTIVE ARE</h4>
									</div>
									<div class="icon">
										<i class="fa fa-times-circle"></i>
									</div>
								</div>
							</a>
						</div><!-- END Of INACTIVE ARE -->
						<div class="col-lg-3 col-sx-6">
							<a href="inactiveSemi.php" class="box-link">
								<div class="small-box bg-red">
									<div class="inner">
										<h3><?php
											$query = "SELECT COUNT(*) as total FROM ics_properties WHERE currentcondition IN ('Returned', '
											Destroyed Or Condemned')";
											$stmt = $connect->prepare($query);
											$stmt->execute();
											$result = $stmt->get_result();
											$row = $result->fetch_assoc();
											$count = $row['total'];

											// Check if $count is null or zero, and provide a default value if necessary
											if ($count === null || $count == 0) {
											    $count = 0;
											}
											echo $count;
											?>
										</h3>
										<h4 class="big-text">INACTIVE ICS</h4>
									</div>
									<div class="icon">
										<i class="fa fa-times-circle"></i>
									</div>
								</div>
							</a>
						</div><!-- END Of INACTIVE ICS -->
					</div><!-- row -->
				</div><!-- box-body -->
			</div><!-- box primary -->
			<!-- PRS and WMR -->
			<div class="box box-primary">
				<div class="box-header with-border bg-blue text-center">
					<h3 class="box-title">PRS and WMR MASTER LIST</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-lg-3 col-sx-6">
							<a href="PRS.php" class="box-link">
								<div class="small-box bg-orange">
									<div class="inner">
										<h3><?php
											$query = "SELECT COUNT(*) as total FROM prs_properties WHERE type = 'PRS'";
											$stmt = $connect->prepare($query);
											$stmt->execute();
											$result = $stmt->get_result();
											$row = $result->fetch_assoc();
											$count = $row['total'];

											// Check if $count is null or zero, and provide a default value if necessary
											if ($count === null || $count == 0) {
											    $count = 0;
											}
											echo $count;
											?>
										</h3>
										<h4 class="big-text">PRS</h4>
									</div>
									<div class="icon">
										<i class="fa fa-times"></i>
									</div>
								</div>
							</a>
						</div><!-- END Of INACTIVE ARE -->
						<div class="col-lg-3 col-sx-6">
							<a href="WMR.php" class="box-link">
								<div class="small-box bg-orange">
									<div class="inner">
										<h3><?php
											$query = "SELECT COUNT(*) as total FROM prs_properties WHERE type = 'WMR'";
											$stmt = $connect->prepare($query);
											$stmt->execute();
											$result = $stmt->get_result();
											$row = $result->fetch_assoc();
											$count = $row['total'];

											// Check if $count is null or zero, and provide a default value if necessary
											if ($count === null || $count == 0) {
											    $count = 0;
											}
											echo $count;
											?>
										</h3>
										<h4 class="big-text">WMR</h4>
									</div>
									<div class="icon">
										<i class="fa fa-times"></i>
									</div>
								</div>
							</a>
						</div><!-- END Of INACTIVE ICS -->
					</div><!-- row -->
				</div><!-- box-body -->
			</div><!-- box primary -->

		</section><!-- content container fluid -->
	</div><!-- content-wrapper -->
</div><!-- wrapper -->
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="../bower_components/fastclick/lib/fastclick.js"></script>
<script src="../dist/js/adminlte.min.js"></script>

</body>
</html>