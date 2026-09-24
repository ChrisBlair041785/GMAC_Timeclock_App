<?php
require_once __DIR__ . "/database.php";

class AuthLog_DB {

    public static function record($eventType, $email = null, $accessLevel = null) {
        $db = new Database();
        $conn = $db->getDBConn();
        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? null;
        $query = "INSERT INTO auth_logs (EventType, Email, AccessLevel)
                  VALUES (?, ?, ?)";
        $statement = mysqli_prepare($conn, $query);
        if (!$statement) {
            return false;
        }

        mysqli_stmt_bind_param($statement, "ssi", $eventType, $email, $accessLevel);
        mysqli_stmt_execute($statement);
        $recorded = mysqli_stmt_affected_rows($statement) === 1;
        mysqli_stmt_close($statement);
        return $recorded;
    }

    public static function getAllLogs() {
        $db = new Database();
        $conn = $db->getDBConn();
        $query = "SELECT * FROM auth_logs";
        $result = mysqli_query($conn, $query);
        $logs = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $logs[] = $row;
            }
        }
        return $logs;
    }
}
?>