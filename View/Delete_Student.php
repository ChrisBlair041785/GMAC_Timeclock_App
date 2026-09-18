<?php
try {
    if ( (isset($_GET['ID'])) && (is_numeric($_GET['ID'])) ) {
        $ID = htmlspecialchars($_GET['ID'], ENT_QUOTES);
    } elseif ( (isset($_POST['ID'])) && (is_numeric($_POST['ID'])) ) {
        $ID = htmlspecialchars($_POST['ID'], ENT_QUOTES);
    } else { 
        header("Location: View/Login.php");
        exit();
    }

    require ('../Model/database.php');
    $conn = get_db_conn();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $sure = htmlspecialchars($_POST['sure'], ENT_QUOTES);
        if ($sure == 'Yes') {
            $q = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($q, 'DELETE FROM students WHERE StudID=? LIMIT 1');
            mysqli_stmt_bind_param($q, "i", $ID);
            mysqli_stmt_execute($q);
            if (mysqli_stmt_affected_rows($q) == 1) { 
                echo '<h3 class="text-center">The record has been deleted.</h3>';
            } else {
                echo '<p class="text-center">The record could not be deleted.';
                echo '<br>Either it does not exist or due to a system error.</p>';
                echo '<p>' . mysqli_error($conn) . '<br />Query: ' . $q . '</p>';
            }
        } else {
            echo '<h3 class="text-center">The user has NOT been deleted as ';
            echo 'you requested</h3>';
        }
    } else {
        $q = mysqli_stmt_init($conn);
        $query = "SELECT CONCAT(FirstName, ' ', LastName) FROM ";
        $query .= "students WHERE StudID=?";
        mysqli_stmt_prepare($q, $query);
        mysqli_stmt_bind_param($q, "i", $ID);
        mysqli_stmt_execute($q);
        $result = mysqli_stmt_get_result($q);
        $row = mysqli_fetch_array($result, MYSQLI_NUM); 
        if (mysqli_num_rows($result) == 1) {
            $user = htmlspecialchars($row[0], ENT_QUOTES);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GMAC Timekeeping System</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4"
        crossorigin="anonymous">
    </head>
    <body>
        <div class="container" style="margin-top: 30px">
            <header class="jumbotron text-center row"
                style="margin-bottom:2px; background: linear-gradient(white, #e68a00); padding:20px;">
                <div class="col-sm-2">
                <img class="img-fluid float-left" style="width:100px; height:100px;" src="../GMAC Logo.png" alt="Logo">
                </div>
                <div class="col-sm-8">
                    <h1 class="font-bold" style="text-align:center";>GMAC - Timekeeping System</h1>    
                </div>
            </header>
            <div class="row" style="padding-left: 0px;">
            <nav class="col-sm-2">
                <ul class="nav nav-pills flex-column">
                    <?php include('../controller/nav.php'); ?>
                </ul>
            </nav>
            <div class="col-sm-8">
                <h2 class="h2 text-center">Delete Student Record</h2>
                <h2 class="h2 text-center">Are you sure you want to permanently delete <?php echo $user; ?>?</h2>
                <form action="Delete_Student.php" method="post" name="deleteform" id="deleteform">
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8" style="padding-left: 70px;">
                            <input type="hidden" name="ID" value="<?php echo $ID; ?>">
                            <input id="submit-yes" class="btn btn-primary" type="submit" name="sure" value="Yes"> -
                            <input id="submit-no" class="btn btn-primary" type="submit" name="sure" value="No">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
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