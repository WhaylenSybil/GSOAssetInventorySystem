<?php
require('./../database/connection.php');
require('../login/login_session.php');
?>
<!DOCTYPE html>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>GSO Inventory System</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../bower_components/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" href="../dist/css/fullcalendar.min.css">
  <link rel="stylesheet" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="../dist/css/skins/skin-blue-light.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->

  <!-- Favicons -->
  <link  href="img/baguiologo.png" rel="icon">
  <link rel="apple-touch-icon" href="img/baguiologo.png">

  <style>
    /* Modal background overlay */
    .modal-background {
        display: flex;
        justify-content: center;
        align-items: center;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 999;
    }

    /* Modal content */
    .modal-content {
        background: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        text-align: center;
    }

    /* Modal message text */
    .modal-message {
        font-size: 18px;
        margin-bottom: 20px;
    }

    /* OK button */
    .ok-button {
        background: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .ok-button:hover {
        background: #0056b3;
    }

  </style>

</head>

<body class="hold-transition skin-blue-light sidebar-mini  fixed ">
<div class="wrapper">

<?php include_once("../admin_page/header/header.php"); 
include("../admin_page/header/sidebar.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->  
    <section class="content-header">
      <h1><i class="fa fa-plus"></i> 
        DATA LIST
        <small>Manage your list of offices, account codes, and employees</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>

        <li class="active">Data List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
 <!-- ===========================================================================================================================--> 
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_employee_modal">
  <span class="fa fa-fw fa-plus" aria-hidden="true"></span>
  Add Employee
</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#city_offices_modal"><span class="fa fa-fw fa-plus" aria-hidden="true"></span>
Add City Office
</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#national_offices_modal"><span class="fa fa-fw fa-plus" aria-hidden="true"></span>
Add Natinoal Office
</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#account_codes_modal"><span class="fa fa-fw fa-plus" aria-hidden="true"></span>
Add Account for Equipment
</button>


<div class="box">
    <div class="box-header bg-blue" align="center">
      <h4 class="box-title"></h4>
    </div>
    <br>
    <div class="card-body">
      <!-- Button trigger modal -->
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link" href="#employees" role="tab" data-toggle="tab">Employees with Accountabilities</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="#cityoffice" role="tab" data-toggle="tab">City Offices</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#nationaloffice" role="tab" data-toggle="tab">National Offices</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#account" role="tab" data-toggle="tab">Account for equipment</a>
        </li>
        
      </ul>

      <br>
      <!-- Tab panes -->
      <div class="tab-content">
        <!-- employees table -->
          <div role="tabpanel" class="tab-pane fade in active" id="employees">
            <table id="example4" class="table table-hover" cellspacing="0" width="100%">
                <thead>
                  <tr>
                      
                      <th>Employee Name</th>
                      <th>TIN Number</th>
                      <th>Employee ID Number</th>
                      <th>Office/Department</th>
                      <th>Remarks</th>
                      
                       <th>Action</th>
                  </tr>
                </thead>
                 <tbody >
                  <?php include_once("../admin_page/includes/manage_employee_table.php") ?>
                </tbody> 
            </table>
          </div>
        <!-- City Office table -->
        <div role="tabpanel" class="tab-pane fade" id="cityoffice">
            <table id="example1" class="table table-hover" cellspacing="0" width="100%">
                  <thead>
                      <tr>
                          
                          <th>City Office Name</th>
                          <th>Code Number</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                   <tbody >
                     <?php include_once("../admin_page/includes/manage_cityoffices_table.php") ?>
                  </tbody> 
            </table>
          </div>
        <!-- National office table -->
          <div role="tabpanel" class="tab-pane fade" id="nationaloffice">
            <table id="example2" class="table table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        
                        <th>Office Name</th>
                        <th>Code Number</th>
                         <th>Action</th>
                    </tr>
                </thead>
                 <tbody >
                  <?php include_once("../admin_page/includes/manage_nationaloffices_table.php") ?>
                </tbody> 
            </table>
          </div>
          <!-- account codes table -->
          <div role="tabpanel" class="tab-pane fade" id="account">
            <table id="example3" class="table table-hover" cellspacing="0" width="100%">
                <thead>
                  <tr>
                      
                      <th>Account Title</th>
                      <th>Account Code</th>
                       <th>Action</th>
                  </tr>
                </thead>
                 <tbody >
                  <?php include_once("../admin_page/includes/manage_accountcodes_table.php") ?>
                </tbody> 
            </table>
          </div>
          
      </div><!-- div tab content -->
    </div><!-- div card body -->
</div><!-- div box -->

    <?php
    include_once("../admin_page/modals/employee_modal.php");
    include_once("../admin_page/modals/city_offices_modal.php");
    include_once("../admin_page/modals/national_offices_modal.php");
    include_once("../admin_page/modals/accountcodes_modal.php");
    ?>



    <!--======================================================================================================================================== -->
    </section>
    <!-- /.content -->


  </div>
  <!-- /.content-wrapper -->
  

</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!--  <script src="./js/add_college.js"></script>
<script src="./js/add_course.js"></script>
<script src="./js/add_office.js"></script> -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../dist/js/moment.min.js"></script>
<script src="../dist/js/fullcalendar.min.js"></script>
<!-- ======================================================================================= -->
<script src="../bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="../bower_components/fastclick/lib/fastclick.js"></script>
<script src="../dist/js/adminlte.min.js"></script>
<script src="../bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable({responsive:true,  lengthMenu: [25, 50, 100, 200, 500],})
    $('#example3').DataTable({responsive:true , lengthMenu: [25, 50, 100, 200, 500],})
    $('#example2').DataTable({responsive:true,  lengthMenu: [25, 50, 100, 200, 500],})
    $('#example4').DataTable({responsive:true,  lengthMenu: [25, 50, 100, 200, 500],})
  })

