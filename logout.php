<?php
// logout.php
session_start();
session_unset(); 
session_destroy(); // Clear server state context entirely
header("Location: login.php"); // Clear redirection to initial access gateway
exit();
?>