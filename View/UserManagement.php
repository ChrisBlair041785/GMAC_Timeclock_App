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
        <h2 class="text-center">User Management</h2>
        <p>
            <?php
            try{ 
                require('../Model/database.php');
                $conn = get_db_conn();
                $query = "SELECT CONCAT (LastName, ', ', FirstName) AS Name, ";
                $query .="Email FROM users ORDER BY FirstName ASC";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    echo '<table class="table table-striped">';
                    echo '<tr><th scope="col">Name</th><th scope="col">Email</th></tr>';
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo '<tr><td>' . $row['Name'] . '</td><td>' . $row['Email'] . '</td></tr>'; }
                    echo '</table>'; 
                    mysqli_free_result ($result); 
                } else {
                    echo '<p class"error">The current users could not be retrieved. We apologize';
                    echo 'for any inconvenience.</p>'; 
                    echo '<p>' . mysqli_error($conn) . '<br><br>Query: ' . $q . '</p>';
                    exit();
                } ($result);
                mysqli_close($conn); 
            } catch (Exception $e) {
                echo '<p class="text-center" style="color:red">An Exception occurred. Message: ' . $e->getMessage() . ' </p>';
                echo '<p class="text-center" style="color:red">The system is busy. Please try again later.</p>';
            } catch (Error $e) {
                echo '<p class="text-center" style="color:red">An Error occurred. Message: ' . $e->getMessage() . ' </p>';
                echo '<p class="text-center" style="color:red">The system is busy. Please try again later.</p>';
            }
        ?>
        </div>
        <aside class="col-sm-2">
            <?php include('../controller/user_buttons.php'); ?>
        </aside>
    </div>
    </body>
</html>