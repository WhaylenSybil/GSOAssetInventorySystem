<?php
require('./../database/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["excel_file"])) {
    $file_name = $_FILES["excel_file"]["name"];
    $file_tmp = $_FILES["excel_file"]["tmp_name"];
    
    if (move_uploaded_file($file_tmp, "uploads/$file_name")) {
        $xls = PHPExcel_IOFactory::load("uploads/$file_name");
        $conn = connectToDatabase(); // Implement this function in database.php

        foreach ($xls->getWorksheetIterator() as $worksheet) {
            $sheet_name = $worksheet->getTitle();
            $data = [];
            
            foreach ($worksheet->getRowIterator() as $row) {
                $cell_values = [];
                foreach ($row->getCellIterator() as $cell) {
                    $cell_values[] = $cell->getValue();
                }
                $data[] = $cell_values;
            }
            
            // Convert the data to JSON and insert it into the database
            $data_json = json_encode($data);
            $sql = "INSERT INTO are_properties (, data) VALUES ('$sheet_name', '$data_json')";
            $conn->query($sql);
        }
        
        $conn->close();
        alert("Excel file uploaded and data saved to the database.");
        echo '<script type="text/javascript">window.location = "active_PPE.php"</script>';
    } else {
        alert("Failed to upload the Excel file.");
        echo '<script type="text/javascript">window.location = "active_PPE.php"</script>';
    }
}
?>