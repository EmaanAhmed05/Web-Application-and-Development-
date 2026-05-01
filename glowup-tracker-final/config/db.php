<?php
$conn = new mysqli("localhost", "root", "", "glowup", 3307);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function e($str){
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
?>