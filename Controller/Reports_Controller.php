<?php
require_once __DIR__ . "/../Model/Reports_db.php";

class ReportsController {

    public static function getTimeReport($report) {
        $rows = Reports_DB::getTimeReport($report);
        if ($rows === false) {
            throw new RuntimeException('The requested time report could not be retrieved.');
        }
        return $rows;
    }
}