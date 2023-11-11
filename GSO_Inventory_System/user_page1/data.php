<?php
require './../database/connection.php';

//==================GET CLASSIFICATION=================================
if(isset($_POST["classification"]) && !empty($_POST["classification"])){

    $query = $connect->query("SELECT * FROM account_codes WHERE account_code_id = ".$_POST['classification']);
    $rowCount = $query->num_rows;
    

    if($rowCount > 0){
        echo '<option value="">---Select Classification---</option>';
        while($row = $query->fetch_assoc()){ 
            echo '<option value="'.$row['account_code_id'].'">'.$row['account_number'].'</option>';
        }
    }else{
        echo '<option value="">Classification not available</option>';
    }
}

//==================GET RESPONSIBILITY CENTER=================================
if(isset($_POST["account_code_id"]) && !empty($_POST["account_code_id"])){

    $query = $connect->query("SELECT co.office_id, co.office_name FROM city_offices co UNION ALL SELECT no.noffice_id, no.noffice_name FROM national_offices no");
    $rowCount = $query->num_rows;
    if($rowCount > 0){
    	while($row = $query->fetch_assoc()){ 
    		echo '<option value="'.$row['office_id'].'">'.$row['office_name'].'</option>';}
    }else{echo '<option value="">No Responsibility Center available</option>';}
}
//==================GET ACCOUNTABLE PERSON=================================
if(isset($_POST["accountable_person"]) && !empty($_POST["accountable_person"])){

    $query = $connect->query("SELECT * FROM employees");
    $rowCount = $query->num_rows;
    if($rowCount > 0){
    	while($row = $query->fetch_assoc()){ 
    		echo '<option value="'.$row['person_name'].'">'.$row['person_name'].'</option>';}
    }else{echo '<option value="">No employees available</option>';}
}
//==================GET CURRENT CONDITION=================================
if(isset($_POST["condition_id"]) && !empty($_POST["condition_id"])){

    $query = $connect->query("SELECT * FROM conditions");
    $rowCount = $query->num_rows;
    if($rowCount > 0){
        while($row = $query->fetch_assoc()){ 
            echo '<option value="'.$row['condition_name'].'">'.$row['condition_name'].'</option>';}
    }else{echo '<option value="">No conditions available</option>';}
}

?>