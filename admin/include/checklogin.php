<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: //" . $_SERVER['HTTP_HOST'] ."/obe/admin/index.php");
    exit;
}
?>
