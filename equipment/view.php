<?php

include("../database/connection.php");

$sql="SELECT * FROM equipment";

$result=mysqli_query($conn,$sql);

?>