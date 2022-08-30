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
    $Email    = $_POST["email"];
    $DateOfB  = $_POST["DateOfBirth"];
    $Pssd     = $_POST["pass_field"];            
    
    
    $sql = "SELECT * FROM parent WHERE username = '".$username."' ";

    if(!mysqli_num_rows(mysqli_query($conn, $sql)))
    {
        $sql = "INSERT INTO Parent(username, ParentFirstName, ParentLastName, Parent_email, Parent_Date_of_Birth, Parent_Password) VALUES( '".$username."', '".$First."', '".$Last."', '".$Email."', '".$DateOfB."', '".$Pssd."' )";
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
            <h2 class="display-4 pt-3">Welcome To our Daycare <?php echo $_POST["FirstName"]; ?> <?php echo $_POST["LastName"]; ?> </h2>
            <br>

            <p class="text-center">
                Your username is <?php echo $_POST["username"]; ?> <br>
                Your email address is  <?php echo $_POST["email"]; ?> <br>
                Your Date of Birth is     <?php echo $_POST["DateOfBirth"]; ?> <br>
                Your password is       <?php echo $_POST["pass_field"]; ?> <br>
            </p>
            <br>
            <p class="text-center"><?php echo $status?> </p>
            <br>
            <p class="text-center"><a href="Sign_in.php" >Sign in:<img src="../../assets/img/sign_in.png"></a></p>
        </section>
    </body>
</html>
