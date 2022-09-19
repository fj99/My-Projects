<?php
	// Start sessions
	session_start();

	$_SESSION  = array();

	// Destroy all session related to user
	session_destroy();

	// Redirect to home page
	header('location: index.php');
	exit;
