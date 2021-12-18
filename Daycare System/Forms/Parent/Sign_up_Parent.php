<?php
    // Initialize sessions
    session_start();

    // Check if the user is already logged in, if yes then redirect him to welcome page
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
    {
        
        if($_SESSION['parent'])
        {
            header("location: Update_Parent.php");
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
            <form class="form" action = welcome_Parent.php method="POST"> 
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
                            <input type="date" name = "DateOfBirth" required><br><br>
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
                                <input type="submit" class="submit" value = "submit" >
                            </td>
                        </td>
                    </tr>
                </table>          
            </form>          
        </section>
    </body>
</html>