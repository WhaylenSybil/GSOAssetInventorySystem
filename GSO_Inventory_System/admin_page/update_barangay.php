<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "db_gso");

if (!empty($_POST)) {
    $updatedBarangayName = mysqli_real_escape_string($connect, $_POST['updatedBarangayName']);

    // Check if the updated barangay name already exists
    $query = "SELECT COUNT(barangayName) AS num FROM barangayList WHERE barangayName = ?";
    $pre_stmt = $connect->prepare($query) or die(mysqli_error());
    $pre_stmt->bind_param("s", $updatedBarangayName);
    $pre_stmt->execute();
    $result = $pre_stmt->get_result();
    $row = mysqli_fetch_array($result);

    if ($row['num'] == 0) {
        // Updated barangay name doesn't exist, so update it
        $updateQuery = "UPDATE barangayList SET barangayName = ? WHERE barangayID = ?";
        $pre_stmt = $connect->prepare($updateQuery) or die(mysqli_error());
        $pre_stmt->bind_param('si', $updatedBarangayName, $_SESSION['barangayID']); // Replace $_SESSION['barangayID'] with the actual session variable containing the barangayID
        $pre_stmt->execute();

        date_default_timezone_set('Asia/Manila');
        $dateNow = date('Y-m-d');
        $timeNow = date('H:i:s');
        $logMessage = 'Updated a barangay';
        $employeeID = $_SESSION['employeeid'];
        $firstName = $_SESSION['firstname'];

        // Insert an entry into the activity log
        $logQuery = "INSERT INTO activity_log (employeeid, firstname, date_log, time_log, action) VALUES (?, ?, ?, ?, ?)";
        $logStmt = $connect->prepare($logQuery);
        $logStmt->bind_param('issss', $employeeID, $firstName, $dateNow, $timeNow, $logMessage);
        $logStmt->execute();

        echo "Barangay is successfully updated.";
    } else {
        echo "Barangay name already exists";
    }
}
?>