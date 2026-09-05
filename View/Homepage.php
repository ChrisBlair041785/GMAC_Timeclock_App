<?php
require_once('../controller/Student_Controller.php');
require_once('../controller/User_Controller.php');
require_once('../controller/Login_Controller.php');
require_once('../controller/Timeclock_Controller.php');
?>
 <!DOCTYPE html>
<html lang="en">
<head>
    <title>SDC480 Capstone Project - Chris Blair </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container" style="margin-top: 30px">
        <!-- Header Section                             #1-->
         <header class="jumbotron text-center row"
         style="margin-bottom:2px; background: linear-gradient(white, #e68a00); padding:20px;">
         <div class="col-sm-2">
            <img class="img-fluid float-left" style="width:100px; height:100px;" src="../GMAC Logo.png" alt="Logo">
        </div>
        <div class="col-sm-8">
            <h1 class="font-bold" style="text-align:center";>GMAC - Timekeeping System</h1>    
        </div>
    </header>
    
    <p>Welcome to the GMAC Timekeeping system. Please use the navigation menu to access different sections of the system.</p>
    <nav>
        <ul>
            <li><a href="UserManagement.php">User Management</a></li>
            <li><a href="LoginManagement.php">Login Management</a></li>
            <li><a href="StudentManagement.php">Student Management</a></li> 
            <li><a href="Timekeeping.php">Daily Time Sheets</a></li>
            <li><a href="TimeReports.php">Timesheet Reports</a></li>
        </ul>
    </nav>
</body>

</html>