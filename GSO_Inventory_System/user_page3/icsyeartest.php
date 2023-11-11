<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GSO Asset Inventory System</title>
    <!-- Favicons -->
    <link  href="img/baguiologo.png" rel="icon">
    <link rel="apple-touch-icon" href="img/baguiologo.png">
</head>
<body>

</body>
</html>
<?php
require('./../database/connection.php');
require('../login/login_session.php');

// Check if a account code or classification parameter is provided in the URL
if (isset($_GET['dateYear'])) {
    $YearDate = urldecode($_GET['dateYear']);
    
    // Retrieve ARE properties based on the provided responsibility center
    $sql = "SELECT
            i.*,
            ac.account_number AS classification,
            COALESCE(co.office_name, no.noffice_name) AS responsibility_center,
            c.condition_name AS current_condition
            FROM
                are_properties i
            LEFT JOIN
                account_codes ac ON i.classification_id = ac.account_number
            LEFT JOIN
                city_offices co ON i.responsibilitycenter_id = co.office_name
            LEFT JOIN
                national_offices no ON i.responsibilitycenter_id = no.noffice_name
            LEFT JOIN
                conditions c ON i.currentcondition = c.condition_name
            WHERE
                i.date_returned = ?";
    $stmt = $connect->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("s", $YearDate);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Fetch and display the ARE properties
        if ($result->num_rows > 0) {
            echo "<h3 style='text-align: center; line-height: 2em;'>Report on Physical Count of Property, Plant, and Equipment<br><span style='text-decoration: underline;'>$YearDate</span><br> (Type of Property, Plant, and Equipment)</h3>";
            
            // Add a print button
            //echo '<button onclick="window.print()" class="btn btn-primary">Print</button>';
            
            // Add an export button
            //echo '<button onclick="exportTableToCSV(\'are_properties.csv\')" class="btn btn-success">Export to CSV</button>';
            
            // Add a universal search bar
            /*echo '<input type="text" id="searchInput" class="form-control" placeholder="Search">';*/
            
            // Display the table
            echo "<div class = 'table-responsive'>";
            echo "<div style ='width:200%; overflow-x:auto;'>";
            echo "<table id='propertyTable' class='table table-bordered table-striped'>";
            echo "<thead>
                        <tr>
                            <th  rowspan='2'>ARTICLE</th>
                            <th  class='subcolumn' colspan='4'>DESCRIPTION</th>
                            <th  rowspan='2'>eNGAS PROPERTY NUMBER</th>
                            <th  rowspan='2'>ACQUISITION DATE</th>
                            <th  rowspan='2'>ACQUISITION COST</th>
                            <th  rowspan='2'>PROPERTY NO.</th>
                            <th  rowspan='2'>CLASSIFICATION</th>
                            <th  rowspan='2'>EST. USEFUL LIFE</th>
                            <th  rowspan='2'>UNIT OF MEASURE</th>
                            <th  rowspan='2'>UNIT VALUE</th>
                            <th  rowspan='2'>BALANCE PER CARD QTY</th>
                            <th  rowspan='2'>ON HAND PER COUNT QTY</th>
                            <th  class='subcolumn' colspan='2'>SHORTAGE/OVERAGE</th>
                            <th  rowspan='2'>RESPONSIBILITY CENTER</th>
                            <th  rowspan='2'>ACCOUNTABLE PERSON</th>
                            <th  rowspan='2'>PREVIOUS CONDITION</th>
                            <th  rowspan='2'>LOCATION</th>
                            <th  rowspan='2'>CURRENT CONDITION</th>
                            <th  rowspan='2'>DATE OF PHYSICAL INVENTORY</th>
                            <th  rowspan='2'>REMARKS</th>
                            <th  class='subcolumn' colspan='5'>ADDITIONAL DETAILS FOR RECONCILIATION PURPOSES</th>
                            </tr>
                            <tr>
                            <th  class='subcolumn'> BRAND</th>
                            <th  class='subcolumn'>SERIAL NUMBER</th>
                            <th  class='subcolumn'>PARTICULARS</th>
                            <th  class='subcolumn'>MR NUMBER</th>
                            <th  class='subcolumn'>(Qty)</th>
                            <th  class='subcolumn'>Value</th>
                            <th  class='subcolumn'>SUPPLIER</th>
                            <th  class='subcolumn'>PO NO.</th>
                            <th  class='subcolumn'>AIR/RIS NO.</th>
                            <th  class='subcolumn'>NOTES</th>
                            <th  class='subcolumn'>JEV NUMBER</th>
                                
                            </tr>
                            
                        </tr>
                    </thead>";
            echo "<tbody>";
            echo "</div>";
            echo "</div>";
            
            while ($row = $result->fetch_assoc()) {
                echo'

                 <tr>
                    <td>' . $row['article'] . '</td>
                    <td>' . $row['brand'] . '</td>
                    <td>' . $row['serialno'] . '</td>
                    <td>' . $row['particulars'] . '</td>
                    <td>' . $row['PRS_WMR_no'] . '</td>
                    <td>' . $row['eNGAS'] . '</td>
                    <td>' . $row['acquisitiondate'] . '</td>
                    <td>' . $row['acquisitioncost'] . '</td>
                    <td>' . $row['propertyno'] . '</td>
                    <td>' . $row['classification'] . '</td>
                    <td>' . $row['estimatedlife'] . '</td>
                    <td>' . $row['unitofmeasure'] . '</td>
                    <td>' . $row['unitvalue'] . '</td>
                    <td>' . $row['balance_per_card'] . '</td>
                    <td>' . $row['onhand_per_count'] . '</td>
                    <td>' . $row['so_qty'] . '</td>
                    <td>' . $row['so_value'] . '</td>
                    <td>' . $row['responsibility_center'] . '</td>
                    <td>' . $row['accountable_person'] . '</td>
                    <td>' . $row['previouscondition'] . '</td>
                    <td>' . $row['location'] . '</td>
                    <td>' . $row['current_condition'] . '</td>
                    <td>' . $row['date_of_physical_inventory'] . '</td>
                    <td>' . $row['remarks'] . '</td>
                    <td>' . $row['supplier'] . '</td>
                    <td>' . $row['PO_no'] . '</td>
                    <td>' . $row['AIR_RIS_no'] . '</td>
                    <td>' . $row['notes'] . '</td>
                    <td>' . $row['jevno'] . '</td>

                </tr>

                ';
            }
            
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "No Year found for Date Recorded: $YearDate";
        }
        
        $stmt->close();
    } else {
        echo "Error preparing SQL statement: " . $connect->error;
    }
} else {
    echo "Date returned parameter not provided.";
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
    
    <!-- Add DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    
    <!-- Add custom CSS for the search bar -->
    <style>
        #searchInput {
            margin-bottom: 10px;
        }
    </style>
    <!-- Include jQuery and DataTables JavaScript libraries -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    
    <!-- Include DataTables Print and Buttons extensions -->
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    
    <!-- Include DataTables Export Button CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    
    <!-- Include DataTables AutoFill extension -->
    <script src="https://cdn.datatables.net/autofill/2.3.7/js/dataTables.autoFill.min.js"></script>
    
    <!-- Add custom JavaScript for the search bar and table functionality -->
    <script>
        // Initialize DataTable with Print and Buttons extensions
        $(document).ready(function() {
            var table = $('#propertyTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'print',
                    {
                        extend: 'excelHtml5',
                        text: 'Export to Excel',
                        className: 'btn btn-success',
                    },
                    {
                        extend: 'csvHtml5',
                        text: 'Export to CSV',
                        className: 'btn btn-success',
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'Export to PDF',
                        className: 'btn btn-success',
                    }
                ]
            });
            
            // Add universal search bar functionality
            $('#searchInput').on('keyup', function() {
                table.search(this.value).draw();
            });
        });
        
        // Function to export table data to CSV
        function exportTableToCSV(filename) {
            var csv = [];
            var rows = document.querySelectorAll('table tr');
            
            for (var i = 0; i < rows.length; i++) {
                var row = [], cols = rows[i].querySelectorAll('td, th');
                
                for (var j = 0; j < cols.length; j++) {
                    row.push(cols[j].innerText);
                }
                
                csv.push(row.join(','));
            }
            
            // Download CSV file
            downloadCSV(csv.join('\n'), filename);
        }
        
        function downloadCSV(csv, filename) {
            var csvFile;
            var downloadLink;
            
            // Create CSV file
            csvFile = new Blob([csv], {type: 'text/csv'});
            
            // Create a download link
            downloadLink = document.createElement('a');
            
            // Set the file name
            downloadLink.download = filename;
            
            // Create a link to the file
            downloadLink.href = window.URL.createObjectURL(csvFile);
            
            // Trigger the download
            downloadLink.style.display = 'none';
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }
    </script>
</head>
    
</html>