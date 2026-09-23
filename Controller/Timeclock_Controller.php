<?php
require_once __DIR__ . "/../Model/Timeclock_db.php";

class TimeclockController {

    public static function getStudentStatuses() {
        $students = Timeclock_DB::getStudentStatuses();
        if ($students === false) {
            throw new RuntimeException('The current timeclock records could not be retrieved.');
        }
        return $students;
    }

    public static function recordAction($ID, $action) {
        $ID = filter_var($ID, FILTER_VALIDATE_INT);
        if (!$ID || !in_array($action, ['clock_in', 'clock_out'], true)) {
            return false;
        }
        return Timeclock_DB::recordAction($ID, $action);
    }
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    TimeclockController::recordAction($_POST['ID'] ?? null, $_POST['action'] ?? '');
    header('Location: ../View/Timeclock.php');
    exit();
}
?>