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
            #PRStable th{
                text-align: center;
            }
            #PRStable td{
                text-align: center;
            }
            @media print{
                $PRStable th{
                    text-align: center;
                }
            }
            .btn-show-details{
                margin-top: 3.5px;
            }
            .dateRecorded{

            }
            /* Style the modal background */
            .modal-background {
              display: none;
              position: fixed;
              top: 0;
              left: 0;
              width: 100%;
              height: 100%;
              background: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
              z-index: 1;
              display: flex;
              align-items: center;
              justify-content: center;
            }

            /* Style the modal content for both modals */
            .modal-content {
              background-color: #ffffff; /* White background */
              color: black;
              padding: 20px;
              border-radius: 5px;
              text-align: center;
              z-index: 2;
              position: absolute;
              top: 50%;
              left: 50%;
              transform: translate(-50%, -50%);
            }

            /* Style the OK button */
            .ok-button {
              background-color: #0074E4; /* Blue background color for OK button */
              color: white;
              padding: 10px 20px;
              border: none;
              border-radius: 5px;
              cursor: pointer;
              margin-top: 10px; /* Add margin to separate the message and the button */
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
        <script src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.min.js"></script>
        
        <!-- Include DataTables AutoFill extension -->
        <script src="https://cdn.datatables.net/autofill/2.3.7/js/dataTables.autoFill.min.js"></script>

        <!-- Script to format date from yyyy-mm-dd to mm-dd-yyyy -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

        
        <!-- Add custom JavaScript for the search bar and table functionality -->
        <script>
            //Define the table variable in a broader scope
            var table;
            // Initialize DataTable with Print and Buttons extensions
            $(document).ready(function() {
                $.fn.dataTable.ext.pager.numbers_length = 10;
                table = $('#PRStable').DataTable({
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

                                //Format the dates to mm-dd-yyyy before printing
                                formatDates (win, '.dateReturnedRecorded');
                                formatDates (win, '.acquisitionDate');
                                formatDates (win, '.dateOfSale');
                                formatDates (win, '.dateOfAuction');
                                formatDates (win, '.ORDate');
                                formatDates (win, '.transferDate');

                                $(win.document.body).find('table thead th').css('text-align', 'center');
                            },
                            exportOptions: {
                                columns: ':visible',// Export only visible columns

                            },
                        },
                        {
                            extend: 'excelHtml5',
                            text: 'Export to Excel',
                            exportOptions: {
                                columns: ':visible',
                                filename: 'PRS MASTER LIST REPORT.xlsx'
                            },
                        },
                    ],
                    autoFill: {
                            columns: ':not(.additional-details)'
                        },
                        lengthMenu: [[10, 25, 50, 100, 250, 500], [10, 25, 50, 100, 250, 500]], // Specify the options for "Show X entries" dropdown
                    });

                // Add universal search bar functionality
                $('#searchInput').on('keyup', function() {
                    table.search(this.value).draw();
                });
                // Create the "Show Additional Details" button
                    var showDetailsButton = $('<button class="btn btn-show-details" onclick="toggleAdditionalDetails()" id="toggleAdditionalDetails">Hide Mode of Disposal and Updates/Current Updates</button>');

                    // Apply DataTables button classes
                    showDetailsButton.addClass('dt-button buttons-html5');

                    // Append the "Show Additional Details" button after the DataTables buttons
                    $('.dt-buttons').append(showDetailsButton);
                
                // Create the 'Show/Hide Date Recorded' button
                    /*var showDateRecordedButton = $('<button class=\"btn btn-show-details\" onclick=\"toggleDateRecorded()\" id=\"toggleDateRecorded\">Hide Date Returned</button>');

                    // Apply DataTables button classes
                    showDateRecordedButton.addClass('dt-button buttons-html5');

                    // Append the button after the DataTables buttons
                    $('.dt-buttons').append(showDateRecordedButton);*/

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
            function formatDates(win, className){
                $(win.document.body).find(className).each(function (){
                    var originalDate = $(this).text();
                    if (originalDate) {
                        var formattedDate = moment(originalDate, 'MM-DD-YYYY').format('MM-DD-YYYY');
                        $(this).text(formattedDate);
                    }
                });
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
                if (button.innerText === 'Show Mode of Disposal and Updates/Current Updates') {
                    button.innerText = 'Hide Mode of Disposal and Updates/Current Updates';
                } else {
                    button.innerText = 'Show Mode of Disposal and Updates/Current Updates';
                }
            }
            function toggleDateRecorded(){
                var dateRecordedColumn = table.column('.dateReturned');
                dateRecordedColumn.visible(!dateRecordedColumn.visible());

                //update the button text based on column visibility
                var button = document.getElementById('toggleDateRecorded');
                if (dateRecordedColumn.visible()) {
                    button.innerText = 'Hide Date Returned';
                }else{
                    button.innerText = 'Show Date Returned';
                }
            }
        </script>
