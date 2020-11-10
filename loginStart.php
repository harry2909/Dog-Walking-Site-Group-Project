<?php
//clears all session variables and sends user to home page
session_start();
session_destroy();
header ('location: home.php');
?>