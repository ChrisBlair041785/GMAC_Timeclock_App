<?php
require_once __DIR__ . "/../Model/AuthLog_db.php";

class Security {
    // Handles user authentication and authorization related security functions
    public static function logout() { 
        AuthLog_DB::record(
            'logout',
            $_SESSION['email'] ?? null,
            $_SESSION['access'] ?? null
        );
        $_SESSION = [];
        unset($_POST);
        $_SESSION['logout_msg'] = 'You have been logged out.';
        header('Location: ../View/Login.php');
        exit();
    }
    // Checks if the current user has the required authority
    public static function checkAuthority($auth) {
        $authorities = is_array($auth) ? $auth : [$auth];
        $authorized = false;

        foreach ($authorities as $authority) {
            if (is_numeric($authority)) {
                $authorized = isset($_SESSION['access'])
                    && (int) $_SESSION['access'] === (int) $authority;
            } else {
                $authorized = isset($_SESSION[$authority]) && $_SESSION[$authority];
            }

            if ($authorized) {
                break;
            }
        }

        if (!$authorized) {
            $_SESSION['logout_msg'] = 'Current login is not authorized to access this page.';
            header('Location: ../View/Login.php');
            exit();
        }
    }
}