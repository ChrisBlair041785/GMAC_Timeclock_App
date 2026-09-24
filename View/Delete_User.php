<?php
session_start();
require_once('../Controller/User_Controller.php');
require_once('../Utility/Security.php');
Security::checkAuthority([2]);
if (isset($_POST['logout'])) { Security::logout(); }

$ID = filter_input(INPUT_GET, 'ID', FILTER_VALIDATE_INT);
if (!$ID) {
    $ID = filter_input(INPUT_POST, 'ID', FILTER_VALIDATE_INT);
}

$message = '';
$error = '';
$deleted = false;
$user = $ID ? UserController::getUserByID($ID) : null;

if (!$ID || !$user) {
    $error = 'This page has been accessed in error.';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (($_POST['sure'] ?? 'No') === 'Yes') {
        if (UserController::deleteUser($ID)) {
            $deleted = true;
            $message = 'The record has been deleted.';
        } else {
            $error = 'The record could not be deleted. It may no longer exist or a system error occurred.';
        }
    } else {
        $message = 'The user has NOT been deleted as you requested.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GMAC Timekeeping System</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php if ($deleted): ?>
        <meta http-equiv="refresh" content="5;url=UserManagement.php">
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
                    <h2 class="h2 text-center">Delete User</h2>
                    <?php if ($error): ?>
                        <p class="text-center text-danger">
                            <?php echo htmlspecialchars($error, ENT_QUOTES); ?>
                        </p>
                    <?php elseif ($deleted): ?>
                        <h3 class="text-center">The record has been deleted.</h3>
                        <p class="text-center">Returning to User Management in 5 seconds...</p>
                    <?php elseif ($message): ?>
                        <h3 class="text-center"> <?php echo htmlspecialchars($message, ENT_QUOTES); ?> </h3>
                        <p class="text-center">Returning to User Management in 5 seconds...</p>
                        <script>
                            setTimeout(function() {
                                window.location.href = "UserManagement.php";
                            }, 5000);
                        </script>
                    <?php else: ?>
                        <h2 class="h2 text-center">
                            Are you sure you want to permanently delete
                            <?php echo htmlspecialchars($user->getFirstName() . ' ' . $user->getLastName(), ENT_QUOTES); ?>?
                        </h2>
                        <form action="Delete_User.php" method="post" name="deleteform" id="deleteform">
                            <div class="form-group row">
                                <label for="sure" class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-8" style="padding-left: 70px;">
                                    <input type="hidden" name="ID" value="<?php echo $ID; ?>">
                                    <input id="submit-yes" class="btn btn-primary" type="submit" name="sure" value="Yes"> -
                                    <input id="submit-no" class="btn btn-primary" type="submit" name="sure" value="No">
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </body>
</html>