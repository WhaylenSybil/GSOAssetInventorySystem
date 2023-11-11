<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>GSO Asset Inventory System</title>
    <meta content="width-device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" type="text/css" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../dist/css/skins/skin-blue-light.min.css">

    <link rel="stylesheet"  href="vendor/DataTables/jquery.datatables.min.css">
    <link rel="stylesheet" href="../../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet"  href="vendor/DataTables/buttons.datatables.min.css">  

    <!-- Favicons -->
    <link  href="img/baguiologo.png" rel="icon">
    <link rel="apple-touch-icon" href="img/baguiologo.png">



    <!-- Scripts Required -->

    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../bower_components/select2/dist/js/select2.full.min.js"></script>
    <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="../bower_components/fastclick/lib/fastclick.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>
    <script src="./js/notification.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="vendor/jquery/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="vendor/DataTables/jquery.dataTables.min.js" type="text/javascript"></script> 
    <script src="vendor/DataTables/dataTables.buttons.min.js" type="text/javascript"></script> 
    <script src="vendor/DataTables/jszip.min.js" type="text/javascript"></script> 
    <script src="vendor/DataTables/pdfmake.min.js" type="text/javascript"></script> 
    <script src="vendor/DataTables/vfs_fonts.js" type="text/javascript"></script> 
    <script src="vendor/DataTables/buttons.html5.min.js" type="text/javascript"></script> 
    <script src="vendor/DataTables/buttons.print.min.js" type="text/javascript"></script> 
    <script src="../../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
          var table = $('#example').DataTable({dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Export to Excel',
                        title: 'REPORT ON PHYSICAL COUNT ON PROPERTY, PLANT, AND EQUIPMENT',
                        filename: 'ARE REPORT',
                        messageTop: '',
                        customize: function(xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];

                            // Apply basic Excel styling
                            $('th', sheet).each(function(index) {
                                $(this).attr('style', 'background-color: #f2f2f2; font-weight: bold;');
                            });

                            // Adjust column widths
                            $('col', sheet).each(function(index) {
                                if (index === 0) {
                                    $(this).attr('width', '30');
                                } else {
                                    $(this).attr('width', '30');
                                }
                            });
                        }
                    },
                    {
                        extend: 'print',
                        filename:'ARE PROPERTY REPORT',
                        messageTop: '<center><p style="font-weight: bold;">REPORT ON PHYSICAL COUNT OF PROPERTY, PLANT,AND EQUIPMENT<br><span style="text-decoration: underline;">(RESPONSIBILITY CENTER)</span><br> As of (Date)</p></center>',
                        messageBottom: '',
                        title:'',
                         customize: function(win)
                        {
                            var last = null;
                            var current = null;
                            var bod = [];
                            var css = '@page { size: landscape; margin: 10mm 10mm 0mm 10mm; }';
                                                css += 'table { border-collapse: collapse; width: 100%; }';
                                                css += 'th, td { border: 1px solid black; padding: 8px; text-align: left; }';
                                                css += 'th { background-color: #f2f2f2; font-weight: bold; }';
                                                css += '.subcolumn { border: 1px solid black; }';
                                                css += '.subcolumn, .print-hide { visibility: hidden; }';
                                                css += '.print-show-subcolumns .print-hide { visibility: visible; }';
                                head = win.document.head || win.document.getElementsByTagName('head')[0],
                                style = win.document.createElement('style');
                            style.type = 'text/css';
                            style.media = 'print';
                            if (style.styleSheet)
                            {
                              style.styleSheet.cssText = css;
                            }
                            else
                            {
                              style.appendChild(win.document.createTextNode(css));
                            }
                            head.appendChild(style);
                            
                        }               
                    }
                ]});

             // Event listener to the two range filtering inputs to redraw on input
                    $('#min, #max').change(function () {
                        table.draw();
                    });
             

        } );
    </script> 
    <style type="text/css">
            /* Hide subcolumn headers when printing */
            .print-hide {
                visibility: hidden;
            }

            /* Define styles for the printed table */
            table {
                width: 100%;
                border-collapse: collapse;
            }

            table, th, td {
                border: 1px solid black;
            }

            th, td {
                padding: 8px;
                text-align: left;
            }

            /* Additional styles for specific elements as needed */

            /* Adjust margins and page size for landscape printing */
            @page {
                size: landscape;
                margin: 10mm 10mm 0mm 10mm;
            }

            @media print {
                #header, #min, #max {
                    display: block;
                }

                .container {
                    margin-left: 0; /* Set margin-left to 0 for left alignment */
                }

                /* Show subcolumns in the print view */
                .print-show-subcolumns .print-hide {
                    visibility: visible;
                }
            }
        </style>

