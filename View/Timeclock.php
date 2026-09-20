<?php
session_start();
if (!isset($_SESSION['access']) or ($_SESSION['access'] <= 0)) { 
    header("Location: ../View/Login.php");
    exit();
}
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
        <p class="text-center">Please use the buttons below to clock in or out the studentsfor the day.</p>
        <?php
        require('../Model/database.php');
                $conn = get_db_conn();
                  $query = "SELECT s.StudID, s.LastName, s.FirstName, s.School,
                                   CASE
                                       WHEN MAX(t.Arrived) IS NOT NULL
                                            AND (MAX(t.Departed) IS NULL OR MAX(t.Arrived) > MAX(t.Departed))
                                       THEN MAX(t.Arrived)
                                       ELSE NULL
                                   END AS Arrived,
                                   CASE
                                       WHEN MAX(t.Departed) IS NOT NULL
                                            AND (MAX(t.Arrived) IS NULL OR MAX(t.Departed) > MAX(t.Arrived))
                                       THEN MAX(t.Departed)
                                       ELSE NULL
                                   END AS Departed
                            FROM Students s
                            LEFT JOIN timeclock t ON t.StudID = s.StudID
                            GROUP BY s.StudID, s.LastName, s.FirstName, s.School
                            ORDER BY s.LastName ASC";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    echo '<table class="table table-striped"> 
                            <tr>
                                <th scope="col">Student ID</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">First Name</th>
                                <th scope="col">School</th>
                                <th scope="col">Clock In/Out</th>
                            </tr>';
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $ID = htmlspecialchars($row['StudID'], ENT_QUOTES);
                    $LastName = htmlspecialchars($row['LastName'], ENT_QUOTES);
                    $FirstName = htmlspecialchars($row['FirstName'], ENT_QUOTES);
                    $School = htmlspecialchars($row['School'], ENT_QUOTES);
                    $arrived = $row['Arrived'];
                    $departed = $row['Departed'];
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
                mysqli_free_result($result);
                } else {
                    echo '<p class"error">The current users could not be retrieved. We apologize for any inconvenience.</p>'; 
                    echo '<p>' . mysqli_error($conn) . '<br><br>Query: ' . $query . '</p>';
                    exit();
                }
                mysqli_close($conn); 
                ?>
        </div>
        <aside class="col-sm-2">
            <?php include('../Controller/User_Buttons.php'); ?>
        </aside>
    </div>
    </body>
</html>