<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GMAC Timekeeping System</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" shrink-to-fit="no">
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
                    require '../controller/Login_Controller.php';
                }
                ?>
                <div class="col-sm-8">
                    <h2 class="h2 text-center">Login</h2>
                    <form action="../controller/Login_Controller.php" method="post" name="loginform" id="loginform">
                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label">Email Addres:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="email" name="email" 
                                placeholder="Email" maxLength="30"required
                                value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-4 col-form-label">Password:</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="password" name="password" 
                                placeholder="Password" maxLength="30" required 
                                value="<?php if (isset($_POST['password'])) echo $_POST['password'];?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input id="submit" class="btn btn-primary" type="submit" name="submit" value="Login">
                            </div>
                        </div>
                    </form>
                </div>
                <aside class="col-sm-2">
                    <?php include('../Controller/User_Buttons.php'); ?>
                </aside>
            </div>
        </div>
    </body>
</html>