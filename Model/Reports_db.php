<?php
require_once __DIR__ . "/database.php";

class Reports_DB {

    public static function getTimeReport($report) {
        $filters = [
            'daily' => 'DATE(COALESCE(t.Arrived, t.Departed)) = CURDATE()',
            'weekly' => 'YEARWEEK(COALESCE(t.Arrived, t.Departed), 1) = YEARWEEK(CURDATE(), 1)',
            'monthly' => 'MONTH(COALESCE(t.Arrived, t.Departed)) = MONTH(CURDATE())
                         AND YEAR(COALESCE(t.Arrived, t.Departed)) = YEAR(CURDATE())'
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
                  ORDER BY s.LastName ASC, COALESCE(t.Arrived, t.Departed) ASC";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            return false;
        }

        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        mysqli_free_result($result);
        return $rows;
    }
}
?>
