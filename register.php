<?php
// register.php
include("connection.php");
$status = "";

if (isset($_POST['register'])) {
    $name = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure hash

    if (!empty($name) && !empty($email) && !empty($_POST['password'])) {
        // Prepared statement validation against direct insertion
        $stmt = $conn->prepare("INSERT INTO users1 (fullname, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $hashed_password, $role);
        
        if ($stmt->execute()) {
            $status = "Registration Successful! <a href='login.php'>Login here</a>";
        } else {
            $status = "Error: Account might already exist.";
        }
        $stmt->close();
    } else {
        $status = "Fill out all fields completely.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register Account</title>
    <style>
        body { font-family: sans-serif; background: #eef1f5; display: flex; justify-content: center; margin-top: 100px; }
        .card { background: white; padding: 30px; border-radius: 4px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 320px; }
        input, select, button { width: 100%; padding: 10px; margin: 8px 0; box-sizing: border-box; }
    </style>
</head>
<body>
<div class="card">
    <h3>Create Account</h3>
    <p style="color:blue;"><?php echo $status; ?></p>
    <form method="POST">
        <input type="text" name="fullname" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role">
            <option value="Student">Student</option>
            <option value="Lecturer">Lecturer</option>
            <option value="Administrator">Administrator</option>
        </select>
        <button type="submit" name="register">Register</button>
    </form>
    <p style="font-size:13px;">Have an account? <a href="login.php">Login</a></p>
</div>
</body>
</html>