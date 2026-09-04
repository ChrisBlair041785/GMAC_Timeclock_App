<?php
require_once("../Model/database.php");

//Query for all students 
$results = All_Users(); 

//Variables for Student data
$ID = -1;
$FirstName = "";
$LastName = "";
$AccessLevel = "";

$add = false; 
$edit = false; 
$update = false; 
$delete = false; 

if (isset($_POST['ID'])) {
    $ID = $_POST['ID'];
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $AccessLevel = $_POST['AccessLevel'];
}

if ($add) {
    //Add new entry 
    $FirstName = $_POST['FirstName'] ?? '';
    $LastName = $_POST['LastName'] ?? '';
    $AccessLevel = $_POST['AccessLevel'] ?? '';

    $addQuery = Add_User($FirstName, $LastName, $AccessLevel);

    //Clear the fields
    $ID = -1;
    $FirstName = "";
    $LastName = "";
    $AccessLevel = "";
}
else if ($edit) {
    //Gets the students information from the database based on the ID
    $student = Get_User_By_ID($ID);

    //Fills in values of the student to be edited
    if ($student instanceof mysqli_result) {
        $student = mysqli_fetch_assoc($student);
    }
    if (is_array($student)) {
        $FirstName = $student['FirstName'] ?? '';
        $LastName = $student['LastName'] ?? '';
        $AccessLevel = $student['AccessLevel'] ?? '';
    }
}
else if ($update) {
    //Updates the valuses of the student
    $FirstName = $_POST['FirstName'] ?? '';
    $LastName = $_POST['LastName'] ?? '';
    $AccessLevel = $_POST['AccessLevel'] ?? '';

    $updateQuery = Update_User($ID, $FirstName, $LastName, $AccessLevel);

    //Clear the fields after update
    $ID = -1;
    $FirstName = "";
    $LastName = "";
    $AccessLevel = "";
}
else if ($delete) {
    //Deletes the student based on the StudentID
    $deleteQuery = Delete_User($ID);

    //Clear the fields after delete
    $ID = -1;
}
?>