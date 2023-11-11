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