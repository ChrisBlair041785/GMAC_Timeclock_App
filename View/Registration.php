<?php
require_once('../Controller/User_Controller.php');

$firstName = $_POST['FirstName'] ?? '';
$lastName = $_POST['LastName'] ?? '';
$email = $_POST['Email'] ?? '';
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = UserController::registerUser(
        $firstName,
        $lastName,
        $email,
        $_POST['Password1'] ?? '',
        $_POST['Password2'] ?? ''
    );
    $success = empty($errors);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GMAC Timekeeping System</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" shrink-to-fit="no">
        <?php if ($success): ?>
        <meta http-equiv="refresh" content="5;url=Homepage.php">
        <?php endif; ?>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4"
        crossorigin="anonymous">
        <script>
            function checked() {
                const password1 = document.getElementById('password1').value;
                const password2 = document.getElementById('password2').value;
                const message = document.getElementById('message');
                if (password1 === password2) {
                    message.style.color = 'green';
                    message.textContent = 'Passwords match';
                    return true;
                }
                message.style.color = 'red';
                message.textContent = 'Passwords do not match';
                return false;
            }
        </script>
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
            <h2 class="text-center">Login Registration</h2>
            <?php if ($success): ?>
                <div class="alert alert-success" role="alert">
                    Registration completed successfully. Returning to the homepage in 5 seconds...
                </div>
            <?php elseif ($errors): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars(implode(' ', $errors), ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>
            <form action="registration.php" method="POST" onsubmit="return checked();">
            <div class="form-group row">
                <label for="FirstName" class="col-sm-4 col-form-label">First Name:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="FirstName" name="FirstName" 
                        placeholder="First Name" maxlength="25" required 
                        value="<?php echo htmlspecialchars($firstName, ENT_QUOTES, 'UTF-8'); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="LastName" class="col-sm-4 col-form-label">Last Name:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="LastName" name="LastName" 
                        placeholder="Last Name" maxlength="30" required 
                        value="<?php echo htmlspecialchars($lastName, ENT_QUOTES, 'UTF-8'); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="Email" class="col-sm-4 col-form-label">Email:</label>
                <div class="col-sm-8">
                    <input type="email" class="form-control" id="Email" name="Email" 
                        placeholder="Email" maxlength="50" required 
                        value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="Password1" class="col-sm-4 col-form-label">Password:</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" id="password1" name="Password1" 
                        placeholder="Password" minlength="8" maxlength="16" required 
                        >
                        <span id="message">Between 8 and 16 characters</span>
                </div>
            </div>
            <div class="form-group row">
                <label for="Password2" class="col-sm-4 col-form-label">Confirm Password:</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" id="password2" name="Password2" 
                        placeholder="Confirm Password" minlength="8" maxlength="16" required 
                        >
                        <span id="message">Between 8 and 16 characters</span>
                </div>
            </div>     
            <div class="form-group row">
                <div class="col-sm-12">
                    <input id="submit" class="btn btn-primary" type="submit" name="submit" value="Register">
                </div>
            </div>
            </form>
        <aside class="col-sm-2">
            <?php include('../controller/user_buttons.php'); ?>
        </aside>
    </div>
    </body>
</html>