<?php
if (isset($_GET['center'])) {
    $selectedCenter = $_GET['center'];
    
    // Database connection parameters (update with your actual database details)
    $dbHost = 'localhost';
    $dbName = 'db_gso';
    $dbUsername = 'root';
    $dbPassword = '';

    // Establish a database connection
    try {
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute a SQL query to fetch employees in the selected center
        if ($selectedCenter === '') {
            // If no center is selected, fetch all employees
            $sql = "SELECT * FROM employees";
            $stmt = $pdo->query($sql);
        } else {
            $sql = "SELECT * FROM employees WHERE office = :center ORDER BY employeeName";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':center', $selectedCenter);
            $stmt->execute();
        }

        // Fetch the results as an associative array
        $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return the array as JSON
        echo json_encode($employees);
    } catch (PDOException $e) {
        echo json_encode(array('error' => 'Database connection error: ' . $e->getMessage()));
    }
} else {
    echo json_encode(array());
}
?>