<?php
    include '../../DB/connect_to_db.php';

    $db_name = 'daycare';

    $conn = get_db_connection($db_name);

    // Initialize sessions
    session_start();
    //session var
    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname'];
    $email = $_SESSION['email']; 
    $id = $_SESSION['id'];
    $username = $_SESSION['username'];

    // Check if the user is already logged in, if yes then redirect him to welcome page
    if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true))
    {
        header("location: ../../index.html");
        exit;       
    }

    if(isset($_POST['submit']))
    { 
        $date = $_POST["Date"];
        $start = $_POST["Start"];
        $work = $_POST["work"];
        $child  = $_POST["child"]; 
        
        $sql = "UPDATE Shift_Schedule SET Shift_Date = $date, Shift_time = $start, MinutesWorked = $work WHERE EmployeeID = $id ";
        echo $sql;
        $result=mysqli_query($conn, $sql);

        $sql2 = "UPDATE child SET EmployeeID = $id WHERE childID = $child";
        $result2=mysqli_query($conn, $sql2);
    }
    else
    {
        $sql = "SELECT Shift_Date, Shift_time, MinutesWorked FROM Shift_Schedule WHERE EmployeeID = $id ";
        $result = mysqli_query($conn, $sql);
        $row = $result->fetch_assoc(); 
        $date = $row["Shift_Date"];
        $start = $row["Shift_time"];
        $work = $row["MinutesWorked"];
    }
    
?>

<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <meta charset="utf-8">
    </head>

    <body> 
        <h2>Welcome To our Daycare <?php echo $fname; ?> <?php echo $lname; ?> </h2>
        <h3>Your Username is <?php echo $username; ?> </h3><br>
        <h3>Your email is <?php echo $email; ?> </h3><br>
           
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="POST"> 

            Shift Date: <input type="date" name = "Date" value = <?php echo $date; ?>><br>
            <br>

            Shift Time Start: <input type="time" name = "Start" value = <?php echo $start; ?>><br>
            <br>

            Time worked: <input type="time" name = "work" value = <?php echo $work; ?> ><br>
            <br>   
            
            <label for="Yourchild">Your children:</label>
            <select name="Yourchild" >
            <?php 
               $result=mysqli_query($conn,"SELECT childID, childFirstName FROM child WHERE EmployeeID = $id"); 
               while($row=mysqli_fetch_assoc($result)) 
                { ?>                    
                    <option value= <?php echo $row['childID']?> ><?php echo $row['childFirstName']?></option>                                     
                <?php
                }?>          
            </select> <br>
            <br>

            <label for="child">Choose a child:</label>
            <select name="child" >
            <?php 
               $result=mysqli_query($conn,"SELECT childID, childFirstName FROM child"); 
               while($row=mysqli_fetch_assoc($result)) 
                { ?>                    
                    <option value= <?php echo $row['childID']?> ><?php echo $row['childFirstName']?></option>                                     
                <?php
                }?>          
            </select> <br>

            <input class="submit" name = "submit" type="submit" >            
        </form>
        <br>
        <br>
        <a  href = ../../index.php><img src="../../assets/img/home-symbol.jpg" width="50px" /></a>
    </body>
</html>

