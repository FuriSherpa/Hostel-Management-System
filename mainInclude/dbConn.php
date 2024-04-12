<?php
$host = "localhost";
$dbuser = "root";
$dbpass = "";
$db = "hostelstays";

// Establish a connection to the database
$conn = new mysqli($host, $dbuser, $dbpass, $db);

// Check for connection errors
if ($conn->connect_error) {
    die("connection failed");
} 
