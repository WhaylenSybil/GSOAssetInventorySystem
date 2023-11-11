<?php
require('./../database/connection.php');
require('../login/login_session.php');

// Define an array of CSS classes with different background colors
$bgColors = ['bg-green', 'bg-blue', 'bg-red', 'bg-orange', 'bg-purple', 'bg-yellow', 'bg-teal', 'bg-maroon'];

// Retrieve the accountable person data from the ARE_properties table
$AccountablePersonArray = [];
$sql = "SELECT DISTINCT accountable_person FROM are_properties";
$result = $connect->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $accountablePerson = $row['accountable_person'];
        // Skip empty accountable person names
        if (!empty($accountablePerson)) {
            // Randomly select a background color class
            $randomColorClass = $bgColors[array_rand($bgColors)];
            
            // Add the accountable person and random color class to the array
            $AccountablePersonArray[] = ['accountablePerson' => $accountablePerson, 'colorClass' => $randomColorClass];
        }
    }

    //Sort the $AccountablePersonArray alphabetically by the accountablePerson field
    usort($AccountablePersonArray, function($a, $b){
        return strcmp($a['accountablePerson'], $b['accountablePerson']);
    });
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
                <h1><i class="fa fa fa-crosshairs"></i>
                ARE Accountable Employees Report</h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-crosshairs">ARE Accountable Employees</i></a></li>
                </ol>
            </section>
            <section class="content container-fluid">
                <div class="box box-primary">
                    <div class="box-header with-border bg-blue text-center">
                        <h2 class="box-title">ARE Accountable Employees</h2>
                    </div>
                    <div class="box-body">
                        <!-- Add a search input field above the employee list -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" id="employeeSearch" class="form-control" placeholder="Search for an employee...">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <?php foreach ($AccountablePersonArray as $accountablePerson) : ?>
                                <div class="col-md-3 employee-box">
                                    <a href="are_properties_by_accountable_person.php?accountablePerson=<?php echo urlencode($accountablePerson['accountablePerson']); ?>" class="box-link" target="_blank">
                                        <div class="small-box <?php echo $accountablePerson['colorClass']; ?>">
                                            <div class="inner">
                                                <h4 class="employee-name" align="center"><?php echo $accountablePerson['accountablePerson']; ?></h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
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

    <script>
        $(document).ready(function() {
            // Your existing JavaScript code...
            
            // Add an event listener to the search input field
            $('#employeeSearch').on('keyup', function() {
                var searchText = $(this).val().toLowerCase(); // Get the search text in lowercase
                $('.employee-box').each(function() { // Loop through employee boxes
                    var employeeName = $(this).find('.employee-name').text().toLowerCase(); // Get employee name in lowercase
                    if (employeeName.includes(searchText)) { // Check if the name contains the search text
                        $(this).show(); // Show the employee box if it matches
                    } else {
                        $(this).hide(); // Hide the employee box if it doesn't match
                    }
                });
            });
        });
    </script>
</body>
</html>