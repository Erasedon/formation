<?php
// Initialize the session
session_start();

unset($_SESSION['id']); 
 
// Unset all of the session variables

 
// Destroy the session.
// session_destroy($_SESSION['id']);
 
// Redirect to login page
header("location: page-login-dashboard-frontend.php");
exit;
?>