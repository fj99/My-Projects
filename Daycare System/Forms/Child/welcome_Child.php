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
            echo '<script>
            alert("Account Successfully Created");
            </script>';  
            $status = "Account Successfully Created";  
        } 
        else
        {  
            echo "Failure! ".mysqli_error($conn);
        }
    }
    else
    {
        echo '<script>
        alert("Account already exist");
        </script>';
        $status = "Account already exist";
    }    
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
            </p>
            <br>
            <p class="text-center"><?php echo $status?> </p>
            <br>
            <p class="text-center"><a href="Sign_in.php" >Sign in:<img src="../../assets/img/sign_in.png"></a></p>
        </section>
    </body>
</html>
