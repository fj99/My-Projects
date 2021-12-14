<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    //connect to db
    include '../../DB/connect_to_db.php';

    $db_name = 'Daycare';

    $conn = get_db_connection($db_name);
    
    // Initialize sessions
    session_start();

    // Check if the user is already logged in, if not then redirect him to welcome page
    if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true))
    {
        if(!isset($_SESSION['employee']))
        {      
            header("location: ../../index.html");
            exit;
        }
    }

    //session variables
    $id = $_SESSION["id"];
    $username = $_SESSION["username"];
    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname'];
    $email = $_SESSION['email'];

    //connect to child and select * from child get thye whole table then
    //make an update to write employee id into child's table
    //$sql = "SELECT * FROM child";


?>

<html>
    <head>
        <meta charset="utf-8">
    </head>

    <body> 
        Employee Shift form<br> 
        <br>
        Welcome <?php echo $fname?> <?php echo $lname?>  :<br>
        <br>
        <form action = welcome_shift.php  method="POST"> 

            Username <?php echo $_SESSION["username"];?>  <br>
            <br>

            Shift Date: <input type="date" name = "Shift_Date" required><br>
            <br>

            Shift Time Start: <input type="time" name = "Shift_time_Start" required><br>
            <br>

            Shift Time End: <input type="time" name = "Shift_time_End" required><br>
            <br>

            <label for="child">Choose a child:</label>
            <select name="child" >
            <?php 
               $result=mysqli_query($conn,'SELECT childID, childFirstName FROM child'); 
               while($row=mysqli_fetch_assoc($result)) 
                { ?>                    
                    <option value= <?php echo $row['childID']?> ><?php echo $row['childFirstName']?></option>                                     
                <?php
                }?>          
            </select> <br>
            <br>

            <input type="submit">            
        </form>
        <br>
        <button onclick="location.href='Update_shift'" type="button">
        click here to update</button>
        <br>
        <br>
        <a  href = ../../index.php><img src="../../assets/img/home-symbol.jpg" width="50px" /></a>
    </body>
</html>

