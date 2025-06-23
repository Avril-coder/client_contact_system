<?php
require_once '../config/Database.php';
require_once '../models/Client.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = (new Database())->connect();
    $client = new Client($db);

    $client->name = trim($_POST['name']);
    $client->generateCode(); // This sets $client->code

    if ($client->create()) {
    header('Location: ../views/client_list.php?success=created');
    exit;
}
    } else {
        $error = "Failed to create client.";
        // You can redirect back or pass this message into a session later
    }

