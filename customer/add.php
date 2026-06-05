<?php

include("../database/connection.php");

if(isset($_POST['customer_name'])){

$customer_name = $_POST['customer_name'];
$hospital_name = $_POST['hospital_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];

$sql = "INSERT INTO customers
(customer_name,hospital_name,email,phone,address)
VALUES
('$customer_name','$hospital_name','$email','$phone','$address')";

mysqli_query($conn,$sql);

echo "Customer Added Successfully";

}
?>

<form method="POST">

Customer Name:
<input type="text" name="customer_name">

<br><br>

Hospital Name:
<input type="text" name="hospital_name">

<br><br>

Email:
<input type="email" name="email">

<br><br>

Phone:
<input type="text" name="phone">

<br><br>

Address:
<textarea name="address"></textarea>

<br><br>

<button type="submit">
Save Customer
</button>

</form>