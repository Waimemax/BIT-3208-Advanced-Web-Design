<?php
// library.php
include("connection.php");

$msg = "";
$b_id = ""; $b_title = ""; $b_author = ""; $b_category = "";
$edit_state = false;

if (isset($_POST['action'])) {
    $b_title = trim($_POST['title']);
    $b_author = trim($_POST['author']);
    $b_category = trim($_POST['category']);
    $b_id = $_POST['id'];

    if ($_POST['action'] == "save") {
        $stmt = $conn->prepare("INSERT INTO books (title, author, category) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $b_title, $b_author, $b_category);
        if ($stmt->execute()) $msg = "Book Added Successfully!";
        $stmt->close();
    } elseif ($_POST['action'] == "update") {
        $stmt = $conn->prepare("UPDATE books SET title=?, author=?, category=? WHERE id=?");
        $stmt->bind_param("sssi", $b_title, $b_author, $b_category, $b_id);
        if ($stmt->execute()) $msg = "Book Updated Successfully!";
        $stmt->close();
    }
    // Flush variables
    $b_id = ""; $b_title = ""; $b_author = ""; $b_category = "";
}

if (isset($_GET['del'])) {
    $del_id = intval($_GET['del']);
    $stmt = $conn->prepare("DELETE FROM books WHERE id=?");
    $stmt->bind_param("i", $del_id);
    if ($stmt->execute()) $msg = "Book Removed!";
    $stmt->close();
}

if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $edit_state = true;
    $stmt = $conn->prepare("SELECT * FROM books WHERE id=?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($r = $res->fetch_assoc()) {
        $b_id = $r['id'];
        $b_title = $r['title'];
        $b_author = $r['author'];
        $b_category = $r['category'];
    }
    $stmt->close();
}

$all_books = mysqli_query($conn, "SELECT * FROM books");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Library Management System</title>
    <style>
        body { font-family: Segoe UI, sans-serif; background: #fafafa; margin: 40px; }
        .box { background: #fff; padding: 25px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); max-width: 850px; margin: auto; }
        input, select, button { padding: 8px; margin: 5px 0; width: 100%; box-sizing: border-box; }
        .grid-form { display: grid; grid-template-columns: repeat(4, 1fr) 100px; gap: 10px; align-items: end; }
        table { width: 100%; border-collapse: collapse; margin-top: 25px; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background: #343a40; color: #fff; }
    </style>
</head>
<body>
<div class="box">
    <h2>Library Book Catalog</h2>
    <?php if(!empty($msg)) echo "<p style='color:green;'><b>$msg</b></p>"; ?>

    <form method="POST" action="library.php" class="grid-form">
        <input type="hidden" name="id" value="<?php echo $b_id; ?>">
        <div>
            <label>Title</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($b_title); ?>" required>
        </div>
        <div>
            <label>Author</label>
            <input type="text" name="author" value="<?php echo htmlspecialchars($b_author); ?>" required>
        </div>
        <div>
            <label>Category</label>
            <select name="category">
                <option value="Fiction" <?php if($b_category=='Fiction') echo 'selected'; ?>>Fiction</option>
                <option value="Computing" <?php if($b_category=='Computing') echo 'selected'; ?>>Computing</option>
                <option value="Engineering" <?php if($b_category=='Engineering') echo 'selected'; ?>>Engineering</option>
                <option value="Mathematics" <?php if($b_category=='Mathematics') echo 'selected'; ?>>Mathematics</option>
            </select>
        </div>
        <div>
            <button type="submit" name="action" value="<?php echo $edit_state ? 'update' : 'save'; ?>">
                <?php echo $edit_state ? 'Modify' : 'Add Book'; ?>
            </button>
        </div>
    </form>

    <table>
        <tr><th>ID</th><th>Book Title</th><th>Author</th><th>Category</th><th>Actions</th></tr>
        <?php while($row = mysqli_fetch_assoc($all_books)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['author']); ?></td>
            <td><?php echo htmlspecialchars($row['category']); ?></td>
            <td>
                <a href="library.php?edit=<?php echo $row['id']; ?>">Edit</a> | 
                <a href="library.php?del=<?php echo $row['id']; ?>" style="color:red;" onclick="return confirm('Remove book entry?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>