<?php
include 'db_user_pass.php';

function get_db_connection($db_name ="mysql")
{
	// Create connection. Either include globally and use $GLOBALS['variable_name'], or include locally
	$conn = @new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $db_name);
	//$connection = @new mysqli_connect('localhost', 'root', 'password', 'daycare');
	//$conn = mysqli_connect('localhost', 'root', '', 'daycare');
	

	// Check connection
	if ($conn->connect_error) 
	{
		die("Connection failed: " . $conn->connect_error);
	}
	
	return $conn;
}
?>