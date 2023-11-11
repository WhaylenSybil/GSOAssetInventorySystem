<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['accountable_person'], $_POST['rescenter'])) {
        $employeeName = $_POST['accountable_person'];
        $office = $_POST['rescenter'];

        // Replace with your database connection details
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "db_gso";

        // Create a database connection
        $connect = new mysqli($hostname, $username, $password, $database);

        // Check the database connection
        if ($connect->connect_error) {
            die("Connection failed: " . $connect->connect_error);
        }

        // Insert the new employee into the database
        $insertEmployeeQuery = "INSERT INTO employees (employeeName, office) VALUES (?, ?)";

        $insertEmployeeStmt = $connect->prepare($insertEmployeeQuery);
        $insertEmployeeStmt->bind_param('ss', $employeeName, $office);

        if ($insertEmployeeStmt->execute()) {
            echo "Employee saved successfully";
        } else {
            echo "Error saving employee: " . $connect->error;
        }

        // Close the database connection
        $connect->close();
    } else {
        echo "Invalid data received";
    }
} else {
    echo "Invalid request method";
}
?>