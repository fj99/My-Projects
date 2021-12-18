<?php
    // Initialize sessions
    session_start();

    // Check if the user is already logged in, if yes then redirect him to welcome page
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
    {
        //if user is an employee redirect otherwise send them home
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
            <p class="text-center">Welcome Employees Please fill this form to create an account.</p>
            <br>
            <form action = welcome_Employee.php method="POST"> 
                <table Border="0">
                    <tr>
                        <td>
                            Username : <br><br>
                        </td>
                        <td>
                            <input type="text" name = "username" required><br><br>
                        </td>                        
                    </tr>
                    <tr>
                        <td>
                            First Name: <br><br>
                        </td>
                        <td>
                            <input type="text" name = "FirstName" required><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Last Name: <br><br>
                        </td>
                        <td>    
                            <input type="text" name = "LastName" required><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Address: <br><br>
                        </td> 
                        <td>
                            <input type="text" name="addy" required><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Phone Number: <br><br>
                        </td>
                        <td>
                            <!-- <input name="prim1" type="text" id="prim1" size = "2" maxlength= "3" required>-
                            <input name="prim2" type="text" id="prim2" size = "2" maxlength= "3" required>-
                            <input name="prim3" type="text" id="prim3" size = "3" maxlength= "4" required>                            
                            <input type="hidden" name="phone" value = "'prim1'+'prim2'+'prim3'"> -->
                            <input type="tel" name="phone" maxlength="10" required> <br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            E-mail: <br><br>
                        </td>
                        <td>
                            <input type="email" name = "email" required><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Date of Birth: <br><br>
                        </td>
                        <td>
                            <input type="date" name = "DateOfBirth" style="font-size:20px; padding-left: 12%;" required><br><br>
                        </td>
                    </tr> 
                    <tr>
                        <td>
                            Password: <br><br>
                        </td> 
                        <td>
                            <input type="text" name = "pass_field" required><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <td class = "end">
                                <input type="submit" class="submit" value = "Submit" >
                            </td>
                        </td>
                    </tr>
                </table> 
            </form>
        </section>
    </body>
</html>