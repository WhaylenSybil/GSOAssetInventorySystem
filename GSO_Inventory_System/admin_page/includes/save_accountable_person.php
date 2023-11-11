<?php
// Establish a database connection
$connect = mysqli_connect('localhost', 'root', '', 'db_gso') or die(mysqli_error());

if (isset($_POST['manual_accoutable_person'])) {
    $manualAccperson = $_POST['manual_accoutable_person'];

    // Insert the manually entered accountable person into the database
    $query = "INSERT INTO `employees` ('person_name') VALUES (?)";

    $stmt = $connect->prepare($query);
    $stmt->bind_param('s', $manualAccperson);

    if ($stmt->execute()) {
        echo "Manually entered accountable person saved successfully!";
    } else {
        echo "Error saving manually entered accountable person: " . $stmt->error;
    }

    $stmt->close();
}

// Close the database connection
$connect->close();
?>