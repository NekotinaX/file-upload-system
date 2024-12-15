<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'login_system';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Грешка при свързването: " . $conn->connect_error);
}
?>
