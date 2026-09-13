<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        require ("../model/database.php");
        $email = filter_var ($_POST['email'], FILTER_SANITIZE_EMAIL);
        if ((empty($email)) || (!filter_var($email, FILTER_VALIDATE_EMAIL))) {
            $errors[] = "You must enter a valid email address";
            $errors[] = "or the email format is incorrect.";
        }
        $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        if (empty($password)) {
            $errors[] = "You must enter a password.";
        }
        if (empty($errors)) {
            $query = "SELECT ID, Password, FirstName, access FROM users WHERE Email = ?";
            $conn = get_db_conn();
            $q = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($q, $query);
            mysqli_stmt_bind_param($q, "s", $email);
            mysqli_stmt_execute($q);
            $results = mysqli_stmt_get_result($q);
            $row = mysqli_fetch_array($results, MYSQLI_NUM);
            if (mysqli_num_rows($results) == 1) {
                if (password_verify($password, $row[1])) {
                    session_start();
                    $_SESSION['access'] = (int) $row[3];
                    $url = ($_SESSION['access'] === 2) ? '../View/UserManagement.php' : '../View/Homepage.php';
                    header('Location: ' . $url);
                } else {
                    $errors[] = 'Email/Password entered does not match our records. ';
                    $errors[] = 'Perhaps you need to register first, Just click on the register link, ';
                    $errors[] = 'or please try again.';
                }
            } 
            if (!empty($errors)) {
                $errorstring="Error! <br /> The following errors occurred:<br />";
                foreach ($errors as $msg) {
                    $errorstring .= " $msg<br>\n";
                }
                $errorstring .= "Please try again.<br>";
                echo "<p class=' text-center col-sm-2' style='color:red;'>$errorstring</p>";
            }
            mysqli_stmt_free_result($q);
            mysqli_stmt_close($q);
        }
    }
    catch (Exception $e) {
    echo '<p class="text-center" style="color:red">An Exception occurred. Message: ' . $e->getMessage() . ' </p>';
    echo '<p class="text-center" style="color:red">The system is busy. Please try again later.</p>';
    } 
    catch (Error $e) {
    echo '<p class="text-center" style="color:red">An Error occurred. Message: ' . $e->getMessage() . ' </p>';
    echo '<p class="text-center" style="color:red">The system is busy. Please try again later.</p>';
    }
}
?>
