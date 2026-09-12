<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
require ('../model/database.php'); 

$errors = array(); 
$email = trim($_POST['Email']);
if (empty($email)) {
$errors[] = 'You forgot to enter your email address.';
}

$password = trim($_POST['Password']);
if (empty($password)) {
$errors[] = 'You forgot to enter your old password.';
}

$new_password = trim($_POST['Password1']);
$verify_password = trim($_POST['Password2']);
if (!empty($new_password)) {
    if (($new_password != $verify_password) || ( $password == $new_password )) {
        $errors[] = 'Your new password did not match the confirmed password and/or ';
        $errors[] = 'Your old password is the same as your new password.';
    }
} else {
    $errors[] = 'You did not enter a new password.';
} if (empty($errors)) {
try {
    $conn = get_db_conn();
    $query = "SELECT ID, password FROM users WHERE ( Email=? )";
    $q = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($q, $query);
    mysqli_stmt_bind_param($q, 's', $email);
    mysqli_stmt_execute($q);
    $result = mysqli_stmt_get_result($q);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if ((mysqli_num_rows($result) == 1) && (password_verify($password, $row['password']))) {
        $hashed_passcode = password_hash($new_password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET Password=? WHERE Email=?";
        $q = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($q, $query);
        mysqli_stmt_bind_param($q, 'ss', $hashed_passcode, $email);
        mysqli_stmt_execute($q);
        if (mysqli_stmt_affected_rows($q) == 1) {
            header ("location: ../view/Homepage.php");
            exit();
        } else { 
            $errorstring = "System Error! <br /> You could not change password due ";
            $errorstring .= "to a system error. We apologize for any inconvenience.</p>";
            echo "<p class='text-center col-sm-2' style='color:red'>$errorstring</p>";
            
            echo '<p>' . mysqli_error($conn) . '<br><br>Query: ' . $query . '</p>';
            exit();
        }
    } else {
    $errorstring = 'Error! <br /> ';
    $errorstring .= 'The email address and/or password do not match those on file.';
    $errorstring .= " Please try again.";
    echo "<p class='text-center col-sm-2' style='color:red'>$errorstring</p>";
    } }
    catch (Exception $e) {
        echo '<p class="text-center" style="color:red">An Exception occurred. Message: ' . $e->getMessage() . ' </p>';
        echo '<p class="text-center" style="color:red">The system is busy. Please try again later.</p>';
    } catch (Error $e) {
        echo '<p class="text-center" style="color:red">An Error occurred. Message: ' . $e->getMessage() . ' </p>';
        echo '<p class="text-center" style="color:red">The system is busy. Please try again later.</p>';
    } 
    } else { 
    $errorstring = "Error! The following error(s) occurred:<br>";
    foreach ($errors as $msg) { 
    $errorstring .= " - $msg<br>\n";
    }
    $errorstring .= "Please try again.<br>";
    echo "<p class=' text-center col-sm-2' style='color:red'>$errorstring</p>";
    }  
}
?>