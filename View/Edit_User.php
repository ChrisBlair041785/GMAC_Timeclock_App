<?php
session_start();
require_once('../Controller/User_Controller.php');
require_once('../Utility/Security.php');
Security::checkAuthority('2');
if (isset($_POST['logout'])) { Security::logout(); }

// Get the user ID from GET or POST request
$ID = filter_input(INPUT_GET, 'ID', FILTER_VALIDATE_INT);
if (!$ID) { $ID = filter_input(INPUT_POST, 'ID', FILTER_VALIDATE_INT); }

$errors = [];
$success = false;

// Handle form submission for editing a user record
if ($ID && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = UserController::updateUserDetails(
        $ID,
        $_POST['FirstName'] ?? '',
        $_POST['LastName'] ?? '',
        $_POST['Email'] ?? '',
        $_POST['Access'] ?? ''
    );
    $success = empty($errors);
}

// Retrieve the user record for display in the form
$user = $ID ? UserController::getUserByID($ID) : null;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GMAC Timekeeping System</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php if ($success): ?>
        <meta http-equiv="refresh" content="3;url=UserManagement.php">
        <?php endif; ?>
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
                <h2 class="h2 text-center">Edit Record</h2>
                <?php if (!$ID || !$user): ?>
                    <p class="text-center text-danger">This page has been accessed in error.</p>
                <?php else: ?>
                    <?php if ($success): ?>
                        <h3 class="text-center">The user has been edited successfully.</h3>
                        <p class="text-center">Returning to User Management...</p>
                    <?php elseif ($errors): ?>
                        <p class="text-center text-danger">
                            The following error(s) occurred:<br>
                            <?php echo htmlspecialchars(implode(' ', $errors), ENT_QUOTES); ?><br>
                            Please try again.
                        </p>
                    <?php endif; ?>
                <form action="edit_user.php" method="post" name="editform" id="editform">
                <div class="form-group row">
                    <label for="FirstName" class="col-sm-4 col-form-label">First Name:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="FirstName" name="FirstName" 
                            placeholder="First Name" maxlength="30" required 
                            value="<?php echo htmlspecialchars($user->getFirstName(), ENT_QUOTES); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="LastName" class="col-sm-4 col-form-label">Last Name:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="LastName" name="LastName" 
                            placeholder="Last Name" maxlength="30" required 
                            value="<?php echo htmlspecialchars($user->getLastName(), ENT_QUOTES); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Email" class="col-sm-4 col-form-label">Email:</label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control" id="Email" name="Email" 
                            placeholder="Email" maxlength="60" required 
                            value="<?php echo htmlspecialchars($user->getEmail(), ENT_QUOTES); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Access" class="col-sm-4 col-form-label">Access Level:</label>
                    <div class="col-sm-8">
                        <?php $currentAccess = (string) $user->getAccess(); ?>
                        <select class="form-control" id="Access" name="Access" required>
                            <option value="0" <?php echo $currentAccess === '0' ? 'selected' : ''; ?>>New User</option>
                            <option value="1" <?php echo $currentAccess === '1' ? 'selected' : ''; ?>>User</option>
                            <option value="2" <?php echo $currentAccess === '2' ? 'selected' : ''; ?>>Administrator</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="ID" value="<?php echo $ID; ?>">
                <div class="form-group row">
                    <div class="col-sm-8">
                        <input id="submit" class="btn btn-primary" type="submit" name="submit" value="Save Changes">
                        <input type="button" class="btn btn-secondary" value="Cancel" onclick="window.location.href='UserManagement.php';">
                    </div>
                </div>
                </form>
                <?php endif; ?>
            </div>
        </div> 
    </body> 

