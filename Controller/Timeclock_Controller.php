<?php
require_once("../Model/Timeclock.php");
$conn = get_db_conn();

function handle_timeclock_action($conn) {
    if (isset($_POST['action']) && isset($_POST['ID'])) {
        $action = $_POST['action'];
        $ID = $_POST['ID'];
        if ($action === 'clock_in') {
            clock_in($conn, $ID);
        } elseif ($action === 'clock_out') {
            clock_out($conn, $ID);
        }
    }
}

handle_timeclock_action($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header("Location: ../View/Timeclock.php");
    exit();
}

function clock_in($conn, $ID) {
    $query = "UPDATE timeclock SET Arrived = NOW(), Departed = NULL WHERE StudID = '$ID'";
    mysqli_query($conn, $query);
}

function clock_out($conn, $ID) {
    $query = "UPDATE timeclock SET Departed = NOW() WHERE StudID = '$ID'";
    mysqli_query($conn, $query);
}
?>