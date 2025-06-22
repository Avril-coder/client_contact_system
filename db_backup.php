<?php
$host = 'localhost';
$user = 'root';
$password = ''; // default password is blank for XAMPP
$dbname = 'client_contact_db';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

