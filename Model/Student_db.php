<?php
require_once __DIR__ . "/database.php";

class Student_DB {
    // Handles database operations related to the Student entity
    // Retrieves all student records from the database, ordered by last name
    function All_Students() { 
        $db = new Database();
        $conn = $db->getDBConn();
        $query = "SELECT * FROM students ORDER BY LastName ASC" ;
        $results = mysqli_query($conn, $query);
        return $results;
    }

    // Adds a new student record to the database
    function Add_StudentDB($FirstName, $LastName, $School) { 
        $db = new Database();
        $conn = $db->getDBConn();
        $query = "INSERT INTO students (FirstName, LastName, School) VALUES (?, ?, ?)";
        $statement = mysqli_prepare($conn, $query);
        if (!$statement) {
            return false;
        }
        mysqli_stmt_bind_param($statement, "sss", $FirstName, $LastName, $School);
        mysqli_stmt_execute($statement);
        $added = mysqli_stmt_affected_rows($statement) === 1;
        mysqli_stmt_close($statement);
        return $added;
    }

    // Retrieves the ID of the last inserted student record
    function Get_Last_Inserted_StudID() {
        $db = new Database();
        $conn = $db->getDBConn();
        $query = "SELECT LAST_INSERT_ID() AS StudID";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['StudID'] ?? null;
    }

    // Retrieves a student record by its ID from the database
    function Get_Student_By_ID($StudID) {
        $db = new Database();
        $conn = $db->getDBConn();
        $query = "SELECT * FROM students WHERE StudID = ?";
        $statement = mysqli_prepare($conn, $query);
        if (!$statement) {
            return null;
        }
        mysqli_stmt_bind_param($statement, "i", $StudID);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        $student = mysqli_fetch_assoc($result);
        mysqli_stmt_close($statement);
        return $student;
    }

    // Updates an existing student record in the database
    function Update_Student($StudID, $FirstName, $LastName, $School) {
        $db = new Database();
        $conn = $db->getDBConn();
        $query = "UPDATE students SET FirstName = ?, LastName = ?, School = ? WHERE StudID = ? LIMIT 1";
        $statement = mysqli_prepare($conn, $query);
        if (!$statement) {
            return false;
        }
        mysqli_stmt_bind_param($statement, "sssi", $FirstName, $LastName, $School, $StudID);
        mysqli_stmt_execute($statement);
        $updated = mysqli_stmt_affected_rows($statement) >= 0;
        mysqli_stmt_close($statement);
        return $updated;
    }

    // Deletes a student record from the database by its ID
    function Delete_Student($StudID) {
        $db = new Database();
        $conn = $db->getDBConn();
        $query = "DELETE FROM students WHERE StudID = ? LIMIT 1";
        $statement = mysqli_prepare($conn, $query);
        if (!$statement) {
            return false;
        }
        mysqli_stmt_bind_param($statement, "i", $StudID);
        mysqli_stmt_execute($statement);
        $deleted = mysqli_stmt_affected_rows($statement) === 1;
        mysqli_stmt_close($statement);
        return $deleted;
    }
}
?>