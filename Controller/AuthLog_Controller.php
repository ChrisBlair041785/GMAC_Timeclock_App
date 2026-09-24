<?php
class AuthLogController {
    public static function getAllLogs() {
        require_once __DIR__ . '/../Model/AuthLog_db.php';
        return AuthLog_db::getAllLogs();
    }
}
?>