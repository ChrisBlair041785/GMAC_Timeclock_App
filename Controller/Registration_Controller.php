<?php
try{
    $errors = array();

    $FirstName = filter_var($_POST['FirstName'], FILTER_SANITIZE_STRING);
    if (empty($FirstName)) { $errors[] = 'First name is required'; }

    $LastName = filter_var($_POST['LastName'], FILTER_SANITIZE_STRING);
    if (empty($LastName)) { $errors[] = 'Last name is required'; }

    $Email = filter_var($_POST['Email'], FILTER_SANITIZE_STRING );
    if ((empty($Email)) || (!filter_var($Email, FILTER_VALIDATE_EMAIL))) {
        $errors[] = 'Email is required'; 
        $errors[] = 'Invalid email format';
    }

    $Password1 = filter_var($_POST['Password1'], FILTER_SANITIZE_STRING);
    $Password2 = filter_var($_POST['Password2'], FILTER_SANITIZE_STRING);
    if (!empty($Password1)) {
        if ($Password1 !== $Password2) {
            $errors[] = 'Passwords do not match';
        }
    } else {
        $errors[] = 'You must enter a password';
    }

    if (empty($errors)) {
        $hashed_passcode = password_hash($Password1, PASSWORD_DEFAULT);
        require '../Model/database.php';

        $query = 'INSERT INTO users ( LastName, FirstName, Email, Password) VALUES (?, ?, ?, ?)';
        $conn = get_db_conn();
        $q = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($q, $query);
        mysqli_stmt_bind_param($q, 'ssss', $LastName, $FirstName, $Email, $hashed_passcode);
        mysqli_stmt_execute($q);

        if (mysqli_stmt_affected_rows($q) === 1) {
            header('Location: Homepage.php');
            exit();
        } else { 
            $errorstring = "<p class='text-center col-sm-8' style='color:red'>";
            $errorstring .= "System Error<br />You could not be registered due ";
            $errorstring .= "to a system error. We apologize for the inconvenience.</p>";
            echo "<p class='text-center col-sm-2' style='color:red'>$errorstring</p>";
            echo "<p>" . mysqli_error(get_db_conn()) . "<br><br>Query: " . $query . "</p>";
                            mysqli_close(get_db_conn());
        }
    }
} catch (Exception $e) {
    echo '<p class="text-center" style="color:red">An Exception occurred. Message: ' . $e->getMessage() . ' </p>';
    echo '<p class="text-center" style="color:red">The system is busy. Please try again later.</p>';
} catch (Error $e) {
    echo '<p class="text-center" style="color:red">An Error occurred. Message: ' . $e->getMessage() . ' </p>';
    echo '<p class="text-center" style="color:red">The system is busy. Please try again later.</p>';
}
?>
