<?php
require_once __DIR__ . "/database.php";

class Timeclock_DB {

    public static function getStudentStatuses($sort = 'lastname') {
        $sortColumns = [
            'id' => 's.StudID',
            'lastname' => 's.LastName',
            'firstname' => 's.FirstName',
            'school' => 's.School'
        ];
        if (!isset($sortColumns[$sort])) {
            return false;
        }

        $db = new Database();
        $conn = $db->getDBConn();
        $query = "SELECT s.StudID, s.LastName, s.FirstName, s.School,
                         t.Arrived, t.Departed
                  FROM Students s
                  LEFT JOIN timeclock t
                    ON t.StudID = s.StudID
                   AND t.ID = (
                       SELECT MAX(latest.ID)
                       FROM timeclock latest
                       WHERE latest.StudID = s.StudID
                   )
                  ORDER BY {$sortColumns[$sort]} ASC";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            return false;
        }

        $students = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $students[] = $row;
        }
        mysqli_free_result($result);
        return $students;
    }

    public static function recordAction($ID, $action) {
        $db = new Database();
        $conn = $db->getDBConn();
        $query = $action === 'clock_in'
            ? "INSERT INTO timeclock (StudID, Arrived, Departed) VALUES (?, NOW(), NULL)"
            : "INSERT INTO timeclock (StudID, Arrived, Departed) VALUES (?, NULL, NOW())";
        $statement = mysqli_prepare($conn, $query);
        if (!$statement) {
            return false;
        }
        mysqli_stmt_bind_param($statement, "i", $ID);
        mysqli_stmt_execute($statement);
        $recorded = mysqli_stmt_affected_rows($statement) === 1;
        mysqli_stmt_close($statement);
        return $recorded;
    }
}
?>
