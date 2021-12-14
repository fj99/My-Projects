<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    //connect to db
    //$conn = mysqli_connect('localhost', 'root', 'Pcsa0000', 'daycare');
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
    <link rel="stylesheet" href="style.css">
        <meta charset="utf-8">
    </head>

    <body> 
       <h2> Parents Sign up your kids below:</h2><br>
        <br>
        Welcome <?php echo$fname?> <?php echo $lname?>
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
        &nbsp;
        <a  href = ../../index.php><img src="../../assets/img/home-symbol.jpg" width="50px" /></a>
    </body>
</html>
