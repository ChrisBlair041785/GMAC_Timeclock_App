<?php
require_once __DIR__ . "/../Model/User_db.php";
require_once __DIR__ . "/../Model/User.php";

class UserController {
    // Handles operations related to user management, including retrieval, addition, update, and deletion of users
    // Converts a database row into a User object
    private static function rowToUser($row) {
        $user = new User($row['FirstName'], $row['LastName'],
            $row['Email'], $row['Password'], $row['access'], $row['ID'], $row['access_name']);
        return $user;
    }
    // Retrieves all users from the database
    public static function getAllUsers() {
        $userDb = new User_DB();
        $results = $userDb->All_Users();
        $users = [];
        if ($results instanceof mysqli_result) {
            while ($row = mysqli_fetch_assoc($results)) {
                $users[] = self::rowToUser($row);
            }
            mysqli_free_result($results);
        }
        return $users;
    }

    // Retrieves a user from the database by their ID
    public static function getUserByID($ID) {
        $userDb = new User_DB();
        $row = $userDb->Get_User_By_ID($ID);
        if ($row) {
            return self::rowToUser($row);
        }
        return null;
    }
    // Updates the details of an existing user in the database
    public static function updateUserDetails($ID, $FirstName, $LastName, $Email, $access) {
        $errors = [];
        $FirstName = trim(filter_var($FirstName, FILTER_SANITIZE_STRING));
        $LastName = trim(filter_var($LastName, FILTER_SANITIZE_STRING));
        $Email = trim(filter_var($Email, FILTER_SANITIZE_EMAIL));
        $access = filter_var($access, FILTER_VALIDATE_INT);

        if ($FirstName === '') { $errors[] = 'First name is required.'; }
        if ($LastName === '') { $errors[] = 'Last name is required.'; }
        if (!$Email || !filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email is required or the format is invalid.'; }
        if ($access === false) { $errors[] = 'Access level is required.'; }
        if ($errors) { return $errors; }

        $userDb = new User_DB();
        if ($userDb->Email_Exists_For_Other_User($Email, $ID)) {
            return ['The email address is already in use by another user.'];
        }
        if (!$userDb->Update_User_Details($ID, $FirstName, $LastName, $Email, $access)) {
            return ['The user could not be edited due to a system error.'];
        }
        return [];
    }

    // Adds a new user to the database
    public static function addUser($FirstName, $LastName, $Email, $Password) {
        return User_DB::Add_User($LastName, $FirstName, $Email, $Password);
    }

    // Checks that a password is 8-20 chars with upper, lower, number, and special character
    private static function isPasswordComplex($Password) {
        return (bool) preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,20}$/', $Password);
    }

    // Registers a new user with the provided details, including password confirmation
    public static function registerUser($FirstName, $LastName, $Email, $Password, $PasswordConfirmation) {
        $errors = [];
        $FirstName = trim(filter_var($FirstName, FILTER_SANITIZE_STRING));
        $LastName = trim(filter_var($LastName, FILTER_SANITIZE_STRING));
        $Email = trim(filter_var($Email, FILTER_SANITIZE_EMAIL));

        if ($FirstName === '') { $errors[] = 'First name is required.'; }
        if ($LastName === '') { $errors[] = 'Last name is required.'; }
        if (!$Email || !filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'A valid email address is required.';
        }
        if ($Password === '') { $errors[] = 'You must enter a password.'; }
        if ($Password !== '' && !self::isPasswordComplex($Password)) {
            $errors[] = 'Password must be 8-20 characters and include an uppercase letter, a lowercase letter, a number, and a special character.';
        }
        if ($Password !== $PasswordConfirmation) { $errors[] = 'Passwords do not match.'; }
        if ($errors) { return $errors; }

        if (User_DB::Get_User_By_Email($Email)) {
            return ['The email address is already registered.'];
        }

        $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);
        if (!self::addUser($FirstName, $LastName, $Email, $hashedPassword)) {
            return ['The user could not be registered due to a system error.'];
        }

        return [];
    }

    // Deletes a user from the database by their ID
    public static function deleteUser($ID) {
        $userDb = new User_DB();
        return $userDb->Delete_User($ID);
    }

    // Validates a user's credentials and returns their access level if valid
    public static function validUser($email, $password) {
        $row = User_DB::Get_User_By_Email($email);
        if ($row && password_verify($password, $row['Password'])) {
            return (string) $row['access'];
        }
        return null;
    }

    // Changes the password for a user after verifying the current password
    public static function changePassword($Email, $CurrentPassword, $NewPassword, $Confirmation) {
        $errors = [];
        $Email = trim(filter_var($Email, FILTER_SANITIZE_EMAIL));

        if (!$Email || !filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'A valid email address is required.';
        }
        if ($CurrentPassword === '') {
            $errors[] = 'You must enter your current password.';
        }
        if ($NewPassword === '') {
            $errors[] = 'You must enter a new password.';
        }
        if ($NewPassword !== '' && !self::isPasswordComplex($NewPassword)) {
            $errors[] = 'New password must be 8-20 characters and include an uppercase letter, a lowercase letter, a number, and a special character.';
        }
        if ($NewPassword !== $Confirmation) {
            $errors[] = 'The new passwords do not match.';
        }
        if ($CurrentPassword !== '' && $CurrentPassword === $NewPassword) {
            $errors[] = 'Your new password must be different from your current password.';
        }
        if ($errors) {
            return $errors;
        }

        $user = User_DB::Get_User_By_Email($Email);
        if (!$user || !password_verify($CurrentPassword, $user['Password'])) {
            return ['The email address and/or current password do not match our records.'];
        }

        $hashedPassword = password_hash($NewPassword, PASSWORD_DEFAULT);
        if (!User_DB::Update_User_Password($Email, $hashedPassword)) {
            return ['The password could not be changed due to a system error.'];
        }
        return [];
    }
}
?>