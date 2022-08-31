<?php
include '../../DB/connect_to_db.php';

$db_name = 'daycare';

$conn = get_db_connection($db_name);

// Initialize sessions
session_start();
$id = $_SESSION['id'];
$username = $_SESSION['username'];

// Check if the user is already logged in, if yes then redirect him to welcome page
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)) {
    header("location: ../../index.php");
    exit;
}

if (isset($_POST['submit'])) {
    $fname = $_POST['FirstName'];
    $lname = $_POST['LastName'];
    $email = $_POST['email'];
    $DateB = $_POST['DateOfBirth'];
    $pssd = $_POST['pass_field'];

    $sql = "UPDATE parent SET EmployeeFirstName = $fname, EmployeeLastName = $lname, Employee_Email = $email, Employee_Date_of_Birth = $DateB, Employee_Password = $pssd WHERE EmployeeID = $id AND username = $username ";
    //echo $sql;
    $result = mysqli_query($conn, $sql);

    $_SESSION['fname'] = $fname;
    $_SESSION['lname'] = $lname;
    $_SESSION['email'] = $email;
    $Date = $DateB;
    $Pss = $pssd;
} else {
    $sql2 = "SELECT Employee_Date_of_Birth, Employee_Password FROM employee WHERE EmployeeID = $id AND username = '" . $username . "' ";
    $result2 = mysqli_query($conn, $sql2);
    $row = $result2->fetch_assoc();
    $Date = $row["Employee_Date_of_Birth"];
    $Pss = $row["Employee_Password"];
}

//session var
$fname = $_SESSION['fname'];
$lname = $_SESSION['lname'];
$email = $_SESSION['email'];


?>

<html>

<head>
    <meta charset="utf-8">
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/cosmo/bootstrap.min.css" rel="stylesheet" integrity="sha384-qdQEsAI45WFCO5QwXBelBe1rR9Nwiss4rGEqiszC+9olH1ScrLrMQr1KmDR964uZ" crossorigin="anonymous">
    <style>
        body {
            background-image: url("../../assets/img/background-forms.jpg");
            color: white;
        }

        .wrapper a {
            padding-left: 20%;
        }

        .wrapper {
            width: 500px;
            padding: 20px;
        }

        .wrapper h2 {
            text-align: center;
        }

        .wrapper form .form-group span {
            color: red;
        }

        .submit {
            -moz-box-sizing: border-box;
            /* Firefox, other Gecko */
            height: 35px;
            width: 75px;
            font-size: 20px;
        }

        .end {}

        .center {
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body>
    <section class="container wrapper">
        <a href=../../index.php><img src="../../assets/img/navbar-logo.svg" width="300px" /></a>
        <h2 class="display-4 pt-3">Welcome To our Daycare <?php echo $fname; ?> <?php echo $lname; ?> </h2>
        <p class="text-center">Welcome Employee Please fill this form to update your information.</p>

        <h3 class="text-center">Your Username is <?php echo $username; ?> </h3>
        <h3 class="text-center">Your email is <?php echo $email; ?> </h3>
        <h3 class="text-center">Your date of birth is <?php echo $Date; ?> </h3>
        <h3 class="text-center">Your Password is <?php echo $Pss; ?> </h3><br>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <table Border="0" class="center">
                <tr>
                    <td>
                        First Name: <br><br>
                    </td>
                    <td>
                        <input type="text" name="FirstName" value=<?php echo $fname; ?>> <br><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        Last Name: <br><br>
                    </td>
                    <td>
                        <input type="text" name="LastName" value=<?php echo $lname; ?>><br><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        E-mail: <br><br>
                    </td>
                    <td>
                        <input type="email" name="email" value=<?php echo $email; ?>><br><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        Date of Birth: <br><br>
                    </td>
                    <td>
                        <input type="date" name="DateOfBirth" value=<?php echo $Date; ?>><br><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        Password: <br><br>
                    </td>
                    <td>
                        <input type="text" name="pass_field" value=<?php echo $Pss; ?>><br><br>
                    </td>
                </tr>
                <tr>
                    <td>
                    <td class="end">
                        <input type="submit" class="submit" value="submit">
                    </td>
                    </td>
                </tr>
            </table>
        </form>
    </section>
</body>

</html>