<?php
require_once("../Model/student_info.php");

//Query for all students 
$results = All_Students(); 

//Variables for Student data
$StudentID = -1;
$FirstName = "";
$LastName = "";
$School = "";
$addMessage = "";
$addMessageClass = "";

$add = $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit']);
$edit = false; 
$update = false; 
$delete = false; 

if (isset($_POST['StudentID'])) {
    $StudentID = $_POST['StudentID'];
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $School = $_POST['School'];
}

if ($add) {
    //Add new entry 
    $FirstName = $_POST['FirstName'] ?? '';
    $LastName = $_POST['LastName'] ?? '';
    $School = $_POST['School'] ?? '';

    $addQueryDB = Add_StudentDB($FirstName, $LastName, $School);
    //$addQueryTC = Add_StudentTC();  && $addQueryTC

    if ($addQueryDB ) {
        $addMessage = "Student added successfully.";
        $addMessageClass = "alert-success";

        //Clear the fields after a successful insert
        $StudentID = -1;
        $FirstName = "";
        $LastName = "";
        $School = "";
    } else {
        $addMessage = "Student could not be added. Please try again.";
        $addMessageClass = "alert-danger";
    }
}
else if ($edit) {
    //Gets the students information from the database based on the StudentID
    $student = Get_Student_By_ID($StudentID);

    //Fills in values of the student to be edited
    if ($student instanceof mysqli_result) {
        $student = mysqli_fetch_assoc($student);
    }
    if (is_array($student)) {
        $FirstName = $student['FirstName'] ?? '';
        $LastName = $student['LastName'] ?? '';
        $School = $student['School'] ?? '';
    }
}
else if ($update) {
    //Updates the valuses of the student
    $FirstName = $_POST['FirstName'] ?? '';
    $LastName = $_POST['LastName'] ?? '';
    $School = $_POST['School'] ?? '';

    $updateQuery = Update_Student($StudentID, $FirstName, $LastName, $School);

    //Clear the fields after update
    $StudentID = -1;
    $FirstName = "";
    $LastName = "";
    $School = "";
}
else if ($delete) {
    //Deletes the student based on the StudentID
    $deleteQuery = Delete_Student($StudentID);

    //Clear the fields after delete
    $StudentID = -1;
}
?>