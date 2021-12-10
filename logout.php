<?php
  //start session
	session_start();
	
	//this affects the content of the $_SESSION variable(s)
	$_SESSION['validUser'] = "";
  $_SESSION['loginErrorMessage']="";
	$_SESSION['error']="";
	$_SESSION['success']="";
	unset($_SESSION['validUser']);
  unset($_SESSION['loginErrorMessage']);
	unset($_SESSION['error']);
	unset($_SESSION['success']);	
  //destroys the current session and all related session info
	session_destroy();
  //redirects the sign on page or home page
	header("Location: login.php");		

?>