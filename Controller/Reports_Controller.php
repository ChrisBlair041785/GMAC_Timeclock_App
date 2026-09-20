<?php 
require_once('..\Model\database.php'); 
$conn = get_db_conn(); 

Function getDailyReport() {
    $query = "SELECT *, MIN(CASE WHEN Arrived IS NOT NULL THEN Arrived END) AS Check-In, 
        MAX(CASE WHEN Departed IS NOT NULL THEN Departed END) AS Check-Out 
        FROM Timeclock WHERE DATE(timestamp) = CURDATE() GROUP BY StudID"; 
    mysqli_query($conn, $query); 
}

Function getWeeklyReport() {
    $query = "SELECT *, MIN(CASE WHEN Arrived IS NOT NULL THEN Arrived END) AS Check-In, 
        MAX(CASE WHEN Departed IS NOT NULL THEN Departed END) AS Check-Out 
        FROM Timeclock WHERE YEARWEEK(timestamp, 1) = YEARWEEK(CURDATE(), 1) GROUP BY StudID"; 
    mysqli_query($conn, $query); 
}

Function getMonthlyReport() {
    $query = "SELECT *, MIN(CASE WHEN Arrived IS NOT NULL THEN Arrived END) AS Check-In, 
        MAX(CASE WHEN Departed IS NOT NULL THEN Departed END) AS Check-Out 
        FROM Timeclock WHERE MONTH(timestamp) = MONTH(CURDATE()) AND YEAR(timestamp) = YEAR(CURDATE()) GROUP BY StudID"; 
    mysqli_query($conn, $query); 
}