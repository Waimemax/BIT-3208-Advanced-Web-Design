<?php
// students.php
include("connection.php");

$message = "";
$update_mode = false;
$id = ""; $fullname = ""; $email = ""; $course = "";

// 1. CREATE & UPDATE Handler
if (isset($_POST['save_student'])) {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $course = trim($_POST['course']);
    $id = $_POST['student_id'];

    if (empty($fullname) || empty($email) || empty($course)) {
        $message = "All fields are required!";
    } else {
        if (!empty($id)) {
            // UPDATE Operation
            $stmt = $conn->prepare("UPDATE students SET fullname=?, email=?, course=? WHERE id=?");
            $stmt->bind_param("sssi", $fullname, $email, $course, $id);
            if ($stmt->execute()) $message = "Record Updated Successfully";
        } else {
            // CREATE Operation
            $stmt = $conn->prepare("INSERT INTO students (fullname, email, course) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $fullname, $email, $course);
            if ($stmt->execute()) $message = "Record Saved Successfully";
        }
        $stmt->close();
        // Reset form variables
        $id = ""; $fullname = ""; $email = ""; $course = "";
    }
}

// 2. DELETE Handler
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) $message = "Record Deleted Successfully";
    $stmt->close();
    header("Location: students.php");
    exit();
}

// 3. Fetch Student for Editing
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $update_mode = true;
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $fullname = $row['fullname'];
        $email = $row['email'];
        $course = $row['course'];
    }
    $stmt->close();
}

// 4. READ Operation (Fetch all rows)
$students_result = mysqli_query($conn, "SELECT * FROM students");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Management System</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f4f4f9; }
        .container { max-width: 900px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        form { margin-bottom: 30px; display: flex; gap: 10px; flex-wrap: wrap; }
        input, button { padding: 10px; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #007BFF; color: white; }
        .btn-del { color: red; text-decoration: none; margin-left: 10px; }
        .btn-edit { color: blue; text-decoration: none; }
        .alert { padding: 10px; background: #e1f5fe; color: #0288d1; margin-bottom: 15px; border-radius: 4px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Student Management System</h2>
    
    <?php if(!empty($message)) echo "<div class='alert'>$message</div>"; ?>

    <form method="POST" action="">
        <input type="hidden" name="student_id" value="<?php echo $id; ?>">
        <input type="text" name="fullname" placeholder="Full Name" value="<?php echo htmlspecialchars($fullname); ?>" required>
        <input type="email" name="email" placeholder="Email Address" value="<?php echo htmlspecialchars($email); ?>" required>
        <input type="text" name="course" placeholder="Course" value="<?php echo htmlspecialchars($course); ?>" required>
        <button type="submit" name="save_student"><?php echo $update_mode ? 'Update' : 'Save'; ?></button>
        <?php if($update_mode): ?>
            <a href="students.php" style="padding:10px; background:#ccc; text-decoration:none; color:black;">Cancel</a>
        <?php endif; ?>
    </form>

    <h3>Registered Students</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Full Name</th><th>Email</th><th>Course</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($students_result)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['course']); ?></td>
                <td>
                    <a class="btn-edit" href="students.php?edit=<?php echo $row['id']; ?>">Edit</a>
                    <a class="btn-del" href="students.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this record?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>