<?php
session_start();
require_once('../Controller/Student_Controller.php');
require_once('../Utility/Security.php');
Security::checkAuthority([2]);
if (isset($_POST['logout'])) { Security::logout(); }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GMAC Timekeeping System</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4"
        crossorigin="anonymous">
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
        <h2 class="text-center">Student Management</h2>
        <a href="Add_Student.php" class="btn btn-primary">Add New Student</a>
        <p>
            <?php
            try{ 
                $students = StudentController::getAllStudents();
                if ($students) {
                    echo '<table class="table table-striped"> 
                            <tr>
                                <th scope="col">Student ID</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">First Name</th>
                                <th scope="col">School</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>';
                foreach ($students as $student) {
                    $ID = htmlspecialchars($student->getStudID(), ENT_QUOTES);
                    $LastName = htmlspecialchars($student->getLastName(), ENT_QUOTES);
                    $FirstName = htmlspecialchars($student->getFirstName(), ENT_QUOTES);
                    $School = htmlspecialchars($student->getSchool(), ENT_QUOTES);
                    echo '<tr>
                            <td>' . $ID . '</td>
                            <td>' . $LastName . '</td>
                            <td>' . $FirstName . '</td>
                            <td>' . $School . '</td>
                            <td><a href="Edit_Student.php?ID=' . $ID . '">Edit</a></td>
                            <td><a href="Delete_Student.php?ID=' . $ID . '">Delete</a></td>
                          </tr>';
                }
                echo '</table>';
                } else {
                    echo '<p class="error">No students could be retrieved.</p>'; 
                }
            } catch (Exception $e) {
                echo '<p class="text-center" style="color:red">An Exception occurred. Message: ' . $e->getMessage() . ' </p>';
                echo '<p class="text-center" style="color:red">The system is busy. Please try again later.</p>';
            } catch (Error $e) {
                echo '<p class="text-center" style="color:red">An Error occurred. Message: ' . $e->getMessage() . ' </p>';
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