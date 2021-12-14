<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
    //connect to db
    include '../../DB/connect_to_db.php';

    $db_name = 'Daycare';

    $conn = get_db_connection($db_name);

    //VARIABLES
    $shiftD = $_POST["Shift_Date"];
    $shiftS = $_POST["Shift_time_Start"];
	$shiftE = $_POST["Shift_time_End"];
	$childid  = $_POST["child"];    

    //Initialize sessions
    session_start();
    
    $id = $_SESSION["id"];
    $username = $_SESSION["username"];
    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname'];
    $email = $_SESSION['email'];
    
    $sql = "SELECT * FROM Shift_Schedule WHERE EmployeeID = '".$id."' AND Shift_Date = '".$shiftD."' AND Shift_time = '".$shiftS."' ";

    //time they worked not finished
    $work = (strtotime($shiftS) - strtotime($shiftE))/3600;

    if(!mysqli_num_rows(mysqli_query($conn, $sql)))
    {
        
        $sql = "INSERT INTO Shift_Schedule(Shift_Date, Shift_time, EmployeeID, MinutesWorked) VALUES('".$shiftD."', '".$shiftS."', '".$id."','".$work."')";
        $result = mysqli_query($conn, $sql);
           
        $sql2 = "UPDATE child SET EmployeeID = '".$id."' WHERE childID = '".$childid."' ";
        $result2 = mysqli_query($conn, $sql2);

        if($result && $result2)
        {  
            echo "Accounts Successfully Created";  
        } 
        else
        {  
            echo "Failure! ".mysqli_error($conn);
        }
    }
    else
    {
        echo "Account already exist";
    }    

    $sql = "SELECT childFirstName, childLastName, child_sex, child_Date_of_Birth FROM child WHERE childID = '".$childid."' ";
    $result = mysqli_query($conn, $sql);  
    $row2 = $result->fetch_assoc();

    $First = $row2["childFirstName"];
    $Last = $row2["childLastName"];
    $Sex = $row2["child_sex"];
    $DateOfB = $row2["child_Date_of_Birth"]; 

    mysqli_close($conn);
    
    //emails
    

?>

<html>
    <head>
        <meta charset="utf-8">
    </head>

    <body>
        <br> <br>
        Welcome To our Daycare  <?php echo$fname?> <?php echo $lname?> <br>
        Your shift date is <?php echo $shiftD?> <br>
        Your shift time start is <?php echo $shiftS?> <br>
        Your time worked is <?php echo $work?> <br>
        Your email address is  <?php echo$email?> <br>
        The Child's name is  <?php echo $First; ?> <?php echo $Last; ?> <br> 
        The Sex of your child is  <?php echo $Sex; ?> <br>
        Your Child's Date of Birth is     <?php echo $DateOfB; ?> <br>
        <br>
		<br>
		<p>Sign in <a href="Sign_in.php">Sign in</a>.</p>
        <br>
        <br>
        <a  href = ../../index.php><img src="../../assets/img/home-symbol.jpg" width="50px" /></a>
    </body>
</html>

