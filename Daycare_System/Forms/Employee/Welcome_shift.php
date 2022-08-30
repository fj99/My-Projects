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
            echo '<script>
            alert("Shift Successfully Created");
            </script>';  
            $status = "Shift Successfully Created"; 
        } 
        else
        {  
            echo "Failure! ".mysqli_error($conn);
        }
    }
    else
    {
        echo '<script>
        alert("Shift already exist");
        </script>';
        $status = "Shift already exist";
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
        <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/cosmo/bootstrap.min.css" rel="stylesheet" integrity="sha384-qdQEsAI45WFCO5QwXBelBe1rR9Nwiss4rGEqiszC+9olH1ScrLrMQr1KmDR964uZ" crossorigin="anonymous">
        <style>
            body{
                background-image: url("../../assets/img/background-forms.jpg");
                color: white;
                
            }
            
            .wrapper{ 
            width: 500px;
            padding: 20px; 
            }
            .wrapper h2 {text-align: center;}
            .wrapper form .form-group span {color: red;}
            .submit 
            {
                height: 35px; 
                width:75px; 
                font-size: 20px;
            }
            .end
            {
                padding-left: 20%;
            }
            .center {
                margin-left: auto;
                margin-right: auto;
            }
        </style>
    </head>

    <body>
        <section class="container wrapper">
            <a href = ../../index.php style="padding-left: 20%;"><img src="../../assets/img/navbar-logo.svg" width="300px" /></a>
            <br>
            <h2 class="display-4 pt-3">Welcome To our Daycare <?php echo$fname?> <?php echo $lname?> </h2>
            <br>
        
            <p class="text-center">
                Your shift date is <?php echo $shiftD?> <br>
                Your shift time start is <?php echo $shiftS?> <br>
                Your time worked is <?php echo $work?> <br>
                Your email address is  <?php echo$email?> <br>
                The Child's name is  <?php echo $First; ?> <?php echo $Last; ?> <br> 
                The Sex of your child is  <?php echo $Sex; ?> <br>
                Your Child's Date of Birth is     <?php echo $DateOfB; ?> <br>
            </p>
            <br>
            <p class="text-center"><?php echo $status?> </p>
            <br>
            <p class="text-center"><a href="../../Status.php">Status page:<img src="../../assets/img/status.png"></a></p>
        </section>
    </body>
</html>

