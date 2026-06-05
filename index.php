<?php

include("database/connection.php");

if(isset($_POST['name'])){

$name = $_POST['name'];
$hospital = $_POST['hospital'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];

$sql = "INSERT INTO requests
(name,hospital,email,phone,message)
VALUES
('$name','$hospital','$email','$phone','$message')";

mysqli_query($conn,$sql);

echo "Request Submitted Successfully";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Human Matrix</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<h2>Contact Human Matrix</h2>

<form method="POST">

Name:
<input type="text" name="name">

<br><br>

Hospital:
<input type="text" name="hospital">

<br><br>

Email:
<input type="email" name="email">

<br><br>

Phone:
<input type="text" name="phone">

<br><br>

Message:
<textarea name="message"></textarea>

<br><br>

<button type="submit">
Send Request
</button>

</form>

</body>
</html>