</head>
<body class="hold-transition skin-blue-light sidebar-mini">
    <div class="wrapper">
        <div class="content-wrapper">
        <!-- Main Content -->
        <section class="content container-fluid">
            <div class="box">
                <table id="example" class="table" cellspacing="0" width="100%">
                    <center>
                        <p>REPORT ON PHYSICAL COUNT OF PROPERTY, PLANT, AND EQUIPMENT<br>
                            <u style="text-decoration: underline;">OFFICE/DEPARTMENT</u><br>
                                (Responsibility Center)<br>
                                As of July 31, 2023</p>
                    </center>

                    <thead>
                        <tr>
                            <th style="border: 1px solid black;" rowspan="2">ARTICLE</th>
                            <th style="border: 1px solid black;" class="subcolumn" colspan="4">DESCRIPTION</th>
                            <th style="border: 1px solid black;" rowspan="2">eNGAS PROPERTY NUMBER</th>
                            <th style="border: 1px solid black;" rowspan="2">ACQUISITION DATE</th>
                            <th style="border: 1px solid black;"rowspan="2">ACQUISITION COST</th>
                            <th style="border: 1px solid black;" rowspan="2">PROPERTY NO.</th>
                            <th style="border: 1px solid black;" rowspan="2">CLASSIFICATION</th>
                            <th style="border: 1px solid black;" rowspan="2">EST. USEFUL LIFE</th>
                            <th style="border: 1px solid black;" rowspan="2">UNIT OF MEASURE</th>
                            <th style="border: 1px solid black;" rowspan="2">UNIT VALUE</th>
                            <th style="border: 1px solid black;" class="subcolumn" colspan="1">BALANCE PER CARD</th>
                            <th style="border: 1px solid black;" class="subcolumn" colspan="1">ON HAND PER COUNT</th>
                            <th style="border: 1px solid black;" class="subcolumn" colspan="2">SHORTAGE/OVERAGE</th>
                            <th style="border: 1px solid black;" rowspan="2">RESPONSIBILITY CENTER</th>
                            <th style="border: 1px solid black;" rowspan="2">ACCOUNTABLE PERSON</th>
                            <th style="border: 1px solid black;" rowspan="2">PREVIOUS CONDITION</th>
                            <th style="border: 1px solid black;" rowspan="2">LOCATION</th>
                            <th style="border: 1px solid black;" rowspan="2">CURRENT CONDITION</th>
                            <th style="border: 1px solid black;" rowspan="2">DATE OF PHYSICAL INVENTORY</th>
                            <th style="border: 1px solid black;"  rowspan="2">REMARKS</th>
                            <th style="border: 1px solid black;" class="subcolumn" colspan="5">ADDITIONAL DETAILS FOR RECONCILIATION PURPOSES</th>
                        </tr>
                        <tr>
                            <th style="border: 1px solid black;" class="subcolumn">Brand</th>
                            <th style="border: 1px solid black;" class="subcolumn">Serial Number</th>
                            <th style="border: 1px solid black;" class="subcolumn">Particulars</th>
                            <th style="border: 1px solid black;" class="subcolumn">MR Number</th>
                            <th style="border: 1px solid black;" class="subcolumn">(Qty)</th>
                            <th style="border: 1px solid black;" class="subcolumn">(Qty)</th>
                            <th style="border: 1px solid black;" class="subcolumn">(Qty)</th>
                            <th style="border: 1px solid black;" class="subcolumn">Value</th>
                            <th style="border: 1px solid black;" class="subcolumn">SUPPLIER</th>
                            <th style="border: 1px solid black;" class="subcolumn">PO NO.</th>
                            <th style="border: 1px solid black;" class="subcolumn">AIR/RIS NO.</th>
                            <th style="border: 1px solid black;" class="subcolumn">NOTES</th>
                            <th style="border: 1px solid black;" class="subcolumn">JEV NUMBER</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $connect = mysqli_connect('localhost','root','','db_gso');
                            $queryARE =  "SELECT
                                a.*,
                                ac.account_number AS classification,
                                COALESCE(co.office_name, no.noffice_name) AS responsibility_center,
                                c.condition_name AS current_condition
                                FROM
                                    are_properties a
                                LEFT JOIN
                                    account_codes ac ON a.classification_id = ac.account_number
                                LEFT JOIN
                                    city_offices co ON a.responsibilitycenter_id = co.office_name
                                LEFT JOIN
                                    national_offices no ON a.responsibilitycenter_id = no.noffice_name
                                LEFT JOIN
                                    conditions c ON a.currentconditionid = c.condition_name";
                            $pre_stmt = $connect->prepare($queryARE) or die(mysqli_error());
                            $pre_stmt->execute();
                            $result = $pre_stmt->get_result();

                        while ($row = mysqli_fetch_array($result)) {
                            echo'

                             <tr>
                                <td>' . $row['article'] . '</td>
                                <td>' . $row['brand'] . '</td>
                                <td>' . $row['serialno'] . '</td>
                                <td>' . $row['particulars'] . '</td>
                                <td>' . $row['AREno'] . '</td>
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
                        ?>
                    </tbody>
                </table>            
            </div><!-- Div box -->
        </section>
        </div>
    </div>


    <script>
      $(document).ready(function() {
        // Initialize DataTable
        var table = $('#table').DataTable({
          responsive: true,
          scrollX: true,
        });

        // Hide the "Additional Details for Reconciliation" column by default
        /*table.column(19).visible(false);*/

        // Event handler for checkbox clicks
        $('#column-selector').on('change', '.column-toggle', function() {
          var columnIndex = $(this).data('column');
          var column = table.column(columnIndex);
          column.visible(!column.visible());
        });
      });
    </script>
</body>
</html>