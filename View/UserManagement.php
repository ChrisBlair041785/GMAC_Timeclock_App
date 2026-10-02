<?php
session_start();
require_once('../Controller/User_Controller.php');
require_once('../Utility/Security.php');
Security::checkAuthority([2]);
if (isset($_POST['logout'])) { Security::logout(); }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GMAC Timekeeping System</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
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
        <h2 class="text-center">User Management</h2>
        <button class='btn btn-primary btn-center d-block mx-auto' name='log_report' value='View Log Report' 
            onclick='window.location.href="Log_Report.php"'>View Log Report</button>
        <p>
            <?php
            try{ 
                $users = UserController::getAllUsers();
                if ($users) {
                    echo '<table class="table table-striped"> 
                            <tr>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Access Level</th>
                            </tr>';
                foreach ($users as $user) {
                    $ID = htmlspecialchars($user->getID(), ENT_QUOTES);
                    $LastName = htmlspecialchars($user->getLastName(), ENT_QUOTES);
                    $FirstName = htmlspecialchars($user->getFirstName(), ENT_QUOTES);
                    $Email = htmlspecialchars($user->getEmail(), ENT_QUOTES);
                    $access = htmlspecialchars($user->getAccessName(), ENT_QUOTES);
                    echo '<tr>
                            <td><a href="Edit_User.php?ID=' . $ID . '">Edit</a></td>
                            <td><a href="Delete_User.php?ID=' . $ID . '">Delete</a></td>
                            <td>' . $LastName . '</td>
                            <td>' . $FirstName . '</td>
                            <td>' . $Email . '</td>
                            <td>' . $access . '</td>
                          </tr>';
                }
                echo '</table>';
                } else {
                    echo '<p class="error">No users could be retrieved.</p>'; 
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
            <?php include('../controller/user_buttons.php'); ?>
        </aside>
    </div>
    </body>
</html>