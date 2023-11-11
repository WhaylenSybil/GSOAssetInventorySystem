<header class="main-header">
	<!-- LOGO -->
	<a href="dashboard.php" class="logo">
		<!-- Mini-logo for sidebar, 50x50 pixels -->
		<span class="logo-mini"><b>GSO</b></span>

		<!-- Logo for regular state and mobile devices -->
		<span class="logo-lg" style="font-size: 30px;">GSO - Assets</span>

		<!-- Show the first name next to the logo -->
		<span class="logo-user-name"><?php echo $_SESSION['firstname']; ?></span>
	</a>

	<!-- Header Navbar: the style can be found in the header.css -->
	<nav class="navbar navbar-static-top">
		<!-- Sidebar toggle button -->
		<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
			<span class="sr-only">Toggle Navigation</span>
		</a>
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<!-- Notification -->

				<!-- User Account: Can be found in the dropdown.less -->
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img src="../dist/img/baguiologo.png" class="user-image" alt="User Image">
						<span class="hidden-xs"><?php echo $_SESSION['firstname']; ?></span>
					</a>
					<ul class="dropdown-menu">
						<!-- User Image -->
						<li class="user-header">
							<img src="../dist/img/baguiologo.png" class="img-circle" alt="User Image">
							<p>
								<?php echo $_SESSION['firstname']; ?>
								<small><?php echo $_SESSION['permission']; ?></small>
							</p>
						</li>
						<!-- Menu Footer for the User Image -->
						<li class="user-footer">
							<div class="pull-left">
								<a href="change_password.php" type="button" class="btn btn-default btn-flat">Change Password</a>
							</div>
							<div class="pull-right">
								<a href="../login/logout.php" class="btn btn-default btn-flat"><i class="fa fa-sign-out">Sign Out</i></a>
							</div>
						</li>
					</ul>
				</li>
				<!-- <li class="dropdown tasks-menu">
					<a href="help.php" class="dropdown-toggle"><i class="fa fa-question-circle"></i></a>
				</li> -->
			</ul>
		</div>
	</nav>
</header>
<!-- Sidebar -->
<!-- Left Side colum contains the logo and sidebar -->
<aside class="main-sidebar">
	
	<!-- sidebar style can be found in the sidebar.less -->
	<section class="sidebar">
		<!-- Sidebar Menu -->
		<ul class="sidebar-menu" data-widget="tree">
			<li class="header">MENU</li>
			<li class="active"><a href="dashboard.php"> <i class="fa fa-tachometer"></i><span>Registry</span>
				<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a></li>
			
			<!-- ======================================================== -->
							<!-- All Inventory Reports -->
			<!-- ======================================================== -->
			<li class="treeview">
				<a href="#"><i class="fa fa-archive"></i><span>All Inventory Reports</span></a>
				<ul class="treeview-menu">
					<li><a href="active_PPE.php">Active PPE</a></li>
					<li><a href="active_semi_expendable.php">Active Semi-Expendable</a></li>
					<li><a href="inactive.php">Inactive PPE & Semi-Expendable</a></li>
					<li><a href="all_categories.php">All Categories</a></li>
				</ul>
			</li><!-- End of all inventory reports -->
			
			<!-- ======================================================== -->
							<!-- Inventory and Reconciliation -->
			<!-- ======================================================== -->
			<!-- <li class="treeview">
				<a href="#"><i class="fa fa-floppy-o"></i><span> Inventory & Reconciliation</span>
				</a>
				<ul class="treeview-menu">
					<li><a href="movable_properties.php">Movable Properties</a></li>
					<li><a href="real_properties.php">Real Properties</a></li>
				</ul>
			</li> --><!-- end of inventory and reconciliation -->
			
			<!-- ======================================================== -->
							<!-- Disposal of Unserviceable Properties -->
			<!-- ======================================================== -->
			<li class="treeview">
				<a href="#"><i class="fa fa-times"></i><span>Unserviceable Properties</span>
					<!-- <span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span></a> -->
					<ul class="treeview-menu">
						<li><a href="PRS.php">PRS</a></li>
						<li><a href="WMR.php">WMR</a></li>
						<!-- <li><a href="IIRUP.php">IIRUP</a></li> -->
					</ul>
			</li><!-- end of disposable of unserviceable properties -->
			
			<!-- ======================================================== -->
							<!-- Monitoring of Fuel Consumption -->
			<!-- ======================================================== -->
			<!-- <li class="treeview">
				<a href="#"><i class="fa fa-car"></i><span> Fuel Consumption</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
				<ul class="treeview-menu">
					<li><a href=""></a></li>
				</ul>
			</li> --><!-- end of fuel consumption -->
			<!-- ======================================================== -->
							<!-- Clearance -->
			<!-- ======================================================== -->
			<li class="treeview">
				<a href="#"><i class="fa fa-graduation-cap"></i><span>Clearance</span></a>
				<ul class="treeview-menu">
					<li><a href="addClearance.php">New Clearance</a></li>
					<li><a href="clearance.php">Clearance Master List</a></li>
					<!-- <li><a href="IIRUP.php">IIRUP</a></li> -->
				</ul>
			</li>
							
					
			<!-- ======================================================== -->
					<!-- Add City/National Offices, Account Codes, and Employees with their respective Offices/Departments -->
			<!-- ======================================================== -->
			<li>
				<a href="others.php"><i class="fa fa-plus"></i> <span> Data List</span></a>
			</li><!-- end of Add Offices and Codes -->
			
			<!-- <li>
				<a href="clearanceDataList.php"><i class="fa fa-plus"></i> <span>Clearance Data List</span></a>
			</li> -->
			<!-- ======================================================== -->
							<!-- Printed Reports in the Sidebar -->
			<!-- ======================================================== -->
			<li>
				<a href="reports.php"><i class="fa fa-file-text"></i><span> Print Reports</span><span class="pull-right-container"></span></a>
			</li><!-- end of print reports -->
			<!-- ======================================================== -->
							<!-- Downloadables -->
			<!-- ======================================================== -->
			<li>
				<a href="downloadables.php"><i class="fa fa-cloud-download"></i><span> Downloadables</span><span class="pull-right-container"></span></a>
			</li><!-- end of downloadables -->
			<!-- ======================================================== -->
							<!-- Activity Logs -->
			<!-- ======================================================== -->
			<li>
				<a href="activityLog.php"><i class="fa fa-book"></i> <span>Logs</span></a>
			</li><!-- logs -->
			
		</ul>
	</section>
</aside>
