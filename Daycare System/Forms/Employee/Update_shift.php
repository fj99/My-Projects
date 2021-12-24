<?php
    include '../../DB/connect_to_db.php';

    $db_name = 'daycare';

    $conn = get_db_connection($db_name);

    // Initialize sessions
    session_start();
    //session var
    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname'];
    $email = $_SESSION['email']; 
    $id = $_SESSION['id'];
    $username = $_SESSION['username'];

    // Check if the user is already logged in, if yes then redirect him to welcome page
    if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true))
    {
        header("location: ../../index.html");
        exit;       
    }

    if(isset($_POST['submit']))
    { 
        $date = $_POST["Date"];
        $start = $_POST["Start"];
        $work = $_POST["work"];
        $child  = $_POST["child"]; 
        
        $sql = "UPDATE Shift_Schedule SET Shift_Date = $date, Shift_time = $start, MinutesWorked = $work WHERE EmployeeID = $id ";
        echo $sql;
        $result=mysqli_query($conn, $sql);

        $sql2 = "UPDATE child SET EmployeeID = $id WHERE childID = $child";
        $result2=mysqli_query($conn, $sql2);
    }
    else
    {
        $sql = "SELECT Shift_Date, Shift_time, MinutesWorked FROM Shift_Schedule WHERE EmployeeID = $id ";
        $result = mysqli_query($conn, $sql);
        $row = $result->fetch_assoc(); 
        $date = $row["Shift_Date"];
        $start = $row["Shift_time"];
        $work = $row["MinutesWorked"];
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

            <h3 class="text-center">Your Username is <?php echo $username; ?> </h3>
            <h3 class="text-center">Your email is <?php echo $email; ?> </h3>
            <br>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="POST"> 
                <table Border="0" class="center">
                    <tr>
                        <td>
                            Shift Date: <br><br>
                        </td>
                        <td>
                            <input type="date" name = "Date" value = <?php echo $date; ?>><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Shift Time Start: <br><br>
                        </td>
                        <td>                    
                            <input type="time" name = "Start" value = <?php echo $start; ?>> <br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Time worked: <br><br>
                        </td>
                        <td>
                            <input type="time" name = "work" value = <?php echo $work; ?>> <br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>                            
                            <label for="Yourchild">Your children:</label> <br><br>
                        </td>
                        <td>
                            <select name="Yourchild" >
                            <?php 
                            $result=mysqli_query($conn,"SELECT childID, childFirstName FROM child WHERE EmployeeID = $id"); 
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
                            <label for="child">Choose a child:</label> <br><br>
                        </td>
                        <td>
                            <select name="child" >
                            <?php 
                            $result=mysqli_query($conn,"SELECT childID, childFirstName FROM child"); 
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
        </section>
    </body>
</html>

