<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'login_system';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("������ ��� �����������: " . $conn->connect_error);
}
?>
