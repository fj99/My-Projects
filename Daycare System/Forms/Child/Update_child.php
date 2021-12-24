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
            $First = $_POST['FirstName'];
            $Last = $_POST['LastName'];
            $sex = $_POST['sex'];
            $DateB = $_POST['date'];
            $md = $_POST['MD'];
            $cname = $_POST['Cname'];
            
            //md is not updating
            /* $md = NUll;
            echo gettype($md);
            echo "<br>"; */

            if(strlen($md)>1)
            {
                $sql = "UPDATE child SET childFirstName = '".$First."', childLastName = '".$Last."', child_sex = '".$sex."', child_Date_of_Birth = '".$DateB."', medicalRecord = '".$md."' WHERE ParentID = '".$id."' AND childFirstName = '".$cname."'";
                echo $sql;
                $result=mysqli_query($conn, $sql);
            }
            else
            {
                $sql = "UPDATE child SET childFirstName = '".$First."', childLastName = '".$Last."', child_sex = '".$sex."', child_Date_of_Birth = '".$DateB."' WHERE ParentID = '".$id."' AND childFirstName = '".$cname."'";
                echo $sql;
                $result=mysqli_query($conn, $sql);
                //delete md so it becomes null

            }
            

        }

    if(isset($_POST['name']))
    {
        $cname = $_POST['cname'];
        $sql = "SELECT childFirstName, childLastName, child_sex, child_Date_of_Birth, medicalRecord FROM child WHERE ParentID = $id AND childFirstName = '".$cname."' ";
        //echo $sql;
        $result = mysqli_query($conn, $sql);
        $row = $result->fetch_assoc(); 

        $First = $row['childFirstName'];
        $Last = $row['childLastName'];
        $sex = $row['child_sex'];
        $DateB = $row['child_Date_of_Birth'];
        $md = $row['medicalRecord'];
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
            <p class="text-center">Welcome Parents Please fill this form to update your kids information.</p>
            <br>
            <h3 class="text-center">Your username is <?php echo $username; ?> </h3>
            <h3 class="text-center">Your email is <?php echo $email; ?> </h3><br>

            <form name = "name" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <label for="cname" style="font-size:20px;">Select which child you wish to update:</label><br>
                <select name="cname" style="font-size:20px;">
                    <?php    
                        $result=mysqli_query($conn,"SELECT childFirstName FROM child WHERE ParentID = $id "); 
                        While($row=mysqli_fetch_assoc($result))
                        {
                            ?>
                            <option value=<?php echo $row['childFirstName']?>><?php echo $row['childFirstName']?></option>;
                            <?php
                        }
                    ?> 
                </select>
                <input class="submit" name = "name" type="submit">            
            </form>
            
            <?php
            if(isset($_POST['name']))
            {
                ?>
                <br>
                <form name = "submit" action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="POST"> 
                    <table Border="0" class="center">
                        <tr>
                            <td>                                
                                Child's First Name: 
                            </td>
                            <td>
                                <input type="text" name = "FirstName" value = <?php echo $First;?>  ><br><br>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Child's Last Name: 
                            </td>
                            <td>
                                <input type="text" name = "LastName" value = <?php echo $Last;?> ><br><br>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Child's sex: 
                            </td>
                            <td>
                                <input type="text" name = "sex" value = <?php echo $sex;?> ><br><br>
                            </td>
                        </tr>
                        <tr>
                            <td>                                
                                Child's Date of Birth: 
                            </td>
                            <td>                            
                                <input type="date" name = "date" value = <?php echo $DateB;?> ><br><br>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Child's medical Record: 
                            </td>
                            <td>
                                <input type="file" name = "MD" value = <?php echo $md;?> ><br><br>
                            </td>
                        </tr>
                        <input type = "hidden" name = "Cname" value = <?php echo $_POST['cname']; ?>>
                        <tr>
                            <td>
                                <td class = "end">
                                    <input type="submit" class="submit" value = "submit" >
                                </td>
                            </td>
                        </tr>    
                    </table>                        
                </form>                                
                <?php
            }
            ?>            
        </section>
    </body>
</html>