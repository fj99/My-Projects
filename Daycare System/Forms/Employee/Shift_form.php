<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    //connect to db
    include '../../DB/connect_to_db.php';

    $db_name = 'Daycare';

    $conn = get_db_connection($db_name);
    
    // Initialize sessions
    session_start();

    // Check if the user is already logged in, if not then redirect him to welcome page
    if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true))
    {
        if(!isset($_SESSION['employee']))
        {      
            header("location: ../../index.html");
            exit;
        }
    }

    //session variables
    $id = $_SESSION["id"];
    $username = $_SESSION["username"];
    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname'];
    $email = $_SESSION['email'];

    //connect to child and select * from child get thye whole table then
    //make an update to write employee id into child's table
    //$sql = "SELECT * FROM child";


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
                
            }
            .center {
                margin-left: auto;
                margin-right: auto;
            }
        </style>
    </head>

    <body> 
        <section class="container wrapper">
            <a href = ../../index.php><img src="../../assets/img/navbar-logo.svg" width="300px" /></a> 
            <h2 class="display-4 pt-3">Welcome To our Daycare <?php echo $fname; ?> <?php echo $lname; ?> </h2>
            <p class="text-center">Welcome Employee Please fill this form to select your shift.</p>
            <br>
            <form action = welcome_shift.php  method="POST"> 
                <table Border="0" class="center">
                    <tr>
                        <td>
                            Username <br><br>
                        </td>
                        <td>
                            <?php echo $_SESSION["username"];?>  <br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Shift Date: <br><br>
                        </td>
                        <td>
                            <input type="date" name = "Shift_Date" required><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>                            
                            Shift Time Start: <br><br>
                        </td>
                        <td>
                            <input type="time" name = "Shift_time_Start" required><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Shift Time End: <br><br>
                        </td>
                        <td>
                            <input type="time" name = "Shift_time_End" required><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="child">Choose a child:</label> <br><br>
                        </td>
                        <td>
                            <select name="child" >
                            <?php 
                            $result=mysqli_query($conn,'SELECT childID, childFirstName FROM child'); 
                            while($row=mysqli_fetch_assoc($result)) 
                                { ?>                    
                                    <option value= <?php echo $row['childID']?> ><?php echo $row['childFirstName']?></option>                                     
                                <?php
                                }?>          
                            </select> <br><br>
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
            <br>
            <button onclick="location.href='Update_shift'" type="button">
            click here to update</button>
        </section>
    </body>
</html>

