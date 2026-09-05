<?php
require_once("../Model/Logins.php");

//Query for all students 
$results = All_Users(); 

//Variables for Student data
$LoginID = -1;
$UserName = "";
$Password = "";

$add = false; 
$edit = false; 
$update = false; 
$delete = false; 

if (isset($_POST['LoginID'])) {
    $LoginID = $_POST['LoginID'];
    $UserName = $_POST['UserName'];
    $Password = $_POST['Password'];
}

if ($add) {
    //Add new entry 
    $UserName = $_POST['UserName'] ?? '';
    $Password = $_POST['Password'] ?? '';

    $addQuery = Add_User($UserName, $Password);

    //Clear the fields
    $LoginID = -1;
    $UserName = "";
    $Password = "";
}
else if ($edit) {
    //Gets the students information from the database based on the ID
    $student = Get_User_By_ID($LoginID);

    //Fills in values of the student to be edited
    if ($student instanceof mysqli_result) {
        $student = mysqli_fetch_assoc($student);
    }
    if (is_array($student)) {
        $UserName = $student['UserName'] ?? '';
        $Password = $student['Password'] ?? '';
    }
}
else if ($update) {
    //Updates the valuses of the student
    $UserName = $_POST['UserName'] ?? '';
    $Password = $_POST['Password'] ?? '';

    $updateQuery = Update_User($LoginID, $UserName, $Password);

    //Clear the fields after update
    $LoginID = -1;
    $UserName = "";
    $Password = "";
}
else if ($delete) {
    //Deletes the student based on the StudentID
    $deleteQuery = Delete_User($LoginID);

    //Clear the fields after delete
    $LoginID = -1;
}
?>