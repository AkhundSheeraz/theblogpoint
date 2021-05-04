<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "admin";
$database = "blogsite_db";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = new mysqli($servername, $username, $password, $database);

if($conn->connect_error){
    die("connection failed: ". $conn->connect_error);
}
