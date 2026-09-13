<?php
try {
    if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) {
        $id = htmlspecialchars($_GET['id'], ENT_QUOTES);
    } else
        if ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) {
            $id = htmlspecialchars($_POST['id'], ENT_QUOTES);
    } else { 
        header("Location: View/Login.php");
        exit();
    }
    require ('./Model/database.php');
    $conn = get_db_conn();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $sure = htmlspecialchars($_POST['sure'], ENT_QUOTES);
        if ($sure == 'Yes') {
            $q = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($q, 'DELETE FROM users WHERE userid=? LIMIT 1');
            mysqli_stmt_bind_param($q, "s", $id);
            mysqli_stmt_execute($q);
            if (mysqli_stmt_affected_rows($q) == 1) { 
                echo '<h3 class="text-center">The record has been deleted.</h3>';
            } else {
                echo '<p class="text-center">The record could not be deleted.';
                echo '<br>Either it does not exist or due to a system error.</p>';
                echo '<p>' . mysqli_error($dbcon ) . '<br />Query: ' . $q . '</p>';
            }
        } else {
            echo '<h3 class="text-center">The user has NOT been deleted as ';
            echo 'you requested</h3>';
        }
    } else {
        $q = mysqli_stmt_init($conn);
        $query = "SELECT CONCAT(first_name, ' ', last_name) FROM ";
        $query .= "users WHERE userid=?";
        mysqli_stmt_prepare($q, $query);
        mysqli_stmt_bind_param($q, "s", $id);
        mysqli_stmt_execute($q);
        $result = mysqli_stmt_get_result($q);
        $row = mysqli_fetch_array($result, MYSQLI_NUM); 
        if (mysqli_num_rows($result) == 1) {
            $user = htmlspecialchars($row[0], ENT_QUOTES);
?>
<h2 class="h2 text-center">Are you sure you want to permanently delete <?php echo $user; ?>?</h2>
<form action="delete_user.php" method="post" name="deleteform" id="deleteform">
    <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"></label>
        <div class="col-sm-8" style="padding-left: 70px;">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input id="submit-yes" class="btn btn-primary" type="submit" name="sure" value="Yes"> -
            <input id="submit-no" class="btn btn-primary" type="submit" name="sure" value="No">
        </div>
    </div>
</form>
<?php
        } else { 
            echo '<p class="text-center">This page has been accessed in error.</p>';
        }
    } 
    mysqli_stmt_close($q);
    mysqli_close($conn );

    } catch (Exception $e) {
        echo '<p class="text-center" style="color:red">An Exception occurred. Message: ' . $e->getMessage() . ' </p>';
        echo '<p class="text-center" style="color:red">The system is busy. Please try again later.</p>';
    } catch (Error $e) {
        echo '<p class="text-center" style="color:red">An Error occurred. Message: ' . $e->getMessage() . ' </p>';
        echo '<p class="text-center" style="color:red">The system is busy. Please try again later.</p>';
    }
?>