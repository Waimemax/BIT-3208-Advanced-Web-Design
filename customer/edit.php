$id = $_GET['id'];

$result = mysqli_query(
$conn,
"SELECT * FROM customers WHERE id='$id'"
);

$row = mysqli_fetch_assoc($result);