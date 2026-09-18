<?php
try { 
    if ( (isset($_GET['ID'])) && (is_numeric($_GET['ID'])) ) {
        $ID = htmlspecialchars($_GET['ID'], ENT_QUOTES);
    } elseif ( (isset($_POST['ID'])) && (is_numeric($_POST['ID'])) ) {
        $ID = htmlspecialchars($_POST['ID'], ENT_QUOTES);
    } else {
        echo '<p class="text-center">This page has been accessed in error.</p>';
        exit();    
    }
    require('../Model/database.php');
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();

        $firstName = filter_var( $_POST['FirstName'], FILTER_SANITIZE_STRING);
        if (empty($firstName)) {
            $errors[] = 'First name is required.';
        }
        $lastName = filter_var( $_POST['LastName'], FILTER_SANITIZE_STRING);
        if (empty($lastName)) {
            $errors[] = 'Last name is required.';
        }
        $email = filter_var( $_POST['Email'], FILTER_SANITIZE_EMAIL);
        if ((empty($email)) || (!filter_var($email, FILTER_VALIDATE_EMAIL))) {
            $errors[] = 'Email is required or the format is invalid.';
        }
        $access = filter_var( $_POST['Access'], FILTER_SANITIZE_STRING);
        if (empty($access)) {
            $errors[] = 'Access level is required.';
        }
        if (empty($errors)) {
            $conn = get_db_conn();
            $q = mysqli_stmt_init($conn);
            $query = "SELECT ID FROM users WHERE email=? AND ID !=?";
            if (!mysqli_stmt_prepare($q, $query)) {
                throw new Exception(mysqli_error($conn));
            }
            mysqli_stmt_bind_param($q, "si", $email, $ID);
            mysqli_stmt_execute($q);
            $results = mysqli_stmt_get_result($q);
            if (mysqli_num_rows($results) == 0) {
                $query = "UPDATE users SET FirstName=?, LastName=?, Email=?, access=? WHERE ID=? LIMIT 1";
                $q = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($q, $query)) {
                    throw new Exception(mysqli_error($conn));
                }
                mysqli_stmt_bind_param($q, "sssii", $firstName, $lastName, $email, $access, $ID);
                mysqli_stmt_execute($q);
                if (mysqli_stmt_affected_rows($q) == 1) {
                    echo '<h3 class="text-center">The user has been edited successfully.</h3>';    
                } else {
                    echo '<p class="text-center">The user could not be edited due to a system error.</p>';
                    echo ' We apologize for the inconvenience.</p>';
                    echo '<p>' . mysqli_error($conn) . '<br/>Query: ' . $q . '</p>';
                }
            } else {
                echo '<p class="text-center">The email address is already in use by another user.</p>';
            }    
        } else {
            echo '<p class="text-center">The following error(s) occurred:<br />';
            foreach ($errors as $msg) {
                echo " - $msg<br />\n";
            }
            echo '</p><p>Please try again.</p>';
        }
    }
    $conn = get_db_conn();
    $q = mysqli_stmt_init($conn);
    $query = "SELECT FirstName, LastName, Email, access FROM users WHERE ID=?";
    mysqli_stmt_prepare($q, $query);
    mysqli_stmt_bind_param($q, "i", $ID);
    mysqli_stmt_execute($q);
    $results = mysqli_stmt_get_result($q);
    $row = mysqli_fetch_array($results, MYSQLI_NUM);

    if (mysqli_num_rows($results) == 1) {
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
                <h2 class="h2 text-center">Edit Record</h2>
                <form action="edit_record.php" method="post" name="editform" id="editform">
                <div class="form-group-row">
                    <label for="FirstName" class="col-sm-4 col-form-label">First Name:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="FirstName" name="FirstName" 
                            placeholder="First Name" maxlength="30" required 
                            value="<?php echo htmlspecialchars($row[0], ENT_QUOTES); ?>">
                    </div>
                </div>
                <div class="form-group-row">
                    <label for="LastName" class="col-sm-4 col-form-label">Last Name:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="LastName" name="LastName" 
                            placeholder="Last Name" maxlength="30" required 
                            value="<?php echo htmlspecialchars($row[1], ENT_QUOTES); ?>">
                    </div>
                </div>
                <div class="form-group-row">
                    <label for="Email" class="col-sm-4 col-form-label">Email:</label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control" id="Email" name="Email" 
                            placeholder="Email" maxlength="60" required 
                            value="<?php echo htmlspecialchars($row[2], ENT_QUOTES); ?>">
                    </div>
                </div>
                <div class="form-group-row">
                    <label for="Access" class="col-sm-4 col-form-label">Access Level:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="Access" name="Access" 
                            placeholder="Access Level" maxlength="60" required 
                            value="<?php echo htmlspecialchars($row[3], ENT_QUOTES); ?>">
                    </div>
                </div>
                <input type="hidden" name="ID" value="<?php echo $ID; ?>">
                <div class="form-group-row">
                    <div class="col-sm-8">
                        <input id="submit" class="btn btn-primary" type="submit" name="submit" value="Save Changes">
                    </div>
                </div>
                </form>
            </div>
        </div> 
    </body> 

<?php
    } else {
        echo '<p class="text-center" style="color:red">This page has been accessed in error.</p>';
    } 
    mysqli_stmt_free_result($q);
    mysqli_stmt_close($q);

    } catch (Exception $e) {
        echo '<p class="text-center" style="color:red">An Exception occurred. Message: ' . $e->getMessage() . ' </p>';
        echo '<p class="text-center" style="color:red">The system is busy. Please try again later.</p>';
    } catch (Error $e) {
        echo '<p class="text-center" style="color:red">An Error occurred. Message: ' . $e->getMessage() . ' </p>';
        echo '<p class="text-center" style="color:red">The system is busy. Please try again later.</p>';
    }
?>