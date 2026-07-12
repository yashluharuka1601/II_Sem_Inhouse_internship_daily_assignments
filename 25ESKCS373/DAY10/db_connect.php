<?php
/**
 * Database Connection
 * Student Management System
 */

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "students_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Set character encoding
$conn->set_charset("utf8");
?>
