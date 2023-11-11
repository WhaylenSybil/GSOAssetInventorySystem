<?php
require('./../database/connection.php');
require('../login/login_session.php');

// Define an array of CSS classes with different background colors
$bgColors = ['bg-green', 'bg-blue', 'bg-red', 'bg-orange', 'bg-purple', 'bg-yellow', 'bg-teal', 'bg-maroon'];

// Retrieve the responsibility center data from the ARE_properties table
$YearArray = [];
$sql = "SELECT DISTINCT YEAR(date_returned) AS year FROM ics_properties WHERE date_returned IS NOT NULL AND date_returned <> ''";
$result = $connect->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $year = $row['year']; // Use 'year' alias instead of 'date_returned'
        // Skip year that are empty (blank)
        if (!empty($year)) {
            // Randomly select a background color class
            $randomColorClass = $bgColors[array_rand($bgColors)];
            
            // Add the year and random color class to the array
            $YearArray[] = ['dateYear' => $year, 'colorClass' => $randomColorClass];
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
<body class="hold-transition skin-blue-light layout-top-nav">
    <div class="wrapper">
        <?php include_once("../user_page1/header/header.php");
        ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1><i class="fa fa fa-crosshairs"></i>
                Per Year ICS Report</h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-crosshairs"> Per Year ICS</i></a></li>
                </ol>
            </section>
            <section class="content container-fluid">
                <div class="box box-primary">
                    <div class="box-header with-border bg-blue text-center">
                        <h2 class="box-title">Per Year ICS</h2>
                    </div>
                    <div box-body>
                        <div class="row"><br>
                         <?php foreach ($YearArray as $dateYear) : ?>
                            <div class="col-md-4">
                              <a href="ics_properties_by_year.php?dateYear=<?php echo urlencode($dateYear['dateYear']); ?>" class="box-link" target="_blank">
                                <div class="small-box <?php echo $dateYear['colorClass']; ?>">
                                    <div class="inner">
                                        <h4 align="center"><?php echo $dateYear['dateYear']; ?></h4>
                                    </div>
                                </div>
                            </div>
                          <?php endforeach; ?>
                          <!-- End of Responsibility Centers --> 
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