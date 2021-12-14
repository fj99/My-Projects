<?php
    //mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
    //connect to db
    include '../../DB/connect_to_db.php';

    $db_name = 'Daycare';

    $conn = get_db_connection($db_name);

    //VARIABLES
    $username = $_POST["username"];
    $First    = $_POST["FirstName"];
    $Last     = $_POST["LastName"]; 
	$phone 	  = $_POST["phone"];
    $Email    = $_POST["email"];
	$address  = $_POST["addy"];
    $DateOfB  = $_POST["DateOfBirth"];
    $Pssd     = $_POST["pass_field"];                
    
    $sql = "SELECT * FROM employee WHERE username = '".$username."' ";

    if(!mysqli_num_rows(mysqli_query($conn, $sql)))
    {
        $sql = "INSERT INTO employee(username, EmployeeFirstName, EmployeeLastName, Employee_phoneNumber, Employee_Email, Employee_Address, Employee_Date_of_Birth, Employee_Password) VALUES( '".$username."', '".$First."', '".$Last."','".$phone."', '".$Email."', '".$address."', '".$DateOfB."', '".$Pssd."' )";
        $result = mysqli_query($conn, $sql);
        
        if($result)
        {  
            echo "Account Successfully Created";  
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
    mysqli_close($conn);
    
    //emails
    

?>

<html>
    <head>
    <link rel="stylesheet" href="style.css">
        <meta charset="utf-8">
    </head>

    <body>
        <br> <br>
        Welcome To our Daycare  <?php echo $_POST["FirstName"]; ?> <?php echo $_POST["LastName"]; ?> <br>
        Your usernam is <?php echo $_POST["username"]; ?> <br>
        Your email address is  <?php echo $_POST["email"]; ?> <br>
        Your Date of Birth is     <?php echo $_POST["DateOfBirth"]; ?> <br>
        Your password is       <?php echo $_POST["pass_field"]; ?> <br>
        <br>
		<br>
		<p>Sign in <a href="Sign_in.php">Sign in</a>.</p>
        <br>
        <br>
        <a  href = ../../index.php><img src="../../assets/img/home-symbol.jpg" width="50px" /></a>
    </body>
</html>

