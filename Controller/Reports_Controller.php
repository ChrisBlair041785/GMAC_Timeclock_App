<?php
require_once __DIR__ . "/../Model/Reports_db.php";

class ReportsController {

    public static function getTimeReport($report, $filterValue = null) {
        if ($report === 'Specific Date') {
            $report = 'specific_date';
        } elseif ($report === 'Student') {
            $report = 'student';
        }

        if ($report === 'specific_date') {
            $date = DateTime::createFromFormat('!Y-m-d', (string) $filterValue);
            if (!$date || $date->format('Y-m-d') !== $filterValue) {
                throw new InvalidArgumentException('Please select a valid date.');
            }
        }

        if ($report === 'student') {
            $filterValue = filter_var($filterValue, FILTER_SANITIZE_STRING);
            if (!$filterValue) {
                throw new InvalidArgumentException('Please select a valid student.');
            }
        }

        $rows = Reports_DB::getTimeReport($report, $filterValue);
        if ($rows === false) {
            throw new RuntimeException('The requested time report could not be retrieved.');
        }
        return $rows;
    }
}