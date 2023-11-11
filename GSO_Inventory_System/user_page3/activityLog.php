<?php
require('./../database/connection.php');
require('../login/login_session.php');

if (!isset($_SESSION["employeeid"])) {
    header('Location: ../login/login.php');
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" name="viewport">
    <title>GSO Asset Inventory System</title>
    <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" type="text/css" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../dist/css/skins/skin-blue-light.min.css">

    <!-- Favicons -->
    <link href="img/baguiologo.png" rel="icon">
    <link rel="apple-touch-icon" href="img/baguiologo.png">
</head>

<body class="hold-transition skin-blue-light sidebar-mini fixed">
    <div class="wrapper">
        <?php include_once("../admin_page/header/header.php"); ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1><i class="fa fa-book"></i>LOGS
                    <small>Manage your Logs</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li class="active">Logs</li>
                </ol>
            </section>

            <section class="content container-fluid">
                <br>
                <div class="box">
                    <div class="box-header bg-blue" align="center">
                        <h4 class="box-title">Activity Logs</h4>
                    </div><br>
                    <form method="POST">
                        <button name="clear" id="clear" class="btn btn-gray pull-right" onClick="return confirm('Are you sure you want to clear logs?')" style="margin-right: 20px">
                            <span class="fa fa-trash">&nbsp</span>Clear Logs
                        </button>
                    </form>
                    <br>
                    <br>
                    <table id="logs" class="table table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Employee ID</th>
                                <th scope="col">User</th>
                                <th scope="col">Time</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                             $pre_stmt = $connect->prepare("SELECT * FROM activity_log ORDER BY time_log DESC")or die(mysqli_error()); 
                             $pre_stmt->execute();                 
                             $result = $pre_stmt->get_result();
                            while($row = mysqli_fetch_array($result)){

                             date_default_timezone_set('Asia/Manila');
                               $time=$row['time_log'];
                               $time_log= date('h:i:s a ', strtotime($time)); ?>

                                <tr>
                                    <td><?php echo $row['date_log']; ?> </td>
                                    <td><?php echo $row['employeeid']; ?> </td>
                                    <td><?php echo $row['firstname']; ?> </td>
                                    <td><?php echo $time_log; ?> </td>
                                    <td><?php echo $row['action']; ?> </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    <?php

    if (isset($_POST['clear'])) {
        $queryLOG = 'TRUNCATE TABLE activity_log';
        $pre_stmt = $connect->prepare($queryLOG) or die(mysqli_error());
        $pre_stmt->execute();

        echo '<script type="text/javascript">window.location = "activityLog.php"</script>';
    }

    ?>

    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="../bower_components/fastclick/lib/fastclick.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>
    <script src="./js/notification.js"></script>
    <script>
        $(function() {
            $('#logs').DataTable({
                responsive: true,
                "order": [
                    [0, "desc"]
                ],
                "lengthMenu": [25, 50, 100, 200]
            })
            $('#example2').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': true,
                "lengthMenu": [25, 50, 100, 200]
            })
        })
    </script>
</body>

</html>