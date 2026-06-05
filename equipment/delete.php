<a href="delete.php?id=<?php echo $row['id']; ?>">
Delete
</a>

<?php

include("../database/connection.php");

$id=$_GET['id'];

$sql="DELETE FROM equipment
WHERE id='$id'";

mysqli_query($conn,$sql);

header("Location:view.php");

?>