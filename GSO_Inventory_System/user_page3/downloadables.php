    <?php
    require('./../database/connection.php');
    require('../login/login_session.php');

    $uploadDirectory = '../admin_page/downloadables/'; // Directory where uploaded files will be stored

    // Read files in the "downloadables" directory
    $filesInDirectory = scandir($uploadDirectory);

    // Filter out ".", "..", and hidden files (if any)
    $filesInDirectory = array_diff($filesInDirectory, array('.', '..'));

    ?>

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
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="../dist/css/skins/skin-blue-light.min.css">

        <!-- Favicons -->
        <link  href="img/baguiologo.png" rel="icon">
        <link rel="apple-touch-icon" href="img/baguiologo.png">

        <style>
            /* Style for the modal background */
            .modal-background {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.7);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 999;
            }

            /* Style for the modal content */
            .modal-content {
                background: #fff;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                padding: 20px;
                text-align: center;
            }

            /* Style for the modal message */
            .modal-message {
                font-size: 18px;
                margin-bottom: 20px;
            }

            /* Style for the OK button */
            .ok-button {
                background: #007BFF;
                color: #fff;
                border: none;
                border-radius: 5px;
                padding: 10px 20px;
                cursor: pointer;
            }

            .ok-button:hover {
                background: #0056b3;
            }
        </style>
    </head>
    <body class="hold-transition skin-blue-light layout-top-nav">
    <div class="wrapper">
        <?php include_once("../user_page1/header/header.php");
        ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1><i class="fa fa-cloud-download"></i> DOWNLOADABLES</h1>
                    <ol class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-cloud-download"></i>Dashboard</a></li>
                        <li class="active">Downloadables</li>
                    </ol>
                </section>
                <section class="content container-fluid">
                    <div class="box">
                        <div class="box-header bg-blue" align="center">
                            <h4 class="box-title">DOWNLOADABLE FORMS</h4>
                        </div><br>

                        <!-- <form action="" method="post" enctype="multipart/form-data">
                            <label for="file">Choose files to upload:</label>
                            <input type="file" name="file[]" id="file" accept=".pdf, .doc, .docx, .xls, .xlsx" multiple>
                            <br>
                            <button type="submit" class="btn btn-primary" id="uploadForms" name="uploadForms">Upload Forms</button>
                        </form> --><br>

                        <!-- Uploaded Files Display Section -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><strong>Downloadable Files</strong></h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <!-- box header -->
                            <div class="box-body">
                                <div class="row">
                                    <?php foreach ($filesInDirectory as $file): ?>
                                        <div class="col-md-4 col-sm-6 col-sx-12">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-green"><i class="fa fa-files-o"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-number"><?php echo $file; ?></span>
                                                    <i class="fa fa-download"></i><a href="<?php echo $uploadDirectory . $file; ?>" class="small-box-footer" download>Click here to download the file</a>
                                                </div>
                                                <!-- info box content -->
                                            </div>
                                            <!-- info box -->
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <!-- End Uploaded Files Display Section -->
                    </div>
                </section>
            </div>    
        </div>

        <script src="../bower_components/jquery/dist/jquery.min.js"></script>
        <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
        <script src="../dist/js/moment.min.js"></script>
        <script src="../dist/js/fullcalendar.min.js"></script>
        <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="../bower_components/fastclick/lib/fastclick.js"></script>
        <script src="../dist/js/adminlte.min.js"></script>
        <script src="../bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

        <script>
        function closeModal() {
            var modal = document.querySelector('.modal-background');
            modal.style.display = 'none';
        }

        // Function to redirect to a page
        function redirectToPage(page) {
            window.location.href = page;
        }
        </script>
    </body>
    </html>