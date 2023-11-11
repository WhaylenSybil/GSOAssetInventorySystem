<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1, shrink-to-fit=no">
    <title>GSO Asset Inventory System</title>
    <meta content="" name="keywords">
    <meta content="" name="description">
    
    <!-- Favicons -->
    <link  href="img/baguiologo.png" rel="icon">
    <link rel="apple-touch-icon" href="img/baguiologo.png">
    
    <meta content="width-device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" type="text/css" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../dist/css/skins/skin-blue-light.min.css">
    
    <!-- Add DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- Include DataTables Export Button CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    
    <!-- Add custom CSS for the search bar -->
    <style>
        #searchInput {
            margin-bottom: 10px;
        }
        .additional-details{

        }
        #propertyTable th{
            text-align: center;
        }
        #propertyTable td{
            text-align: center;
        }
        @media print{
            $propertyTable th{
                text-align: center;
            }
            .particulars-column{
                width: auto;
            }
        }
        .btn-show-details{
            margin-top: 3.5px;
        }
        .dateReturned{

        }
        /*.particulars-column{
            white-space: nowrap;
        }*/
        
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
    <script src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.min.js"></script>
    
    <!-- Include DataTables AutoFill extension -->
    <script src="https://cdn.datatables.net/autofill/2.3.7/js/dataTables.autoFill.min.js"></script>

    
    <!-- Add custom JavaScript for the search bar and table functionality -->
    <script>
        //Define the table variable in a broarder scope
        var table;
        // Initialize DataTable with Print and Buttons extensions
        $(document).ready(function() {
            table = $('#propertyTable').DataTable({
                lengthMenu: [[10, 25, 50, 100, 250, 500], [10, 25, 50, 100, 250, 500]],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'print',
                        text: 'Print',
                        className: 'btn-print',
                        customize: function (win) {
                            // Remove additional details columns if hidden
                            if (isAdditionalDetailsHidden()) {
                                $(win.document.body).find('.additional-details').remove();
                            }

                            $(win.document.body).find('table thead th').css('text-align', 'center');
                        },
                        exportOptions: {
                            columns: ':visible', // Export only visible columns
                        },
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'Export to Excel',
                        exportOptions: {
                            columns: ':visible'
                        },
                    },
                ],
                 // Specify the options for "Show X entries" dropdown
                autoFill: {
                        columns: ':not(.additional-details)'
                    },
                    
                });

            /*// Add universal search bar functionality
            $('#searchInput').on('keyup', function() {
                table.search(this.value).draw();
            });*/
            // Create the "Show Additional Details" button
                var showDetailsButton = $('<button class="btn btn-show-details" onclick="toggleAdditionalDetails()" id="toggleAdditionalDetails">Hide Additional Details</button>');

                // Apply DataTables button classes
                showDetailsButton.addClass('dt-button buttons-html5');

                // Append the "Show Additional Details" button after the DataTables buttons
                $('.dt-buttons').append(showDetailsButton);
            // Create the 'Show/Hide Date Recorded' button
                var showdateReturnedButton = $('<button class=\"btn btn-show-details\" onclick=\"toggledateReturned()\" id=\"toggledateReturned\">Hide Date Returned</button>');

                // Apply DataTables button classes
                showdateReturnedButton.addClass('dt-button buttons-html5');

                // Append the button after the DataTables buttons
                $('.dt-buttons').append(showdateReturnedButton);

        });

        //Function to check if additional details columns are hidden
        function isAdditionalDetailsHidden(){
            var additionalDetailsColumn = document.querySelectorAll('.additional-details');
            for (var i = 0; i < additionalDetailsColumn.length; i++) {
                if (additionalDetailsColumn[i].style.display !== 'none') {
                    return false;
                }   
            }
            return true;
        }
        
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
    <script>
        // Function to toggle the visibility of the additional details column
        function toggleAdditionalDetails() {
            var additionalDetailsColumn = document.querySelectorAll('.additional-details');
            var button = document.getElementById('toggleAdditionalDetails'); // Updated to 'toggleAdditionalDetails'

            for (var i = 0; i < additionalDetailsColumn.length; i++) {
                if (additionalDetailsColumn[i].style.display === 'none') {
                    additionalDetailsColumn[i].style.display = '';
                } else {
                    additionalDetailsColumn[i].style.display = 'none';
                }
            }

            // Update the button text
            if (button.innerText === 'Show Additional Details') {
                button.innerText = 'Hide Additional Details';
            } else {
                button.innerText = 'Show Additional Details';
            }
        }
        function toggledateReturned(){
            var dateReturnedColumn = table.column('.dateReturned');
            dateReturnedColumn.visible(!dateReturnedColumn.visible());

            //update the button text based on column visibility
            var button = document.getElementById('toggledateReturned');
            if (dateReturnedColumn.visible()) {
                button.innerText = 'Hide Date Returned';
            }else{
                button.innerText = 'Show Date Returned';
            }
        }
    </script>