</script>
<!-- ======================================================================================= -->
<script>
    $(document).ready(function(){
     $('#insert_formcityoffices').on("submit", function(event){  
      event.preventDefault();  
      if($('#cityoffice_name').val() == "")  
      {  
       alert("City Office Name is required");  
      }  

      else  
      {  
       $.ajax({  
        url:"modals/insert/insert_city_offices.php",  
        method:"POST",  
        data:$('#insert_formcityoffices').serialize(),  
        beforeSend:function(){  
         $('#insertcityoffice').val("Inserting");  
        },  
        success:function(data){  
         $('#insert_formcityoffices')[0].reset();  
         $('#city_offices_modal').modal('hide');  
         alert(data); 
         location.reload();
        }  
       });  
      }  
     });

    });
</script>
<!-- End of Script for City Offices -->
<!-- ==================================================================== -->
<!-- Start Script for National Offices -->
  <script>
    $(document).ready(function(){
     $('#insert_formnationaloffices').on("submit", function(event){  
      event.preventDefault();  
      if($('#nationaloffice_name').val() == "")  
      {  
       alert("National Office Name is required");  
      }  

      else  
      {  
       $.ajax({  
        url:"modals/insert/insert_national_offices.php",  
        method:"POST",  
        data:$('#insert_formnationaloffices').serialize(),  
        beforeSend:function(){  
         $('#insertnationaloffice').val("Inserting");  
        },  
        success:function(data){  
         $('#insert_formnationaloffices')[0].reset();  
         $('#national_offices_modal').modal('hide');  
         alert(data); 
         location.reload();
        }  
       });  
      }  
     });

    });
</script>
<!-- End for National Offices -->

<!-- Start Script for National Offices -->
  <script>
    $(document).ready(function(){
      $('#insert_formaccountcodes').on("submit", function(event){  
        event.preventDefault();  
        if($('#accounttitle').val() == "") {  
          alert("Account Title is required");  
        } else {  
          $.ajax({  
            url: "modals/insert/insert_account_codes.php",  
            method: "POST",  
            data: $('#insert_formaccountcodes').serialize(),  
            beforeSend: function(){  
              $('#insertaccountcode').val("Inserting");  
            },  
            success: function(data){  
              $('#insert_formaccountcodes')[0].reset();  
              $('#account_codes_modal').modal('hide');  
              alert(data); 
              location.reload();
            }  
          });  
        }  
      });
    });
</script>
<!-- End Script for Account Codes for Equipment -->
<!-- Start Script for Employees -->
<script>
    $(document).ready(function(){
      $('#insert_form_employee').on("submit", function(event){  
        event.preventDefault();  
        if ($('#employeeName').val() == "") {  
          alert("Employee Name is required");  
        } else if ($('#office_department').val() == "") {  
          alert("Office/Department is required");  
        } else {  
          $.ajax({  
            url: "modals/insert/insert_employee.php",  // Replace with the actual URL for handling employee insertion
            method: "POST",  
            data: $('#insert_form_employee').serialize(),  
            beforeSend: function(){  
              $('#insert_employee').val("Inserting");  
            },  
            success: function(data){  
              $('#insert_form_employee')[0].reset();  
              $('#add_employee_modal').modal('hide');  
              alert(data); 
              location.reload();
            },
            error: function(xhr, status, error) {
              alert("An error occurred: " + error);
            }
          });  
        }  
      });
    });
</script>
<!-- End Script for Employees -->

<script>
    function showSuccessModal(message) {
        var modal = document.querySelector(".modal-background");
        var modalContent = document.querySelector(".modal-content");
        var modalMessage = document.querySelector(".modal-message");
        
        modalMessage.textContent = message;
        modal.style.display = "block";

        // Close the modal when the OK button is clicked
        var okButton = document.querySelector(".ok-button");
        okButton.onclick = function () {
            modal.style.display = "none";
        };
    }
</script>
</body>
</html>