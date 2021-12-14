<?php
    // Initialize sessions
    session_start();

    // Check if the user is already logged in, if yes then redirect him to welcome page
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
    {
        
        if($_SESSION['employee'])
        {
            header("location: Update_employee.php");
            exit;          
        }
        else
        {
            header("location: ../../index.html");
            exit;           
        }
    }
    
?>
<html>
    <head>
    <link rel="stylesheet" href="style.css">
        <meta charset="utf-8">
    </head>

    <body> 
       <h2> Welcome Employee Please Sign up:</h2><br>
        <br>
        <form action = welcome_Employee.php method="POST"> 

            Username : <input type="text" name = "username" required><br>
            <br>

            First Name: <input type="text" name = "FirstName" required><br>
            <br>

            Last Name: <input type="text" name = "LastName" required><br>
            <br>
            
            Phone number: <input type="tel" name="phone" maxlength="10" required><br>
            <br>

            E-mail: <input type="email" name = "email" required><br>
            <br>

            Address: <input type="text" name="addy" required><br>
            <br>

            Date of Birth: <input type="date" name = "DateOfBirth" required><br>
            <br>
            
            Password: <input type="text" name = "pass_field" required><br>
            <br>

            <input type="submit">            
        </form> 
        <br>
        <br>
        <a  href = ../../index.php><img src="../../assets/img/home-symbol.jpg" width="50px" /></a>
    </body>
</html>