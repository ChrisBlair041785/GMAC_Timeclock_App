<?php
require_once __DIR__ . "/../Model/student_db.php";
require_once __DIR__ . "/../Model/Student.php";

class StudentController {

    private static function rowToStudent($row) {
        $student = new Student($row['FirstName'], $row['LastName'],
            $row['School'], $row['StudID']);
        return $student;
    }

    public static function getAllStudents() {
        $studentdb = new Student_DB(); 
        $results = $studentdb->All_Students();
        $students = [];
        if ($results instanceof mysqli_result) {
            while ($row = mysqli_fetch_assoc($results)) {
                $students[] = self::rowToStudent($row);
            }
            mysqli_free_result($results);
        }
        return $students;
    }

    public static function getStudentByID($StudID) {
        $studentdb = new Student_DB();
        $row = $studentdb->Get_Student_By_ID($StudID);

        if ($row) {
            return self::rowToStudent($row);
        }
        return null;
    }

    public static function AddStudentDB($FirstName, $LastName, $School) {
        $errors = [];
        $FirstName = trim(filter_var($FirstName, FILTER_SANITIZE_STRING));
        $LastName = trim(filter_var($LastName, FILTER_SANITIZE_STRING));
        $School = trim(filter_var($School, FILTER_SANITIZE_STRING));

        if ($FirstName === '') {$errors[] = "First name is required.";}
        if ($LastName === '') {$errors[] = "Last name is required.";}
        if ($School === '') {$errors[] = "School is required.";}
        if ($errors) { return $errors; }

        $studentdb = new Student_db();
        if (!$studentdb->Add_StudentDB($FirstName, $LastName, $School)) {
            return ['The Student could not be added due to a system error.'];
        }
        return [];
    }

    public static function updateStudent($StudID, $FirstName, $LastName, $School) {
        $errors = [];
        $FirstName = trim(filter_var($FirstName, FILTER_SANITIZE_STRING));
        $LastName = trim(filter_var($LastName, FILTER_SANITIZE_STRING));
        $School = trim(filter_var($School, FILTER_SANITIZE_STRING));

        if ($FirstName === '') {$errors[] = "First name is required.";}
        if ($LastName === '') {$errors[] = "Last name is required.";}
        if ($School === '') {$errors[] = "School is required.";}
        if ($errors) { return $errors; }

        $studentdb = new Student_db();
        if (!$studentdb->Update_Student($StudID, $FirstName, $LastName, $School)) {
            return ['The Student could not be edited due to a system error.'];
        }
        return [];
    }

    public static function deleteStudent($StudID) {
        $studentdb = new Student_db();
        return $studentdb->Delete_Student($StudID);
    }

}
?>