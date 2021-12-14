<?php

//connect to db
$conn = mysqli_connect('localhost', 'root', 'Pcsa0000', 'daycare');

?>

<html>
    <head>
        <meta charset="utf-8">
    </head>

    <body> 
        Welcome Employee Sign in:<br>
        <br>
        <form> 
            First Name: <input type="text" name = "FirstName" required><br>
            <br>

            Last Name: <input type="text" name = "LastName" required><br>
            <br>
            
            Password: <input type="text" name = "pass_field" required><br>
            <br>

            <input type="submit">            
        </form>
    </body>
</html>

<?php
$sql = "select EmployeeFirstName from employee where "

?>