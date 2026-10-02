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

        if ($report === 'date_range') {
            if (!is_array($filterValue) || count($filterValue) !== 2) {
                throw new InvalidArgumentException('Please select a valid start and end date.');
            }
            [$startDate, $endDate] = $filterValue;
            $start = is_string($startDate) ? DateTime::createFromFormat('!Y-m-d', $startDate) : false;
            $end = is_string($endDate) ? DateTime::createFromFormat('!Y-m-d', $endDate) : false;
            if (!$start || $start->format('Y-m-d') !== $startDate
                || !$end || $end->format('Y-m-d') !== $endDate) {
                throw new InvalidArgumentException('Please select a valid start and end date.');
            }
            if ($start > $end) {
                throw new InvalidArgumentException('The start date must be on or before the end date.');
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