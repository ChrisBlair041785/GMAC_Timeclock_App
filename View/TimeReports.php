<?php
session_start();
require_once('../Controller/Reports_Controller.php');
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
        <h2 class="text-center">Time Reports</h2>
        <p class="text-center">Please select a report to view the time records for the students.</p>
        <?php
        $report = $_GET['report'] ?? '';
        $reportLabels = [
            'daily' => 'Daily Report',
            'weekly' => 'Weekly Report',
            'monthly' => 'Monthly Report',
            'specific_date' => 'Specific Date',
            'student' => 'Student Report',
            'date_range' => 'Date Range Report'
        ];
        $reportDate = $_GET['report_date'] ?? '';
        $studentLastName = $_GET['studentLastName'] ?? '';
        $startDate = $_GET['start_date'] ?? '';
        $endDate = $_GET['end_date'] ?? '';
        $reportRows = [];
        $reportError = '';
        if (isset($reportLabels[$report])) {
            try {
                $filterValue = null;
                $startDate = $_GET['start_date'] ?? '';
                $endDate = $_GET['end_date'] ?? '';
                if ($report === 'specific_date') {
                    $filterValue = $reportDate;
                } elseif ($report === 'date_range') {
                    $filterValue = [$startDate, $endDate];
                } elseif ($report === 'student') {
                    $filterValue = $studentLastName;
                }
                $reportRows = ReportsController::getTimeReport($report, $filterValue);
            } catch (Exception $e) {
                $reportError = $e instanceof InvalidArgumentException
                    ? $e->getMessage()
                    : 'The requested time report could not be retrieved.';
            }
        }
        ?>
        <form method="get" action="TimeReports.php" class="text-center mb-3">
            <button type="submit" name="report" value="daily" class="btn btn-primary">Daily Report</button>
            <button type="submit" name="report" value="weekly" class="btn btn-primary">Weekly Report</button>
            <button type="submit" name="report" value="monthly" class="btn btn-primary">Monthly Report</button>
        </form>
        <form method="get" action="TimeReports.php" class="text-center mb-3">
            <input type="hidden" name="report" value="specific_date">
            <label for="report_date">Specific Date:</label>
            <input type="date" id="report_date" name="report_date"
                value="<?php echo htmlspecialchars($reportDate, ENT_QUOTES); ?>" required>
            <button type="submit" class="btn btn-primary">Specific Date</button>
        </form>
        <form method="get" action="TimeReports.php" class="text-center mb-3">
            <input type="hidden" name="report" value="date_range">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date"
                value="<?php echo htmlspecialchars($startDate, ENT_QUOTES); ?>" required>
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date"
                value="<?php echo htmlspecialchars($endDate, ENT_QUOTES); ?>" required>
            <button type="submit" class="btn btn-primary">Date Range Report</button>
        </form>
        <form method="get" action="TimeReports.php" class="text-center mb-3">
            <input type="hidden" name="report" value="student" >
            <label for="studentLastName">Last Name:</label>
            <input type="text" id="studentLastName" name="studentLastName" placeholder="Students Last Name"
                value="<?php echo htmlspecialchars($studentLastName, ENT_QUOTES); ?>" required>
            <button type="submit" class="btn btn-primary">Student Report</button>
        </form>
        <?php if (isset($reportLabels[$report])): ?>
            <h3 class="text-center"><?php echo $reportLabels[$report]; ?></h3>
            <?php if ($reportError): ?>
                <p class="text-center text-danger"><?php echo $reportError; ?></p>
            <?php elseif ($reportRows): ?>
                <table class="table table-bordered table-sm">
                    <tr>
                        <th>Student</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                    </tr>
                    <?php foreach ($reportRows as $reportRow): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($reportRow['LastName'] . ', ' . $reportRow['FirstName'], ENT_QUOTES); ?></td>
                            <td><?php echo $reportRow['CheckIn'] ? date('m/d/Y h:i A', strtotime($reportRow['CheckIn'])) : ''; ?></td>
                            <td><?php echo $reportRow['CheckOut'] ? date('m/d/Y h:i A', strtotime($reportRow['CheckOut'])) : ''; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p class="text-center">No time records found for this period.</p>
            <?php endif; ?>
        <?php endif; ?>
        </div>
        <aside class="col-sm-2">
            <?php include('../controller/user_buttons.php'); ?>
        </aside>
    </div>
    </body>
</html>