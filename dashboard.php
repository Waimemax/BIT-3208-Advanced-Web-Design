<?php

session_start();

if(!isset($_SESSION['user'])){

header("Location: login.php");

}

?>

<h1>Human Matrix Dashboard</h1>

<a href="equipment/view.php">
Equipment
</a>

<a href="customers/view.php">
Customers
</a>

<a href="logout.php">
Logout
</a>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h1>Human Matrix Dashboard</h1>

</body>
</html>