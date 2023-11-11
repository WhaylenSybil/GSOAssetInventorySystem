<?php
require('./../database/connection.php');
require('../login/login_session.php');

// Define an array of CSS classes with different background colors
$bgColors = ['bg-green', 'bg-blue', 'bg-red', 'bg-orange', 'bg-purple', 'bg-yellow', 'bg-teal', 'bg-maroon'];

// Retrieve the responsibility center data from the ARE_properties table
$responsibilityCenters = [];
$sql = "SELECT DISTINCT responsibilitycenter_id FROM ARE_properties WHERE responsibilitycenter_id IS NOT NULL AND responsibilitycenter_id <> ''
    ORDER BY responsibilitycenter_id ASC";
$result = $connect->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $responsibilityCenter = $row['responsibilitycenter_id'];
        // Skip responsibility centers that are empty (blank)
        if (!empty($responsibilityCenter)) {
            // Randomly select a background color class
            $randomColorClass = $bgColors[array_rand($bgColors)];
            
            // Add the responsibility center and random color class to the array
            $responsibilityCenters[] = ['center' => $responsibilityCenter, 'colorClass' => $randomColorClass];
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

    <!-- Favicons -->
    <link  href="img/baguiologo.png" rel="icon">
    <link rel="apple-touch-icon" href="img/baguiologo.png">
    
</head>
<body class="hold-transition skin-blue-light layout-top-nav">
    <div class="wrapper">
        <?php include_once("../user_page/header/header.php");;
        ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1><i class="fa fa fa-cube"></i>
                Per Office/Department(Responsibility Center) ARE</h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-cube"> Per Office/Department(Responsibility Center) ARE</i></a></li>
                </ol>
            </section>
            <section class="content container-fluid">
                <div class="box box-primary">
                    <div class="box-header with-border bg-blue text-center">
                        <h2 class="box-title">Per Office/Department(Responsibility Center) ARE</h2>
                    </div>
                    <div box-body>
                        <div class="row"><br>
                         <!-- Display Responsibility Centers based on the data from are_properties -->
                          <?php foreach ($responsibilityCenters as $center) : ?>
                            <div class="col-md-4">
                              <a href="are_properties_by_responsibility_center.php?center=<?php echo urlencode($center['center']); ?>" class="box-link" target="_blank">
                                <div class="small-box <?php echo $center['colorClass']; ?>">
                                    <div class="inner">
                                        <h4 align="center"><?php echo $center['center']; ?></h4>
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