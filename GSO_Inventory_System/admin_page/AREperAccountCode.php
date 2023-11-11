<?php
require('./../database/connection.php');
require('../login/login_session.php');

// Define an array of CSS classes with different background colors
$bgColors = ['bg-green', 'bg-blue', 'bg-red', 'bg-orange', 'bg-purple', 'bg-yellow', 'bg-teal', 'bg-maroon'];

// Retrieve the responsibility center data from the ARE_properties table
$accountCodes = [];
$sql = "SELECT DISTINCT a.classification_id, ac.account_title 
        FROM are_properties a
        INNER JOIN account_codes ac ON a.classification_id = ac.account_number
        WHERE a.classification_id IS NOT NULL AND a.classification_id <> ''
        ORDER BY ac.account_title ASC";
$result = $connect->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $classificationId = $row['classification_id'];
        $accountTitle = $row['account_title'];
        // Skip rows where the classification or account title is empty (blank)
        if (!empty($classificationId) && !empty($accountTitle)) {
            // Randomly select a background color class
            $randomColorClass = $bgColors[array_rand($bgColors)];
            
            // Add the classification and account title along with the random color class to the array
            $accountCodes[] = ['classificationId' => $classificationId, 'accountTitle' => $accountTitle, 'colorClass' => $randomColorClass];
        }
    }
}
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
    <link rel="stylesheet" type="text/css" href="../bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" type="text/css" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../dist/css/skins/skin-blue-light.min.css">
    
</head>
<body class="hold-transition skin-blue-light sidebar-mini fixed">
    <div class="wrapper">
        <?php include_once("../admin_page/header/header.php");
        ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1><i class="fa fa fa-cube"></i>
                Per Account(Classification) ARE</h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-cube"> Per Account(Classification) ARE</i></a></li>
                </ol>
            </section>
            <section class="content container-fluid">
                <div class="box box-primary">
                    <div class="box-header with-border bg-blue text-center">
                        <h2 class="box-title">Per Account(Classification) ARE</h2>
                    </div>
                    <div box-body>
                        <div class="row"><br>
                         <!-- Display Accounts for Equipments based on the data from are_properties -->
                          <?php foreach ($accountCodes as $account) : ?>
                            <div class="col-md-6">
                              <a href="are_properties_by_classification.php?classification=<?php echo urlencode($account['classificationId']); ?>" class="box-link" target="_blank">
                                <div class="small-box <?php echo $account['colorClass']; ?>">
                                    <div class="inner">
                                        <h4 align="center"><?php echo $account['accountTitle'] . ' [' . $account['classificationId'] . ']'; ?></h4>
                                    </div>
                                </div>
                            </div>
                          <?php endforeach; ?>
                          <!-- End of Account For Equipments --> 
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="../bower_components/fastclick/lib/fastclick.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>

</body>
</html>