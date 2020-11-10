<?php
//deletes all session variables
session_start();
session_destroy();
//user is taken back the login page
header('location:./login.php')
?>