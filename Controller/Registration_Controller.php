<?php
$errors = array();

$FirstName = trim($_POST['FirstName'] ?? '');
if (empty($FirstName)) {
    $errors[] = 'First name is required';
}

$LastName = trim($_POST['LastName'] ?? '');
if (empty($LastName)) {
    $errors[] = 'Last name is required';
}

$Email = trim($_POST['Email'] ?? '');
if (empty($Email)) {
    $errors[] = 'Email is required';
}

$Password1 = trim($_POST['Password1'] ?? '');
$Password2 = trim($_POST['Password2'] ?? '');
if (empty($Password1)) {
    $errors[] = 'You must enter a password';
} elseif ($Password1 !== $Password2) {
    $errors[] = 'Passwords do not match';
}

if (empty($errors)) {
    try {
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
    catch (Exception $e) {
        echo '<p class="text-center" style="color:red">An Exception occurred. Message: ' . $e->getMessage() . ' </p>';
        echo '<p class="text-center" style="color:red">The system is busy. Please try again later.</p>';
    } catch (Error $e) {
        echo '<p class="text-center" style="color:red">An Error occurred. Message: ' . $e->getMessage() . ' </p>';
        echo '<p class="text-center" style="color:red">The system is busy. Please try again later.</p>';
    }
} else {
    echo '<p class="text-center" style="color:red">';
    echo 'Error! ' . implode('<br>', $errors);
    echo '</p>';
}
?>
