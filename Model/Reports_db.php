<?php
require_once __DIR__ . "/database.php";

class Reports_DB {

    public static function getTimeReport($report, $filterValue = null) {
        $filters = [
            'daily' => 'DATE(COALESCE(t.Arrived, t.Departed)) = CURDATE()',
            'weekly' => 'YEARWEEK(COALESCE(t.Arrived, t.Departed), 1) = YEARWEEK(CURDATE(), 1)',
            'monthly' => 'MONTH(COALESCE(t.Arrived, t.Departed)) = MONTH(CURDATE())
                         AND YEAR(COALESCE(t.Arrived, t.Departed)) = YEAR(CURDATE())',
            'specific_date' => 'DATE(COALESCE(t.Arrived, t.Departed)) = ?',
            'student' => 's.LastName = ?'
        ];

        if (!isset($filters[$report])) {
            return false;
        }

        $db = new Database();
        $conn = $db->getDBConn();
        $query = "SELECT s.StudID, s.LastName, s.FirstName,
                         t.Arrived AS CheckIn, t.Departed AS CheckOut
                  FROM Students s
                  INNER JOIN timeclock t ON t.StudID = s.StudID
                  WHERE {$filters[$report]}
                  ORDER BY s.LastName ASC, s.FirstName ASC,COALESCE(t.Arrived, t.Departed) ASC";
        $statement = mysqli_prepare($conn, $query);
        if (!$statement) {
            return false;
        }

        if (in_array($report, ['specific_date', 'student'], true)) {
            $type = 's';
            mysqli_stmt_bind_param($statement, $type, $filterValue);
        }

        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        if (!$result) {
            mysqli_stmt_close($statement);
            return false;
        }

        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        mysqli_free_result($result);
        mysqli_stmt_close($statement);
        return $rows;
    }
}
?>
