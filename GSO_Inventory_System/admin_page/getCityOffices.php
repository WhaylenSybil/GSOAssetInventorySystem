<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db_gso';

$connect = new mysqli($host, $username, $password, $database);

if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

// Query to fetch city offices
$query = "SELECT office_name FROM city_offices";
$result = $connect->query($query);

if ($result) {
    $cityOfficeOptions = array();

    while ($row = $result->fetch_assoc()) {
        $cityOfficeOptions[] = $row['office_name'];
    }

    echo json_encode($cityOfficeOptions);
} else {
    echo json_encode(array()); // Return an empty array if there was an error
}

$connect->close();
?>