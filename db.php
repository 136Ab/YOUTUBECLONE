<?php
$host = "localhost";
$user = "uyxjoy1oa0goc";
$pass = "ufekrvzpkslt";
$dbname = "db75h1qngdgpag";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
