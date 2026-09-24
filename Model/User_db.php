<?php 
require_once __DIR__ . "/database.php"; 
Class User_DB {

    public static function All_Users() {
        $db = new Database();
        $conn = $db->getDBConn();
        $query = "SELECT * FROM users ORDER BY LastName ASC";
        $results = mysqli_query($conn, $query);
        return $results;
    }

    public static function Add_User($LastName, $FirstName, $Email, $Password) {
        $db = new Database();
        $conn = $db->getDBConn();
        $query = "INSERT INTO users (LastName, FirstName, Email, Password, access) VALUES (?, ?, ?, ?, 0)";
        $statement = mysqli_prepare($conn, $query);
        if (!$statement) {
            return false;
        }
        mysqli_stmt_bind_param($statement, "ssss", $LastName, $FirstName, $Email, $Password);
        mysqli_stmt_execute($statement);
        $added = mysqli_stmt_affected_rows($statement) === 1;
        mysqli_stmt_close($statement);
        return $added;
    }

    public static function Get_User_By_ID($ID) {
        $db = new Database();
        $conn = $db->getDBConn();
        $query = "SELECT * FROM users WHERE ID = ?";
        $statement = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($statement, "i", $ID);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        $user = mysqli_fetch_assoc($result);
        mysqli_stmt_close($statement);
        return $user;
    }

    public static function Get_User_By_Email($Email) {
        $db = new Database();
        $conn = $db->getDBConn();
        $query = "SELECT * FROM users WHERE Email = ?";
        $statement = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($statement, "s", $Email);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        $user = mysqli_fetch_assoc($result);
        mysqli_stmt_close($statement);
        return $user;
    }

    public static function Email_Exists_For_Other_User($email, $ID) {
        $db = new Database();
        $conn = $db->getDBConn();
        $query = "SELECT ID FROM users WHERE Email = ? AND ID != ?";
        $statement = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($statement, "si", $email, $ID);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        $exists = mysqli_stmt_num_rows($statement) > 0;
        mysqli_stmt_close($statement);
        return $exists;
    }

    public static function Update_User_Details($ID, $FirstName, $LastName, $Email, $access) {
        $db = new Database();
        $conn = $db->getDBConn();
        $query = "UPDATE users SET FirstName = ?, LastName = ?, Email = ?, access = ? WHERE ID = ? LIMIT 1";
        $statement = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($statement, "sssii", $FirstName, $LastName, $Email, $access, $ID);
        mysqli_stmt_execute($statement);
        $updated = mysqli_stmt_affected_rows($statement) >= 0;
        mysqli_stmt_close($statement);
        return $updated;
    }

    public static function Update_User_Password($Email, $Password) {
        $db = new Database();
        $conn = $db->getDBConn();
        $query = "UPDATE users SET Password = ? WHERE Email = ? LIMIT 1";
        $statement = mysqli_prepare($conn, $query);
        if (!$statement) {
            return false;
        }
        mysqli_stmt_bind_param($statement, "ss", $Password, $Email);
        mysqli_stmt_execute($statement);
        $updated = mysqli_stmt_affected_rows($statement) === 1;
        mysqli_stmt_close($statement);
        return $updated;
    }

    public static  function Delete_User($ID) {
        $db = new Database();
        $conn = $db->getDBConn();
        $query = "DELETE FROM users WHERE ID = ? LIMIT 1";
        $statement = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($statement, "i", $ID);
        mysqli_stmt_execute($statement);
        $deleted = mysqli_stmt_affected_rows($statement) === 1;
        mysqli_stmt_close($statement);
        return $deleted;
    }

}
?>
