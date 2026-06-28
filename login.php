<?php
// login.php
session_start(); // Starts tracking sessions
include("connection.php");
$error = "";

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users1 WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify hash signatures match securely
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_name'] = $user['fullname'];
        $_SESSION['user_role'] = $user['role']; // Store role matrix explicitly
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid combination credentials.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Gate</title>
    <style>
        body { font-family: sans-serif; background: #eef1f5; display: flex; justify-content: center; margin-top: 100px; }
        .card { background: white; padding: 30px; border-radius: 4px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 320px; }
        input, button { width: 100%; padding: 10px; margin: 8px 0; box-sizing: border-box; }
    </style>
</head>
<body>
<div class="card">
    <h3>Sign In</h3>
    <?php if(!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Log In</button>
    </form>
    <p style="font-size:13px;">Need an account? <a href="register.php">Register</a></p>
</div>
</body>
</html>