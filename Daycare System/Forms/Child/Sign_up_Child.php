<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    //connect to db
    include '../../DB/connect_to_db.php';
    
    // Initialize sessions
    session_start();

    // Check if the user is already logged in, if not then redirect him to welcome page
    if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true))
    {   
        header("location: ../../index.html");
        exit;
    }
    if(isset($_SESSION['employee'])&& $_SESSION['employee'] === true)
    {      
        header("location: ../Employee/Shift_form.php");
        exit;
    }
    
    //session variables
    $id = $_SESSION["id"];
    $username = $_SESSION["username"];
    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname'];
    $email = $_SESSION['email'];
    
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
            .wrapper a{
                padding-left: 20%;
            }
            .wrapper{ 
            width: 500px; 
            padding: 20px; 
            }
            .wrapper h2 {text-align: center;}
            .wrapper form .form-group span {color: red;}
            .submit 
            {
                -moz-box-sizing: border-box; /* Firefox, other Gecko */
                height: 35px; 
                width:75px; 
                font-size: 20px;
            }
            .end
            {
                padding-left: 20%;
            }
        </style>
    </head>

    <body> 
        <section class="container wrapper">
            <a href = ../../index.php><img src="../../assets/img/navbar-logo.svg" width="300px" /></a>
            <h2 class="display-4 pt-3"> Sign up:</h2>
            <p class="text-center">Welcome Parents Please fill this form to create an account.</p>
            <br>
            <form action = welcome_Child.php method="POST">   

                Your email <?php echo$email?><br>
                <br>

                First Name of the Child <input type="text" name = "ChildFirst" required><br>
                <br>

                Last Name of the Child <input type="text" name = "ChildLast" required><br>
                <br>   
                
                What is the sex of the child <input type="text" name = "sex" required><br>
                <br>

                Medical record of the child <input type="file" name = "MD_record"> <br>
                <br>

                Date of Birth of the Child <input type="date" name = "DateOfBirth" required><br>
                <br>
            
                <input type="submit">            
            </form>
        
            <button onclick="location.href='Update_child'" type="button">
            click here to update</button> 
            
        </section>
    </body>
</html>