</head>
<body>
    <?php
    $connect = mysqli_connect('localhost','root','','db_gso');

    $sqlPRS = "SELECT
        p.*,
        ac.account_number AS classification,
        COALESCE(co.office_name, no.noffice_name) AS responsibility_center,
        /*c.condition_name AS current_condition,*/
        md.modeOfDisposal,
        md.dateOfSale,
        md.ORDateNegotiation,
        md.ORNumberNegotiation,
        md.amountNegotiation,
        md.notesNegotiation,
        md.dateOfAuction,
        md.ORDateAuction,
        md.ORNumberAuction,
        md.amountAuction,
        md.notesAuction,
        md.transferDateWithoutCost,
        md.recipientTransferred,
        md.notesTransferred,
        md.transferDateContinued,
        md.recipientContinued,
        md.notesContinued,
        md.partDestroyedOrThrown,
        md.notesDestroyed,
        ucs.currentStatus,
        ucs.jevNo,
        ucs.dateDropped,
        ucs.actionsToBeTakenDropped,
        ucs.actionsTobeTakenExisting
    FROM
        prs_properties p
    LEFT JOIN
        account_codes ac ON p.classification = ac.account_number
    LEFT JOIN
        city_offices co ON p.responsibilityCenter = co.office_name
    LEFT JOIN
        national_offices no ON p.responsibilityCenter = no.noffice_name
    /*LEFT JOIN
        conditions c ON p.currentCondition = c.condition_name*/
    LEFT JOIN
        modeofdisposaltable md ON p.prsID = md.prsID
    LEFT JOIN
        updatesorcurrentstatus ucs ON p.prsID = ucs.prsID
    WHERE
        p.type = 'WMR'";
        
        $stmt = $connect->prepare($sqlPRS);

        if ($stmt) {
            $stmt = $connect->prepare($sqlPRS) or die(mysqli_error());
            $stmt->execute();
            $result = $stmt->get_result();

            //Check for errors in the query execution
            if (!$result) {
                echo "Error in query execution:" .mysqli_error($connect);
                exit;
            }

            if ($result->num_rows > 0) {
                echo "<h3 style='text-align: center; line-height: 2em;'> Property Return Slip Master List</h3>";

                //Display the table headers

                echo "<div class = 'table-responsive'>";
                echo "<div style ='max-height:200%; overflow-y:auto;'>";
                echo "<table id='PRStable' class='table table-bordered table-striped'>";
                echo "<thead>
                        <tr>
                            <th class='dateReturnedRecorded' rowspan='2'>DATE RETURNED/RECORDED</th>
                            <th rowspan='2'>ITEM NO.</th>
                            <th rowspan='2'>PRS NUMBER</th>
                            <th rowspan='2'>ARTICLE</th>
                            <th class='subcolumn' colspan='4'>DESCRIPTION</th>
                                <th rowspan='2'>eNGAS PROPERTY NUMBER</th>
                                <th rowspan='2'>ACQUISITION DATE</th>
                                <th rowspan='2'>ACQUISITION COST</th>
                                <th rowspan='2'>PROPERTY NO.</th>
                                <th rowspan='2'>CLASSIFICATION</th>
                                <th rowspan='2'>ESTIMATED USEFUL LIFE</th>
                                <th rowspan='2'>UNIT OF MEASURE</th>
                                <th rowspan='2'>UNIT VALUE</th>                                
                                <th rowspan='2'>ON HAND PER COUNT QTY</th>
                                <th rowspan='2'>RESPONSIBILITY CENTER</th>
                                <th rowspan='2'>ACCOUNTABLE EMPLOYEE</th>
                                <th rowspan='2'>REMARKS</th>
                                <th rowspan='2'>WITH IIRUP</th>
                                <th rowspan='2'>DATE OF IIRUP</th>
                                <th class = 'additional-details' colspan='7'>MODE OF DISPOSAL</th>
                                <th class = 'additional-details' colspan='2'>UPDATES/CURRENT STATUS</th>
                            </tr>
                            <tr>
                                <th class='subcolumn'>BRAND</th>
                                <th class='subcolumn'>SERIAL NUMBER</th>
                                <th class='subcolumn'>PARTICULARS</th>
                                <th class='subcolumn'>ARE/MR NUMBER</th>
                                
                                <th class='subcolumn additional-details'>DISPOSAL TYPE</th>
                                <th class='subcolumn additional-details'>DATE OF AUCTION/SALE</th>
                                <th class='subcolumn additional-details'>OR DATE</th>
                                <th class='subcolumn additional-details'>OR NUMBER</th>
                                <th class='subcolumn additional-details'>AMOUNT</th>
                                <th class='subcolumn additional-details'>PART DESTROYED & THROWN ITEM</th>
                                <th class='subcolumn additional-details'>REMARKS</th> 
                                <th class='subcolumn additional-details'>DROPPED IN BOTH RECORDS/EXISTING IN INVENTORY REPORT</th>
                                <th class='subcolumn additional-details'>REMARKS</th> 
                        </tr>
                    </thead>";

                echo "<tbody>";
                echo "</div>";
                echo "</div>";

                while ($row = $result->fetch_assoc()) {
                    echo '
                        <tr>
                            <td class="dateReturnedRecorded">';
                                if ($row['dateReturnedRecorded'] != '0000-00-00' && !empty($row['dateReturnedRecorded'])) {
                                    echo date('m-d-Y', strtotime($row['dateReturnedRecorded']));
                                } else {
                                    echo ''; // Display an empty cell
                                }
                            echo '</td>                            <td>' . $row['ItemNo'] . '</td>
                            <td>' . $row['prsNumber'] . '</td>
                            <td>' . $row['article'] . '</td>
                            <td>' . $row['brand'] . '</td>
                            <td>' . $row['serialNumber'] . '</td>
                            <td>' . $row['particulars'] . '</td>
                            <td>' . $row['areNumber'] . '</td>
                            <td>' . $row['engasNumber'] . '</td>
                            <td>' . ($row['acquisitionDate'] != '0000-00-00' && !empty($row['acquisitionDate']) ? date('m-d-Y', strtotime($row['acquisitionDate'])) : '') . '</td>
                            <td>' . $row['acquisitionCost'] . '</td>
                            <td>' . $row['propertyNumber'] . '</td>
                            <td>' . $row['classification'] . '</td>
                            <td>' . $row['estLife'] . '</td>
                            <td>' . $row['unitOfMeasure'] . '</td>
                            <td>' . $row['unitValue'] . '</td>
                            <td>' . $row['balancePerCard'] . '</td>
                            <td>' . $row['responsibilityCenter'] . '</td>
                            <td>' . $row['accountableEmployee'] . '</td>
                            <td>' . $row['remarks'] . '</td>
                            <td>' . $row['iirup'] . '</td>
                            <td>' . $row['iirupDate'] . '</td>
                            <td class="additional-details">' . $row['modeOfDisposal'] . '</td>
                            <td class="additional-details">';
                                if ($row['modeOfDisposal'] == "Sold Through Negotiation") {
                                    if ($row['dateOfSale'] != '0000-00-00' && !empty($row['dateOfSale'])) {
                                        echo date('m-d-Y', strtotime($row['dateOfSale']));
                                    } else {
                                        echo ''; // Display blank if date is empty or '0000-00-00'
                                    }
                                } elseif ($row['modeOfDisposal'] == "Sold Through Public Auction") {
                                    if ($row['dateOfAuction'] != '0000-00-00' && !empty($row['dateOfAuction'])) {
                                        echo date('m-d-Y', strtotime($row['dateOfAuction']));
                                    } else {
                                        echo ''; // Display blank if date is empty or '0000-00-00'
                                    }
                                }
                            echo '</td>

                            <td class="additional-details">';
                                if ($row['modeOfDisposal'] == "Sold Through Negotiation") {
                                    if ($row['ORDateNegotiation'] != '0000-00-00' && !empty($row['ORDateNegotiation'])) {
                                        echo date('m-d-Y', strtotime($row['ORDateNegotiation']));
                                    } else {
                                        echo ''; // Display blank if date is empty or '0000-00-00'
                                    }
                                } elseif ($row['modeOfDisposal'] == "Sold Through Public Auction") {
                                    if ($row['ORDateAuction'] != '0000-00-00' && !empty($row['ORDateAuction'])) {
                                        echo date('m-d-Y', strtotime($row['ORDateAuction']));
                                    } else {
                                        echo ''; // Display blank if date is empty or '0000-00-00'
                                    }
                                }
                            echo '</td>

                            <td class="additional-details">';
                                if ($row['modeOfDisposal'] == "Sold Through Negotiation") {
                                     echo $row['ORNumberNegotiation'];
                                 } elseif ($row['modeOfDisposal'] == "Sold Through Public Auction") {
                                     echo $row['ORNumberAuction'];
                                 }
                            echo '</td>
                            <td class="additional-details">';
                                if ($row['modeOfDisposal'] == "Sold Through Negotiation") {
                                     echo $row['amountNegotiation'];
                                 } elseif ($row['modeOfDisposal'] == "Sold Through Public Auction") {
                                     echo $row['amountAuction'];
                                 }
                            echo '</td>
                            <td class="additional-details">' . $row['partDestroyedOrThrown'] . '</td>

                            <td class="additional-details">';
                                if ($row['modeOfDisposal'] == "Transferred Without Cost") {
                                    echo '<strong>Date of Transfer: </strong> ' . date('m-d-Y', strtotime($row['transferDateWithoutCost'])) . '<strong>; Recipient: </strong>' . $row['recipientTransferred'];

                                    // Check if notesTransferred is not empty and include it
                                    if (!empty($rows['notesTransferred'])) {
                                        echo '<strong> ; Notes: </strong>'. $rows['notesTransferred'];
                                    }
                                } elseif ($row['modeOfDisposal'] == "Continued In Service") {
                                    echo '<strong>Date of Transfer: </strong>  ' . date('m-d-Y', strtotime($row['transferDateContinued'])) . '<strong>; Recipient: </strong>' . $row['recipientContinued'];

                                    // Check if notesContinued is not empty and include it
                                    if (!empty($rows['notesContinued'])) {
                                        echo '<strong> ; Notes: </strong>' . $rows['notesContinued'];
                                    }
                                } elseif ($row['modeOfDisposal'] == "Destroyed Or Condemned"){
                                    echo $row['notesDestroyed'];
                                } elseif ($row['modeOfDisposal'] == "Sold Through Public Auction") {
                                    echo $row['notesAuction'];
                                } elseif ($row['modeOfDisposal'] == "Sold Through Negotiation") {
                                    echo $row['notesNegotiation'];
                                }
                            echo '</td>
                            <td class="additional-details">' . $row['currentStatus'] . '</td>
                            <td class="additional-details">';

                                if ($row['currentStatus'] == "Dropped In Both Records") {
                                    echo '<strong>JEV NO:</strong> ' . $row['jevNo'] . '<strong>; JEV Dated:</strong> ' . date('m-d-Y', strtotime($row['dateDropped']));
                                } elseif ($row['currentStatus'] == 'Existing In Inventory Report') {
                                    echo $row['actionsTobeTakenExisting'];
                                }

                            echo '</td>
                        </tr>
                    ';
                }

            }
            else{
                // No data to print or export, display a modal dialog
                echo '<div class="modal-background" id="modalBackground" style="display: flex;">';
                echo '<div class="modal-content">';
                echo '<div class="modal-message">NO DATA TO PRINT OR EXPORT.</div>';
                echo '<button class="ok-button" onclick="closeTabAndRedirect(\'dashboard.php\')">OK</button>';
                echo '</div>';
                echo '</div>'; 
            }
        }
    ?>
    <!-- JavaScript function to redirect to a page -->
    <script type="text/javascript">
        function closeTabAndRedirect(page) {
            window.close(); // Close the current tab
            window.location.href = page; // Redirect to the specified page
        }
    </script>
</body>
</html>