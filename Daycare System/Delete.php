<?php
    // Start sessions
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    include 'DB/connect_to_db.php';
    $db_name = 'Daycare';
    $conn = get_db_connection($db_name);
    session_start();
?>

<html>
    <head>
        <style>
            body{
                
                background-image: url("assets/img/background-forms.jpg");
                color: white;
                text-align: center
            }
            .button 
            {
                /* -moz-box-sizing: border-box; */ /* Firefox, other Gecko */
                height: 35px; 
                width:110px; 
                font-size: 20px;
            }
        </style>
    </head>
    <body>
    <a href = index.php><img src="assets/img/navbar-logo.svg" width="320px" /></a> <br>
        <br>
        <form method="POST">
            <label  for="button"><h2>If you want to delete your account</h2></label>
            <input type="submit" name="button"
                    class="button" value="Click Here" />            
        </form>
        <br>

        <p id="print">

        </p>

        <br>
        <!-- <a href = index.php><img src="assets/img/home-symbol.jpg" width="50px"/></a> -->
    </body>
</html>

<?php
//if(array_key_exists('button', $_POST)) 
if(isset($_POST['button']))
{        
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
    {
        echo'<script>
            alert("Account has been deleted");
            document.getElementById("print").innerHTML = "Account has been deleted";
            </script>';
        $id = $_SESSION['id'];
        if($_SESSION['parent'] )
        {
            $sql = "DELETE FROM parent WHERE ParentID = $id";
            $result = mysqli_query($conn, $sql);

            $sql2 = "DELETE FROM child WHERE ParentID = $id";
            $result = mysqli_query($conn, $sql2);          
        }
        elseif($_SESSION['employee'])
        {
            $sql = "DELETE FROM employee WHERE EmployeeID = $id";
            $result = mysqli_query($conn, $sql);

            $sql2 = "DELETE FROM Shift_Schedule WHERE EmployeeID = $id";
            $result = mysqli_query($conn, $sql);
        }
        $_SESSION  = array();    

        // Destroy all session related to user
        session_destroy();

        // Redirect to home page
        header('location: index.html');
        exit;
    }
    else
    {
        echo'<script>
            alert("Not signed in, No account to delete");
            document.getElementById("print").innerHTML = "<h3>Not signed in, No account to delete<h3/>";
            </script>';
    }
    
}
?>