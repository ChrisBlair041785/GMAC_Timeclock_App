<?php
session_start();
require_once('../Controller/AuthLog_Controller.php');
require_once('../Utility/Security.php');
Security::checkAuthority([2]);
if (isset($_POST['logout'])) { Security::logout(); }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GMAC Timekeeping System - Log Report</title>
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
                    <h2 class="text-center">Log Report</h2>
                    <p>
                        <?php
                        try {
                            $logs = AuthLogController::getAllLogs();
                            if ($logs) {
                                echo '<table class="table table-striped"> 
                                        <tr>
                                            <th scope="col">Event Type</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Access Level</th>
                                            <th scope="col">Timestamp</th>
                                        </tr>';
                                foreach ($logs as $log) {
                                    $EventType = htmlspecialchars($log['EventType'], ENT_QUOTES);
                                    $Email = htmlspecialchars($log['Email'], ENT_QUOTES);
                                    $AccessLevel = htmlspecialchars($log['AccessLevel'], ENT_QUOTES);
                                    $Timestamp = htmlspecialchars($log['CreatedAt'], ENT_QUOTES);
                                    echo '<tr>
                                            <td>' . $EventType . '</td>
                                            <td>' . $Email . '</td>
                                            <td>' . $AccessLevel . '</td>
                                            <td>' . $Timestamp . '</td>
                                        </tr>';
                                }
                                echo '</table>';
                            } else {
                                echo 'No logs found.';
                            }
                        } catch (Exception $e) {
                            echo 'Error: ' . $e->getMessage();
                        }
                        ?>
                    </p>
                </div>
                <aside class="col-sm-2">
                    <?php include('../Controller/User_Buttons.php'); ?>
                </aside>
            </div>
        </div>
    </body>
</html>