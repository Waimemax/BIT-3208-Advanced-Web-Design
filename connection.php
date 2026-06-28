<?php
// Force Kali Linux to show us the exact database error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Establish connection to HumanMatrix database
$conn = mysqli_connect("localhost", "root", "", "human_matrix_db");

// Check if the connection actually works
if (!$conn) {
    die("❌ DATABASE CONNECTION FAILED: " . mysqli_connect_error());
}

echo "✅ DATABASE CONNECTED SUCCESSFULLY!";
?>