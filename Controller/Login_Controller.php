<?php
require_once __DIR__ . "/User_Controller.php";
require_once __DIR__ . "/../Model/AuthLog_db.php";
class LoginController {
    public static function handleLogin() {
        $login_msg = isset($_SESSION['logout_msg']) ? $_SESSION['logout_msg'] : ''; 
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = trim($_POST['email']);
            $access_level = UserController::validUser($email, $_POST['password']);
            if ($access_level !== null) {
                AuthLog_DB::record('login_success', $email, (int) $access_level);
                $_SESSION['email'] = $email;
            } else {
                AuthLog_DB::record('login_failure', $email);
            }
            if ($access_level === '0') {
                $_SESSION['access'] = 0;
                session_regenerate_id(true);
                $_SESSION['new'] = true; 
                $_SESSION['user'] = false; 
                $_SESSION['admin'] = false; 
                header('location: ../View/Homepage.php');
                exit();
            } else if ($access_level === '1') {
                $_SESSION['access'] = 1;
                session_regenerate_id(true);
                $_SESSION['new'] = false; 
                $_SESSION['user'] = true; 
                $_SESSION['admin'] = false; 
                header('location: ../View/Timeclock.php');
                exit();
            } else if ($access_level === '2') {
                $_SESSION['access'] = 2;
                session_regenerate_id(true);
                $_SESSION['new'] = false; 
                $_SESSION['user'] = false; 
                $_SESSION['admin'] = true; 
                header('location: ../View/UserManagement.php');
                exit();
            } else {
                $login_msg = "Invalid email or password.";
            }
        }
    return $login_msg;
    }
}
?>
