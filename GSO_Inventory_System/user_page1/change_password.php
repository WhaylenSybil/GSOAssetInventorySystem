<?php
require('./../database/connection.php');
require('../login/login_session.php');

$sql="SELECT * FROM user WHERE employeeid=".$_SESSION['employeeid'];
$result=mysqli_query($connect, $sql);
$rows=mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>GSO ASSET Inventory System</title>
	
	<!-- Tell the browser how to be responsive to screen width -->
	<meta content="width-device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">

	<!-- Ionicons -->
	<link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">

	<!-- Theme style -->
	<link rel="stylesheet" href="../dist/css/AdminLTE.min.css">

	<!-- Datatables -->
	<link rel="stylesheet" href="../bower_components/datatables.net-bs/css/dataTables.bootsrap.min.css">
	<link rel="stylesheet" href="../dist/css/skins/skin-blue-light.min.css">

	<!-- Favicons -->
	<link  href="img/baguiologo.png" rel="icon">
	<link rel="apple-touch-icon" href="img/baguiologo.png">

</head>
<body class="hold-transition skin-blue-light sidebar-mini">
	<div class="wrapper">
		<?php include_once("../admin_page/header/header.php"); ?>
		<!-- Content Wrapper contains page content -->
	<div class="content-wrapper">
		<section class="content-header">
			<h1><i class="fa fa-users"></i>USER ACCOUNT</h1>
			<ol class="breadcrumb">
				<li><a href="dashboard.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
				<li class="active">Change Password</li>
			</ol>
		</section>
		<!-- Main Content -->
		<section class="content container-fluid">
			<a href="dashboard.php" class="btn bg-gray"><i class="fa fa-fw fa-arrow-left"></i>BACK</a><br><br>
			<div class="box">
				<div class="box-header bg-blue" style="text-align: center;">
					<h4 class="box-title">Change User Password</h4>
				</div><br>
				<div class="row">
					<div class="col-md-6">
						<p class="lead"> User Information</p>
						<div class="table-responsive">
							<table class="table">
								<tr>
									<th style="width:50%">EMPLOYEE ID</th>
									<td><?php echo $rows['employeeid']; ?></td>
								</tr>
								<tr>
									<th style="width:50%">PERMISSION</th>
									<td><?php echo $rows['permission']; ?></td>
								</tr>
								<tr>
									<th style="width:50%">FULL NAME</th>
									<td><?php echo $rows['firstname'].' '.$rows['lastname'] ?></td>
								</tr>
							</table>
						</div><!-- table responsive -->
					</div><!-- col-md-6 -->
					<div class="card-body">
						<div class="col-sm-5">
							<form method="POST" name="form">
								<div class="form-group">
									<label>Security Question 1:</label>
									<select class="form-control" id="security1" name="security1" required>
										<option value=""<?php if ($rows['question1']=='') {echo "Selected";
											
										} ?>>---Select Security Question 1</option>
										<option value="What is your pets name" <?php if ($rows['question1']=='What is your pets name') {echo "Selected";
										} ?>>What is your pet's name</option>
										<option value="What is your favorite color"<?php if ($rows['question1']=='What is your favorite color') {echo "Selected";
										} ?>>What is your favorite color</option>
										<option value="What is your favorite food"<?php if ($rows['question1']=='What is your favorite food') {echo "Selected";
										} ?>>What is your favorite food</option>
									</select>
								</div><!-- form group --><!-- Question 1 -->
								<div class="form-group">
									<label>Answer:</label>
									<input type="text" name="answer1" id="answer1" placeholder="Answer"  class="form-control" required>
								</div><!-- Answer 1 -->
								<div class="form-group">
									<br><label>Security Question 2:</label>
									<select class="form-control" id="security2" name="security2" required>
										<option value=""<?php if ($rows['question2']=='') {echo "Selected";
											
										} ?>>---Select Security Question 2</option>
										<option value="Who is your favorite author"><?php if ($rows['question2']=='Who is your favorite author') {echo "Selected";
										} ?>Who is your favorite author</option>
										<option value="What is your lucky number"<?php if ($rows['question2']=='What is your lucky number') {echo "Selected";
										} ?>>What is your lucky number</option>
										<option value="What is the name of your youngest sibling"<?php if ($rows['question2']=='What is the name of your youngest sibling') {echo "Selected";
										} ?>>What is the name of your youngest sibling</option>
									</select>
								</div><!-- form group --><!-- Question 2 -->
								<div class="form-group">
									<label>Answer:</label>
									<input type="text" name="answer2" id="answer2" placeholder="Answer"  class="form-control" required>
								</div><!-- Answer 2 -->
								<div class="form-group">
									<br><label>Security Question 3:</label>
									<select class="form-control" id="security3" name="security3" required>
										<option value=""<?php if ($rows['question3']=='') {echo "Selected";
											
										} ?>>---Select Security Question 3</option>
										<option value="What is your biggest fear"<?php if ($rows['question3']=='What is your biggest fear') {echo "Selected";
										} ?>>What is your biggest fear</option>
										<option value="Who is your oldest sibling"<?php if ($rows['question3']=='Who is your oldest sibling') {echo "Selected";
										} ?>>Who is your oldest sibling</option>
										<option value="Where did you attended high school"<?php if ($rows['question3']=='Where did you attended high school') {echo "Selected";
										} ?>>Where did you attended high school</option>
									</select>
								</div><!-- form group --><!-- Question 3 -->
								<div class="form-group">
									<label>Answer:</label>
									<input type="text" name="answer3" id="answer3" placeholder="Answer"  class="form-control" required>
								</div><!-- Answer 3 -->

								<!-- Old Password and Update Password -->
								<div class="form-group">
									<label>Old Password</label>
									<input type="password" class="form-control" id="oldpassword" name="oldpassword" placeholder="Old Password" required>
									<small id="col-error" class="form-text text-muted"></small>
								</div>
								<div class="form-group">
									<label> New Password</label>
									<input type="password" name="newpassword" class="form-control" id="newpassword" placeholder="New Password" required>
									<small id="col-error" class="form-text text-muted"></small>
								</div>
								<div class="form-group">
									<label>Confirm New Password</label>
									<input type="password" name="cnewpassword" class="form-control" id="cnewpassword" placeholder="Confirm New Password" required>
									<small id="col-error" class="form-text text-muted"></small>
								</div>
								<input type="checkbox" onclick="myFunction()"> Show Password
								<div class="modal-footer">
									<button type="submit" class="btn btn-primary" name="btn-change" onClick="return confirm('Are you sure that you want to change your password?')">Change Password</button>
								</div>

							</form>
						</div><!-- col-sm-5 -->
					</div><!-- card body -->
				</div><!-- row -->
			</div>
		</section>
	</div><!-- content-wrapper -->
	<?php
		if (isset($_POST['btn-change'])) {
			$question1 = $_POST['security1'];
			$answer1 = $_POST['answer1'];
			$question2 = $_POST['security2'];
			$answer2 = $_POST['answer2'];
			$question3 = $_POST['security3'];
			$answer3 = $_POST['answer3'];
			$pass = $rows['password'];
			$oldpass = $_POST['oldpassword'];
			$newpass = $_POST['newpassword'];
			$cnewpass = $_POST['cnewpassword'];

			$oldpass_hash = md5($oldpass);
			$newpass_hash = md5($newpass);
			$cnewpass_hash = md5($cnewpass);

			if ($oldpass_hash ==$pass) {
				if ($newpass_hash == $cnewpass_hash) {
					$query = "UPDATE user SET password=?, question1=?, answer1=?, question2=?, answer2=?, question3=?, answer3=? WHERE employeeid=?";
					$pre_stmt = $connect->prepare($query) or die(mysqli_error());
					$pre_stmt->bind_param('sssssssi', $cnewpass_hash, $question1, $answer1, $question2, $answer2, $question3, $answer3, $_SESSION['employeeid']);
					$pre_stmt->execute();

					echo '<script language="javascript">';
					echo 'alert("You have changed your password")';
					echo '</script>'; 
					echo '<script type="text/javascript">window.location = "dashboard.php"</script>';
				}else{
					echo '<script language="javascript">';
					echo 'alert("Your password is not matched.")';
					echo '</script>';
				}
			}else{
				echo '<script language="javascript">';
				echo 'alert("Old password is incorrect.")';
				echo '</script>'; 
			}
		}
	?>
	
	</div><!-- div wrapper -->

	<!-- Scripts Required -->
	<script src="../bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- DataTables -->
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<!-- SlimScroll -->
	<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<!-- FastClick -->
	<script src="../bower_components/fastclick/lib/fastclick.js"></script>
	<!-- AdminLTE App -->
	<script src="../dist/js/adminlte.min.js"></script>

	<!-- Script for change password -->
	<script>
		function myFunction(){
			var x = document.getElementById("oldpassword");
			var y = document.getElementById("newpassword");
			var z = document.getElementById("cnewpassword");
			if (x.type==="password" && y.type==="password" && z.type==="password") {
				x.type ="text";
				y.type = "text";
				z.type = "text";
			}
			else{
				x.type = "password";
				y.type = "password";
				z.type = "password";
			}
		}
	</script>

</body>
</html>