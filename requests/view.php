<?php

include("../database/connection.php");

$result = mysqli_query(
$conn,
"SELECT * FROM requests
ORDER BY created_at DESC"
);

?>

<table border="1">

<tr>
<th>Name</th>
<th>Hospital</th>
<th>Email</th>
<th>Phone</th>
<th>Message</th>
<th>Date</th>
</tr>

<?php

while($row = mysqli_fetch_assoc($result)){

?>

<tr>

<td><?php echo $row['name']; ?></td>

<td><?php echo $row['hospital']; ?></td>

<td><?php echo $row['email']; ?></td>

<td><?php echo $row['phone']; ?></td>

<td><?php echo $row['message']; ?></td>

<td><?php echo $row['created_at']; ?></td>

</tr>

<?php
}
?>

</table>