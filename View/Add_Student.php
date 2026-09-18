<?php
session_start();
if (!isset($_SESSION['access']) or ($_SESSION['access'] != 2)) { 
    header("Location: ../View/Login.php");
    exit();
}
require_once('../Controller/Student_Controller.php');
require_once('../Model/database.php');
require_once('../Model/Student_info.php');
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
            <h2 class="text-center">Student Registration</h2>
            <?php if ($addMessage !== ""): ?>
                <div class="alert <?php echo $addMessageClass; ?>" role="alert">
                    <?php echo htmlspecialchars($addMessage, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>
            <form action="Add_Student.php" method="POST">
            <div class="form-group row">
                <label for="LastName" class="col-sm-4 col-form-label">Last Name:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="LastName" name="LastName" 
                        placeholder="Last Name" maxlength="30" required 
                        value="<?php if (isset($_POST['LastName'])) echo $_POST['LastName']; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="FirstName" class="col-sm-4 col-form-label">First Name:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="FirstName" name="FirstName" 
                        placeholder="First Name" maxlength="25" required 
                        value="<?php if (isset($_POST['FirstName'])) echo $_POST['FirstName']; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="School" class="col-sm-4 col-form-label">School:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="School" name="School" 
                        placeholder="School" maxlength="50" required 
                        value="<?php if (isset($_POST['School'])) echo $_POST['School']; ?>">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    <input id="submit" class="btn btn-primary" type="submit" name="submit" value="Submit">
                </div>
            </div>
            </form>
        <aside class="col-sm-2">
            <?php include('../controller/user_buttons.php'); ?>
        </aside>
    </div>
    </body>
</html>