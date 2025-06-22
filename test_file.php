<?php
require_once 'config/Database.php';
require_once 'models/Client.php';

$db = (new Database())->connect();
$client = new Client($db);

$client->name = "Test Company";
$client->generateCode();

if ($client->create()) {
    echo "Client created with code: " . $client->code;
} else {
    echo "Failed to create client.";
}
?>
