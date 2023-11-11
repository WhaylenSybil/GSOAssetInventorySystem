<?php
// get_condition_id.php
if (isset($_POST['condition_id'])) {
    $conditionid = $_POST['condition_id'];

    // Modify this query to retrieve condition_id based on the condition name
    $query = "SELECT condition_id, condition_name FROM conditions WHERE condition_name = ?";
    
    $stmt = $connect->prepare($query);
    $stmt->bind_param('s', $condition_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo $row['condition_id'];
    } else {
        echo 'Condition Name not found'; // Return an empty string if condition not found
    }
} else {
    echo 'Condition name not found'; // Return an empty string if condition_name is not set
}
?>
