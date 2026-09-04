<?php
require_once('../controller/Student_Controller.php');
require_once('../controller/User_Controller.php');
require_once('../controller/Login_Controller.php');
require_once('../controller/Timesheet_Controller.php');

?>
<html>
<head>
    <title>SDC480 Capstone Project - Chris Blair </title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>GMAC - Timekeeping system</h1>
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