<?php
    //connect to db
    include '../../DB/connect_to_db.php';

    $db_name = 'Daycare';

    $conn = get_db_connection($db_name);

    //VARIABLES
    $First =  $_POST["ChildFirst"];
    $Last  =  $_POST["ChildLast"]; 
    $Sex    =  $_POST["sex"];
    $MD     =  $_POST["MD_record"];
    $DateOfB=  $_POST["DateOfBirth"];
    
    

    // Initialize sessions
    session_start();
    
    $id = $_SESSION["id"];
    $username = $_SESSION["username"];
    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname'];
    $email = $_SESSION['email'];

    $sql = "SELECT * FROM child WHERE childFirstName = '".$First."' AND childLastName = '".$Last."' AND child_Date_of_Birth = '".$DateOfB."' AND child_sex = '".$Sex."' AND ParentID = '".$id."' ";    

    if(!mysqli_num_rows(mysqli_query($conn, $sql)))
    {

        $sql = "INSERT INTO Child(childFirstName, childLastName, child_Date_of_Birth, child_sex, medicalRecord, ParentID) VALUES('".$First."', '".$Last."', '".$DateOfB."', '".$Sex."', '".$MD."', '".$id."' )";  
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
        Welcome To our Daycare  <?php echo$fname?> <?php echo $lname?> <br>
        Your email address is  <?php echo$email?> <br>
        The Child's name is  <?php echo $First; ?> <?php echo $Last; ?> <br> 
        The Sex of your child is  <?php echo $Sex; ?> <br>
        Your Child's Date of Birth is     <?php echo $DateOfB; ?> <br>
        <?php 
            if ($MD != NULL)
            {
                echo "Your child's Medical records are $MD";
            }
        ?>
        <a  href = ../../index.php><img src="../../assets/img/home-symbol.jpg" width="50px" /></a>
    </body>
</html>
