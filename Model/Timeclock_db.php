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
                         CASE
                             WHEN MAX(t.Arrived) IS NOT NULL
                                  AND (MAX(t.Departed) IS NULL OR MAX(t.Arrived) > MAX(t.Departed))
                             THEN MAX(t.Arrived)
                             ELSE NULL
                         END AS Arrived,
                         CASE
                             WHEN MAX(t.Departed) IS NOT NULL
                                  AND (MAX(t.Arrived) IS NULL OR MAX(t.Departed) > MAX(t.Arrived))
                             THEN MAX(t.Departed)
                             ELSE NULL
                         END AS Departed
                  FROM Students s
                  LEFT JOIN timeclock t ON t.StudID = s.StudID
                  GROUP BY s.StudID, s.LastName, s.FirstName, s.School
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
