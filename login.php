<?php

session_start();

include("database/connection.php");

if(isset($_POST['username'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users
            WHERE username='$username'
            AND password='$password'";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){

        $_SESSION['user'] = $username;

        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<link rel="stylesheet" href="css/style.css">
<body>

<h2>Human Matrix Login</h2>

<?php
if(isset($error)){
    echo "<p>$error</p>";
}
?>

<form method="POST">

    <input type="text" name="username" placeholder="Username" required>

    <br><br>

    <input type="password" name="password" placeholder="Password" required>

    <br><br>

    <button type="submit">Login</button>

</form>

</body>
</html>