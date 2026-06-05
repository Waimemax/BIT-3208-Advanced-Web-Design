<?php

include("../database/connection.php");

$result = mysqli_query(
$conn,
"SELECT * FROM customers"
);

?>

<table border="1">

<tr>
<th>ID</th>
<th>Customer</th>
<th>Hospital</th>
<th>Email</th>
<th>Phone</th>
<th>Actions</th>
</tr>

<?php

while($row = mysqli_fetch_assoc($result)){

?>

<tr>

<td><?php echo $row['id']; ?></td>
<td><?php echo $row['customer_name']; ?></td>
<td><?php echo $row['hospital_name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['phone']; ?></td>

<td>

<a href="edit.php?id=<?php echo $row['id']; ?>">
Edit
</a>

|

<a href="delete.php?id=<?php echo $row['id']; ?>">
Delete
</a>

</td>

</tr>

<?php
}
?>

</table>