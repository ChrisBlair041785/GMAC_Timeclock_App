<?php
require_once __DIR__ . "/../Model/Timeclock_db.php";

class TimeclockController {
    // Get the current statuses of all students
    public static function getStudentStatuses($sort = 'lastname') {
        $students = Timeclock_DB::getStudentStatuses($sort);
        if ($students === false) {
            throw new RuntimeException('The current timeclock records could not be retrieved.');
        }
        return $students;
    }
    // Record a clock-in or clock-out action for a student
    public static function recordAction($ID, $action) {
        $ID = filter_var($ID, FILTER_VALIDATE_INT);
        if (!$ID || !in_array($action, ['clock_in', 'clock_out'], true)) {
            return false;
        }
        return Timeclock_DB::recordAction($ID, $action);
    }
}

// Handle POST requests for recording timeclock actions (ignore unrelated posts like logout)
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && isset($_POST['action'])) {
    TimeclockController::recordAction($_POST['ID'] ?? null, $_POST['action'] ?? '');
    header('Location: ../View/Timeclock.php');
    exit();
}
?>