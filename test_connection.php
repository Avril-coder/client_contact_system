<?php
require_once 'config/Database.php';

$db = new Database();
$conn = $db->connect();

if ($conn) {
    echo " Connected successfully using PDO!";
}
?>