</head>
<body>
    
    <!-- <div class="dataTables_length" id="propertyTable_length">
        <label>
            Show
            <select name="propertyTable_length" aria-controls="propertyTable" class="custom-select custom-select-sm form-control form-control-sm">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="250">250</option>
                <option value="500">500</option>
            </select>
            entries
        </label>
    </div> -->
    <!-- <button id="toggleDetailsButton" onclick="toggleAdditionalDetails()" class="btn btn-primary">Hide Additional Details</button> -->
    <?php
    require('./../database/connection.php');
    /*require('../login/login_session.php');*/

    // Check if an account code or classification parameter is provided in the URL
    if (isset($_GET['classification'])) {
        $accountClassification = urldecode($_GET['classification']);
        
        // Fetch the account title based on the provided account classification
        $sqlAccountTitle = "SELECT account_title FROM account_codes WHERE account_number = ?";
        $stmtAccountTitle = $connect->prepare($sqlAccountTitle);
        
        if ($stmtAccountTitle) {
            $stmtAccountTitle->bind_param("s", $accountClassification);
            $stmtAccountTitle->execute();
            $resultAccountTitle = $stmtAccountTitle->get_result();
            
            // Fetch the account title
            if ($resultAccountTitle->num_rows > 0) {
                $rowAccountTitle = $resultAccountTitle->fetch_assoc();
                $accountTitle = $rowAccountTitle['account_title'];
            } else {
                $accountTitle = ""; // Set a default value if no title is found
            }
            
            $stmtAccountTitle->close();
        } else {
            echo "Error preparing SQL statement for account title: " . $connect->error;
        }

        // Now you have the account title in the $accountTitle variable
        // Use it in the HTML <h3> element

        // Retrieve ARE properties based on the provided responsibility center
        $sql = "SELECT
                i.*,
                ac.account_number AS classification,
                COALESCE(co.office_name, no.noffice_name) AS responsibility_center,
                c.condition_name AS current_condition
                FROM
                    ics_properties i
                LEFT JOIN
                    account_codes ac ON i.classification_id = ac.account_number
                LEFT JOIN
                    city_offices co ON i.responsibilitycenter_id = co.office_name
                LEFT JOIN
                    national_offices no ON i.responsibilitycenter_id = no.noffice_name
                LEFT JOIN
                    conditions c ON i.currentcondition = c.condition_name
                WHERE
                    i.classification_id = ?";
        $stmt = $connect->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $accountClassification);
            $stmt->execute();
            $result = $stmt->get_result();

            //Fetch and display the ARE properties
            if ($result->num_rows > 0) {
                echo "<h3 style='text-align: center; line-height: 2em;'>Report on Physical Count of Property, Plant, and Equipment<br><span style='text-decoration: underline;'>$accountTitle</span><br> $accountClassification<br> (Type of Property, Plant, and Equipment)</h3>";

                /*echo '<button id="toggleDetailsButton" onclick="toggleAdditionalDetails()" class="btn btn-primary">Hide Additional Details</button>';*/


                
                // Add a print button
                /*echo '<button onclick="window.print()" class="btn btn-primary">Print</button>';*/
                
                // Add an export button
                //echo '<button onclick="exportTableToCSV(\'are_properties.csv\')" class="btn btn-success">Export to CSV</button>';
                
                // Add a universal search bar
                /*echo '<input type="text" id="searchInput" class="form-control" placeholder="Search">';*/
                
                // Display the table
                echo "<div class = 'table-responsive'>";
                echo "<div style ='max-height:200%; overflow-y:auto;'>";
                echo "<table id='propertyTable' class='table table-bordered table-striped'>";
                echo "<thead>
                            <tr>
                                <th class='dateReturned' rowspan='2'>DATE RETURNED</th>
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
                                <th  class='subcolumn additional-details' colspan='5'>ADDITIONAL DETAILS FOR RECONCILIATION PURPOSES</th>
                                </tr>
                                <tr>
                                <th  class='subcolumn'> BRAND</th>
                                <th  class='subcolumn'>SERIAL NUMBER</th>
                                <th  class='subcolumn particulars'>PARTICULARS</th>
                                <th  class='subcolumn'>MR NUMBER</th>
                                <th  class='subcolumn'>SHORTAGE/OVERAGE QTY</th>
                                <th  class='subcolumn'>SHORTAGE/OVERAGE VALUE</th>
                                <th  class='subcolumn additional-details'>SUPPLIER</th>
                                <th  class='subcolumn additional-details'>PO NO.</th>
                                <th  class='subcolumn additional-details'>AIR/RIS NO.</th>
                                <th  class='subcolumn additional-details'>NOTES</th>
                                <th  class='subcolumn additional-details'>JEV NUMBER</th>
                                    
                                </tr>
                        </thead>";
                echo "<tbody>";
                echo "</div>";
                echo "</div>";

                while ($row = $result->fetch_assoc()) {
                    echo'

                     <tr>
                        <td class="dateReturned">' . (empty($row['date_returned']) || $row['date_returned'] === '0000-00-00' ? '' : date('m-d-Y', strtotime($row['date_returned']))) . '</td>
                        <td>' . $row['article'] . '</td>
                        <td>' . $row['brand'] . '</td>
                        <td>' . $row['serialno'] . '</td>
                        <td class = "particulars particulars-column">' . $row['particulars'] . '</td>
                        <td>' . $row['PRS_WMR_no'] . '</td>
                        <td>' . $row['eNGAS'] . '</td>
                        <td>' . (empty($row['acquisitiondate']) || $row['acquisitiondate'] === '0000-00-00' ? '' : date('m-d-Y', strtotime($row['acquisitiondate']))) . '</td>
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
                        <td class ="additional-details">' . $row['supplier'] . '</td>
                        <td class ="additional-details">' . $row['PO_no'] . '</td>
                        <td class ="additional-details">' . $row['AIR_RIS_no'] . '</td>
                        <td class ="additional-details">' . $row['notes'] . '</td>
                        <td class ="additional-details">' . $row['jevno'] . '</td>

                    </tr>

                    ';
                }
                echo "</tbody>";
                echo "</table>";
            }else {
                echo "No ARE properties found for Responsibility Center: $accountClassification";
            }
            
            $stmt->close();
        } else {
            echo "Error preparing SQL statement: " . $connect->error;
        }

    } else {
        echo "Account classification parameter not provided.";
    }
    ?>
</body>   
</html>

