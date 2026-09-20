<?php
session_start();
if (!isset($_SESSION['access']) or ($_SESSION['access'] != 2)) { 
    header("Location: ../View/Login.php");
    exit();
}
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
        <h2 class="text-center">Time Reports</h2>
        <p class="text-center">Please select a report to view the time records for the students.</p>
        <?php
        require('../Model/database.php');   
        $report = $_GET['report'] ?? '';
        $reportLabels = [
            'daily' => 'Daily Report',
            'weekly' => 'Weekly Report',
            'monthly' => 'Monthly Report'
        ];
        ?>
        <form method="get" action="TimeReports.php" class="text-center mb-3">
            <button type="submit" name="report" value="daily" class="btn btn-primary">Daily Report</button>
            <button type="submit" name="report" value="weekly" class="btn btn-primary">Weekly Report</button>
            <button type="submit" name="report" value="monthly" class="btn btn-primary">Monthly Report</button>
        </form>
        <?php if (isset($reportLabels[$report])): ?>
            <?php
            $reportDateFilter = [
                'daily' => 'DATE(COALESCE(t.Arrived, t.Departed)) = CURDATE()',
                'weekly' => 'YEARWEEK(COALESCE(t.Arrived, t.Departed), 1) = YEARWEEK(CURDATE(), 1)',
                'monthly' => 'MONTH(COALESCE(t.Arrived, t.Departed)) = MONTH(CURDATE())
                                AND YEAR(COALESCE(t.Arrived, t.Departed)) = YEAR(CURDATE())'
            ][$report];
            $conn = get_db_conn();
                    $reportQuery = "SELECT s.StudID, s.LastName, s.FirstName, s.School,
                    t.Arrived AS CheckIn, t.Departed AS CheckOut FROM Students s 
                    INNER JOIN timeclock t ON t.StudID = s.StudID WHERE $reportDateFilter 
                    ORDER BY s.LastName ASC, COALESCE(t.Arrived, t.Departed) ASC";
                $reportResult = mysqli_query($conn, $reportQuery);
            ?>
            <h3 class="text-center"><?php echo $reportLabels[$report]; ?></h3>
            <?php if ($reportResult && mysqli_num_rows($reportResult) > 0): ?>
                <table class="table table-bordered table-sm">
                    <tr>
                        <th>Student</th>
                        <th>School</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                    </tr>
                    <?php while ($reportRow = mysqli_fetch_assoc($reportResult)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($reportRow['LastName'] . ', ' . $reportRow['FirstName'], ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars($reportRow['School'], ENT_QUOTES); ?></td>
                            <td><?php echo $reportRow['CheckIn'] ? date('m/d/Y h:i A', strtotime($reportRow['CheckIn'])) : ''; ?></td>
                            <td><?php echo $reportRow['CheckOut'] ? date('m/d/Y h:i A', strtotime($reportRow['CheckOut'])) : ''; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p class="text-center">No time records found for this period.</p>
            <?php endif; ?>
            <?php mysqli_close($conn); ?>
        <?php endif; ?>
        </div>
        <aside class="col-sm-2">
            <?php include('../controller/user_buttons.php'); ?>
        </aside>
    </div>
    </body>
</html>