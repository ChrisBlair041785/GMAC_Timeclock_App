<?php
session_start();
require_once('../Controller/Timeclock_Controller.php');
require_once('../Utility/Security.php');
Security::checkAuthority([1, 2]);
if (isset($_POST['logout'])) { Security::logout(); }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GMAC Timekeeping System</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" shrink-to-fit="no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4"
        crossorigin="anonymous">
        <link rel="stylesheet" href="../Utility/style.css">
    </head>
    <body>
        <div class="container" style="margin-top: 30px">
            <header class="jumbotron text-center row"
            style="margin-bottom:2px; background: linear-gradient(white, #e68a00); padding:20px;">
            <div class="col-sm-2">
               <img class="img-fluid float-left" style="width:100px; height:100px;" src="../GMAC Logo.png" alt="Logo">
           </div>
           <div class="col-sm-8">
               <h1 class="font-bold" style="text-align:center";>GMAC - Timekeeping System</h1>    
           </div>
       </header>
       <div class="row" style="padding-left: 0px;">
        <nav class="col-sm-2">
            <ul class="nav nav-pills flex-column">
                <?php include('../controller/nav.php'); ?>
            </ul>
        </nav>
        <div class="col-sm-8">
        <h2 class="text-center">Daily Time Clock-In/Out</h2>
        <p class="text-center">Sort students by:</p>
        <form method="get" action="Timeclock.php" class="text-center mb-3">
            <button type="submit" name="sort" value="id" class="btn btn-primary">Student ID</button>
            <button type="submit" name="sort" value="lastname" class="btn btn-primary">Last Name</button>
            <button type="submit" name="sort" value="firstname" class="btn btn-primary">First Name</button>
            <button type="submit" name="sort" value="school" class="btn btn-primary">School</button>
        </form>
        <p class="text-center">Please use the buttons below to clock in or out the studentsfor the day.</p>
        <?php
        $sort = $_GET['sort'] ?? 'lastname';
        try {
                $students = TimeclockController::getStudentStatuses($sort);
                if ($students) {
                    echo '<table class="table table-striped"> 
                            <tr>
                                <th scope="col">Student ID</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">First Name</th>
                                <th scope="col">School</th>
                                <th scope="col">Clock In/Out</th>
                            </tr>';
                foreach ($students as $student) {
                    $ID = htmlspecialchars($student['StudID'], ENT_QUOTES);
                    $LastName = htmlspecialchars($student['LastName'], ENT_QUOTES);
                    $FirstName = htmlspecialchars($student['FirstName'], ENT_QUOTES);
                    $School = htmlspecialchars($student['School'], ENT_QUOTES);
                    $arrived = $student['Arrived'];
                    $departed = $student['Departed'];
                    $action = ($arrived !== null && $departed === null) ? 'clock_out' : 'clock_in';
                    $buttonClass = $action === 'clock_in' ? 'btn-success' : 'btn-danger';
                    $buttonText = $action === 'clock_in' ? 'Clock In' : 'Clock Out';
                    echo '<tr>
                            <td>' . $ID . '</td>
                            <td>' . $LastName . '</td>
                            <td>' . $FirstName . '</td>
                            <td>' . $School . '</td>
                            <td colspan="2"><form action="../Controller/Timeclock_Controller.php" method="post">
                                <input type="hidden" name="ID" value="' . $ID . '">
                                <button type="submit" name="action" value="' . $action . '" class="btn ' . $buttonClass . '">' . $buttonText . '</button>
                            </form></td>
                          </tr>';
                }
                echo '</table>';
                } else {
                    echo '<p class="error">No student timeclock records could be retrieved.</p>'; 
                }
        } catch (Exception $e) {
            echo '<p class="text-center" style="color:red">The system is busy. Please try again later.</p>';
        }
        ?>
        </div>
        <aside class="col-sm-2">
            <?php include('../Controller/User_Buttons.php'); ?>
        </aside>
    </div>
    </body>
</html>