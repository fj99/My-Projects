<?php
    include '../../DB/connect_to_db.php';

    $db_name = 'daycare';

    $conn = get_db_connection($db_name);

    // Initialize sessions
    session_start(); 
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
        $fname = $_POST['FirstName'];
        $lname = $_POST['LastName'];
        $email = $_POST['email'];
        $DateB = $_POST['DateOfBirth'];
        $pssd = $_POST['pass_field'];
        
        $sql = "UPDATE parent SET EmployeeFirstName = $fname, EmployeeLastName = $lname, Employee_Email = $email, Employee_Date_of_Birth = $DateB, Employee_Password = $pssd WHERE EmployeeID = $id AND username = $username ";
        //echo $sql;
        $result=mysqli_query($conn, $sql);

        $_SESSION['fname'] = $fname;
        $_SESSION['lname'] = $lname;
        $_SESSION['email'] = $email;
        $Date = $DateB;
        $Pss = $pssd;
    }
    else
    {
        $sql2 = "SELECT Employee_Date_of_Birth, Employee_Password FROM employee WHERE EmployeeID = $id AND username = '".$username."' ";
        $result2 = mysqli_query($conn, $sql2);
        $row = $result2->fetch_assoc(); 
        $Date = $row["Employee_Date_of_Birth"];
        $Pss = $row["Employee_Password"];    
    }

    //session var
    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname'];
    $email = $_SESSION['email'];

    
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


        <h3>Your date of birth is <?php echo $Date; ?> </h3><br>
        <h3>Your Password is <?php echo $Pss; ?> </h3><br>
           
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="POST"> 

            First Name: <input type="text" name = "FirstName" value = <?php echo $fname;?>  ><br>
            <br>

            Last Name: <input type="text" name = "LastName" value = <?php echo $lname;?> ><br>
            <br>
            
            E-mail: <input type="email" name = "email" value = <?php echo $email;?> ><br>
            <br>

            Date of Birth: <input type="date" name = "DateOfBirth" value = <?php echo $Date;?> ><br>
            <br>
            
            Password: <input type="text" name = "pass_field" value = <?php echo $Pss;?> ><br>
            <br>

            <input class="submit" name = "submit" type="submit">            
        </form>
        <br>
        <br>
        <a  href = ../../index.php><img src="../../assets/img/home-symbol.jpg" width="50px" /></a>
    </body>
</html>