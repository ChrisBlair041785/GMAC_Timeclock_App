<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GMAC Timekeeping System</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4"
        crossorigin="anonymous">
        <script src="../controller/verify.js"></script>
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
       <?php 
       if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require('../controller/change_password.php');
       }
       ?>
       <div class="col-sm-8">
        <h2 class="text-center">Change Password</h2>
            <form action="../controller/change_password.php" method="post" name="regform"
                id="regform" onsubmit="return checked();">
                <div class="form-group row">
                    <label for="Email" class="col-sm-4 col-form-label">Email:</label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control" id="Email" name="Email" 
                        placeholder="Email" maxlength="50" required
                        value="<?php if (isset($_POST['Email'])) echo $_POST['Email']; ?>" >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Password" class="col-sm-4 col-form-label">Current Password:</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="Password" name="Password" 
                        placeholder="Password" minlength="8" maxlength="12"
                        required value="<?php if (isset($_POST['Password'])) echo $_POST['Password']; ?>" >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Password1" class="col-sm-4 col-form-label">New Password:</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="Password1" name="Password1" 
                        placeholder="Password" minlength="8" maxlength="12" 
                        required value="<?php if (isset($_POST['Password1'])) echo $_POST['Password1']; ?>" >
                        <span id="message">Between 8 and 12 characters.</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Password2" class="col-sm-4 col-form-label">Confirm Password:</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="Password2" name="Password2" 
                        placeholder="Password" minlength="8" maxlength="12"
                        required value="<?php if (isset($_POST['Password2'])) echo $_POST['Password2']; ?>" >
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <input id="submit" class="btn btn-primary" type="submit" name="submit" value="Change Password">
                    </div>
                </div>
            </form>
        </div>
        <aside class="col-sm-2">
            <?php include('../controller/user_buttons.php'); ?>
        </aside>
    </div>
    </body>
</html>