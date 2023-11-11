<header class="main-header">
    <nav class="navbar navbar-static-top">
        <!-- <div class="container"> -->
            <div class="navbar-header">
                <a href="dashboard.php" class="navbar-brand" style="font-size: 16px;">General Services Office - Assets Inventory System</a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="dashboard.php">HOME<span class="sr-only">(current)</span></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="fa fa-folder-open">&nbsp</span>
                            Active Properties
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="active_PPE.php">Active ARE</a></li>
                            <li><a href="active_semi_expendable.php">Active ICS</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="fa fa-files-o">&nbsp</span>
                            Inactive Properties
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="inactivePPE.php">Inactive ARE</a></li>
                            <li><a href="inactiveSemi.php">Inactive ICS</a></li>
                        </ul>
                    </li>
                    <li><a href="PRS.php"><i class="fa fa-times"></i> <span>PRS</span></a></li>
                    <li><a href="WMR.php"><i class="fa fa-times-circle"></i> <span>WMR</span></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="fa fa-files-o">&nbsp</span>
                            Printable Reports
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="AREperAccountableEmployee.php">ARE by Accountable Employee</a></li>
                            <li><a href="AREperYear.php">ARE by Year</a></li>
                            <li><a href="AREperOffice.php">ARE by Office/Department</a></li>
                            <li><a href="AREperAccountCode.php">ARE by Account Code</a></li>
                            <li><a href="AREperAccountCode.php">ICS by Accountable Employee</a></li>
                            <li><a href="AREperAccountCode.php">ICS by Year</a></li>
                            <li><a href="AREperAccountCode.php">ICS by Office/Department</a></li>
                            <li><a href="AREperAccountCode.php">ICS by Account Code</a></li>
                            <li><a href="prsPrintReport.php" target="_blank">PRS</a></li>
                            <li><a href="wmrPrintReport.php" target="_blank">WMR</a></li>
                        </ul>
                    </li>
                    <li><a href="downloadables.php"><i class="fa fa-cloud-download"></i> <span>Downloadable Forms</span></a></li>
                </ul>
                <div class="navbar-custom-menu"> <!-- Move the user menu to the right -->
                    <ul class="nav navbar-nav">
                        <!-- Notification -->
                        <!-- User Account: Can be found in the dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="../dist/img/male.jpg" class="user-image" alt="User Image">
                                <span class="hidden-xs"><?php echo $_SESSION['firstname']; ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User Image -->
                                <li class="user-header">
                                    <img src="../dist/img/baguiologo.png" class="img-circle" alt="User Image">
                                    <p>
                                        <?php echo $_SESSION['firstname']; ?>
                                    </p>
                                </li>
                                <!-- Menu Footer for the User Image -->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="change_password.php" type="button" class="btn btn-default btn-flat">Change Password</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="../login/logout.php" class="btn btn-default btn-flat"><i class="fa fa-sign-out">Sign Out</i></a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- navbar custom-menu -->
            </div><!-- navbar collapse -->
        <!-- </div> -->

    </nav>
    
</header>