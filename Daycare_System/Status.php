<?php
    //connect to db
    include 'DB/connect_to_db.php';  

    $db_name = 'Daycare';

    $conn = get_db_connection($db_name);

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    // Initialize sessions
    session_start();

    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
    {
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
                        background-image: url("assets/img/background-forms.jpg");
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
                <body>
                    <section class="container wrapper">
                        <a href = index.php style="padding-left: 20%;"><img src="assets/img/navbar-logo.svg" width="300px" /></a>
                        <br>
                        <h2 class="display-4 pt-3">Welcome To our Daycare <?php echo $fname," ", $lname;?> </h2>
                        <br>
                        <p class="text-center" style = "font-size:18px;">
                            your username is <?php echo $username;?> <br>
                            your email is <?php echo $email ?> <br>    
        <?php
        if($_SESSION['employee'])
        {
            //Employee table            
            $sql = "SELECT Employee_phoneNumber, Employee_Address, Position, Employee_Date_of_Birth, Employee_Password FROM employee WHERE EmployeeID = '".$id."' AND username =  '".$username."'";
            $result = mysqli_query($conn, $sql);            
            $row = mysqli_fetch_assoc($result);
            
            //shift table
            $sql2 = "SELECT Shift_Date, Shift_time, MinutesWorked FROM Shift_Schedule WHERE EmployeeID = $id";
            $result2 = $conn->query($sql2);
            
            //child table
            $sql3 = "SELECT childID, childFirstName, childLastName FROM child WHERE EmployeeID = $id";
            $result3 = $conn->query($sql3);


            ?>              
                            your phone number is <?php echo $row["Employee_phoneNumber"];?> <br>
                            your address is <?php echo $row["Employee_Address"];?> <br>
                            your position is <?php echo $row["Position"];?> <br>
                            your date of birth is <?php echo $row["Employee_Date_of_Birth"];?> <br>
                            <label for="shift">This is your shift information:<br>(Shift Date/ Shift time/ minutes worked) </label>
                            <select name="shift" >
                            <?php 
                                While($row2=mysqli_fetch_assoc($result2))
                                {
                                    ?>
                                    <option value=shift><?php echo $row2["Shift_Date"],"/",$row2["Shift_time"],"/",$row2["MinutesWorked"];?> </option>;
                                    <?php 
                                } 
                            ?>
                            </select> <br> 
                            <form name= "child"  method="POST"> 
                                <p class="text-center" style = "font-size:18px;">                    
                                    <label for="child">Please select your child their inforamtion will be displayed:<br> </label>
                                    <select name="child" >
                                        <?php 
                                        While($row3=mysqli_fetch_assoc($result3))
                                        {
                                            ?>
                                            <option value=<?php echo $row3["childID"]?>><?php echo $row3["childFirstName"]," ",$row3["childLastName"];?> </option>;
                                            <?php 
                                        } 
                                        ?>
                                    </select> <br>
                                    <input type="submit" class="submit" value = "submit">
                                </p>                                
                            </form> <br>
                            <?php
                                if(isset($_POST['child']))
                                {   //child info
                                    $childID = $_POST['child']; 
                                    $sql4 = "SELECT childFirstName, childLastName, child_sex, medicalRecord, child_Date_of_Birth, ParentID FROM child WHERE childID = $childID";
                                    $result4 = $conn->query($sql4); 
                                    $row4=mysqli_fetch_assoc($result4);
                                    //parent info
                                    $ParlID = $row4['ParentID'];
                                    $sql5 = "SELECT ParentFirstName, ParentLastName, Parent_email FROM Parent WHERE ParentID = $ParlID";
                                    $result5 = $conn->query($sql5);
                                    $row5 = mysqli_fetch_assoc($result5);
                                    ?>
                                    <p class="text-center" style = "font-size:18px;">  
                                        Information for <?php echo $row4["childFirstName"]," ",$row4["childLastName"]," is:";?> <br>
                                        child's sex is: <?php echo $row4["child_sex"];?> <br>
                                        child's date of birth is: <?php echo $row4["child_Date_of_Birth"];?> <br>
                                        child's medaical record is: <?php echo $row4["medicalRecord"];?> <br> 
                                        <br>
                                        parent information in charge of child: <br>
                                        parent name is <?php echo $row5["ParentFirstName"]," ",$row5["ParentLastName"];?> <br>
                                        parent email is <?php echo $row5["Parent_email"];?> <br>                                        
                                    </p>
                                    <?php                    
                                } 
                            ?>
                        <p class="text-center" style = "font-size:18px;"> 
                            your password is <?php echo $row["Employee_Password"];?> <br>
                        </p>
                    </section>
                </body>
            </html>
            <?php
        }
        elseif($_SESSION['parent'])
        {
            //parent table
            $sql = "SELECT Parent_Date_of_Birth, Parent_Password FROM Parent WHERE ParentID = $id";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();

            //child table
            $sql2 = "SELECT childID, childFirstName, childLastName FROM child WHERE ParentID = $id";
            $result2 = $conn->query($sql2);
            ?>
                            Here will go Parent info: <br>                                                    
                            your date of birth is <?php echo $row["Parent_Date_of_Birth"];?> <br>
                            <form name= "child"  method="POST"> 
                                <p class="text-center" style = "font-size:18px;">                    
                                    <label for="child">Please select your child their inforamtion will be displayed:<br> </label>
                                    <select name="child" >
                                        <?php 
                                        While($row2=mysqli_fetch_assoc($result2))
                                        {
                                            ?>
                                            <option value=<?php echo $row2["childID"]?>><?php echo $row2["childFirstName"]," ",$row2["childLastName"];?> </option>;
                                            <?php 
                                        } 
                                        ?>
                                    </select> <br>
                                    <input type="submit" class="submit" value = "submit">
                                </p>                                
                            </form> <br>
                            <?php
                                if(isset($_POST['child']))
                                {   //child info
                                    $childID = $_POST['child']; 
                                    $sql3 = "SELECT childFirstName, childLastName, child_sex, medicalRecord, child_Date_of_Birth, EmployeeID FROM child WHERE childID = $childID";
                                    $result3 = $conn->query($sql3); 
                                    $row3 = mysqli_fetch_assoc($result3);
                                    //check if there is employee info
                                    

                                    //employee info                                
                                    $EmplID = $row3['EmployeeID'];
                                    $sql4 = "SELECT EmployeeFirstName, EmployeeLastName, Employee_phoneNumber, Employee_Email FROM employee WHERE EmployeeID = $EmplID";
                                    $result4 = $conn->query($sql4);
                                    $row4 = mysqli_fetch_assoc($result4);
                                    ?>
                                    <p class="text-center" style = "font-size:18px;">  
                                        Information for <?php echo $row3["childFirstName"]," ",$row3["childLastName"]," is:";?> <br>
                                        child's sex is: <?php echo $row3["child_sex"];?> <br>
                                        child's date of birth is: <?php echo $row3["child_Date_of_Birth"];?> <br>
                                        child's medaical record is: <?php echo $row3["medicalRecord"];?> <br>
                                        <br>
                                        employee information in charge of child: <br>
                                        employee name is <?php echo $row4["EmployeeFirstName"]," ",$row4["EmployeeLastName"];?> <br>
                                        employee phone number is <?php echo $row4["Employee_phoneNumber"];?> <br>
                                        employee email is <?php echo $row4["Employee_Email"];?> <br>                                    
                                    </p>
                                    <?php                    
                                } 
                            ?>
                        <p class="text-center" style = "font-size:18px;">  
                            your password is <?php echo $row["Parent_Password"];?> <br>
                        </p>
                    </section>
                </body>
            </html>
            <?php
                      
        }
    }
    else
    {
        echo "<script>
        alert('Your not signed in redirecting to home');
        </script>";
        
        header("refresh:0; url = http://localhost:8080/My-Projects/Daycare%20System/index.php"); 
        
    }

?>