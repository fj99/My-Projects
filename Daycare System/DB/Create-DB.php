<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

include 'connect_to_db.php';

$conn = get_db_connection();

// Create database
$db_name = "daycare";
$sql = "CREATE DATABASE $db_name ";
if(mysqli_query($conn, $sql) === TRUE) 
{
    echo "Database '$db_name' created successfully";
} else {
    echo "Error creating database: " . mysqli_error($conn);
}

$conn->close();


?>