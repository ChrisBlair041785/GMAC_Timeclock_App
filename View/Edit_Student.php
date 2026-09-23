<?php
session_start();
require_once('../Controller/Student_Controller.php');
require_once('../Utility/Security.php');
Security::checkAuthority([2]);
if (isset($_POST['logout'])) { Security::logout(); }

$ID = filter_input(INPUT_GET, 'ID', FILTER_VALIDATE_INT);
if (!$ID) {
    $ID = filter_input(INPUT_POST, 'ID', FILTER_VALIDATE_INT);
}

$errors = [];
$success = false;
if ($ID && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = StudentController::updateStudent(
        $ID,
        $_POST['FirstName'] ?? '',
        $_POST['LastName'] ?? '',
        $_POST['School'] ?? ''
    );
    $success = empty($errors);
}

$student = $ID ? StudentController::getStudentByID($ID) : null;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GMAC Timekeeping System</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <?php if ($success): ?>
        <meta http-equiv="refresh" content="5;url=StudentManagement.php">
        <?php endif; ?>
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
                    <h2 class="h2 text-center">Edit Student Record</h2>
                    <?php if (!$ID || !$student): ?>
                        <p class="text-center text-danger">This page has been accessed in error.</p>
                    <?php else: ?>
                        <?php if ($success): ?>
                            <h3 class="text-center">The student has been edited successfully.</h3>
                            <p class="text-center">Returning to Student Management in 5 seconds...</p>
                        <?php elseif ($errors): ?>
                            <p class="text-center text-danger">
                                The following error(s) occurred:<br>
                                <?php echo htmlspecialchars(implode(' ', $errors), ENT_QUOTES); ?><br>
                                Please try again.
                            </p>
                        <?php endif; ?>
                        <form action="Edit_Student.php" method="post" name="editform" id="editform">
                            <div class="form-group-row">
                                <label for="LastName" class="col-sm-4 col-form-label">Last Name:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="LastName" name="LastName"
                                        placeholder="Last Name" maxlength="30" required
                                        value="<?php echo htmlspecialchars($student->getLastName(), ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                            </div>
                            <div class="form-group-row">
                                <label for="FirstName" class="col-sm-4 col-form-label">First Name:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="FirstName" name="FirstName"
                                        placeholder="First Name" maxlength="30" required
                                        value="<?php echo htmlspecialchars($student->getFirstName(), ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                            </div>
                            <div class="form-group-row">
                                <label for="School" class="col-sm-4 col-form-label">School:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="School" name="School"
                                        placeholder="School" maxlength="30" required
                                        value="<?php echo htmlspecialchars($student->getSchool(), ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                            </div>
                            <input type="hidden" name="ID" value="<?php echo $ID; ?>">
                            <div class="form-group-row">
                                <div class="col-sm-8">
                                    <input id="submit" class="btn btn-primary" type="submit" name="submit" value="Save Changes">
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </body>
</html>
