<?php

$servername = "mysql";
$username = "root";
$password = "rootpassword";
$dbname = "webbshop";

$conn = new mysqli($servername, $username, $password);

if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database '$dbname' created or already exists.<br>";
} else {
    echo "Error creating database: " . $conn->error;
}

$conn->select_db($dbname);

echo "Connected to database: $dbname<br>";
?>