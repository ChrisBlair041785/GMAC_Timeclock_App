<?php
require_once("../Model/User_info.php");

//Query for all users 
$results = All_Users(); 

//Variables for Student data
$ID = -1;
$FirstName = "";
$LastName = "";
$Email = "";
$Password1 = "";
$password2 = "";

$add = false; 
$edit = false; 
$update = false; 
$delete = false; 

if (isset($_POST['ID'])) {
    $ID = $_POST['ID'];
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $Email = $_POST['Email'];
    $Password1 = $_POST['Password'] ?? '';
    
}

if ($add) {
    //Add new entry 
    $FirstName = $_POST['FirstName'] ?? '';
    $LastName = $_POST['LastName'] ?? '';
    $Email = $_POST['Email'] ?? '';
    $Password1 = $_POST['Password'] ?? '';
             

    $addQuery = Add_User( $LastName, $FirstName, $Email, $Password);

    //Clear the fields
    $ID = -1;
    $FirstName = "";
    $LastName = "";
    $Email = "";
    $Password1 = "";
    $password2 = "";
}
else if ($edit) {
    //Gets the user's information from the database based on the ID
    $User = Get_User_By_ID($ID);

    //Fills in values of the user to be edited
    if ($User instanceof mysqli_result) {
        $User = mysqli_fetch_assoc($User);
    }
    if (is_array($User)) {
        $FirstName = $User['FirstName'] ?? '';
        $LastName = $User['LastName'] ?? '';
        $Email = $User['Email'] ?? '';
    }
}
else if ($update) {
    //Updates the valuses of the user
    $FirstName = $_POST['FirstName'] ?? '';
    $LastName = $_POST['LastName'] ?? '';
    $Email = $_POST['Email'] ?? '';
    $Password = $_POST['Password'] ?? '';
    

    $updateQuery = Update_User($ID, $FirstName, $LastName, $Email, $Password);

    //Clear the fields after update
    $ID = -1;
    $FirstName = "";
    $LastName = "";
    $Email = "";
    $Password = "";
}
else if ($delete) {
    //Deletes the user based on the ID
    $deleteQuery = Delete_User($ID);

    //Clear the fields after delete
    $ID = -1;
}
?>