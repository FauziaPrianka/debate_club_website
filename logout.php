<?php
session_start();
session_unset();   // remove all session variables
session_destroy(); // destroy session completely
header("Location: login.php"); // redirect to login page
exit();
?>
