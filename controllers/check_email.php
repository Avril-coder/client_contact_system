<?php
require_once '../config/Database.php';
require_once '../models/Contact.php';

header('Content-Type: application/json');

if (isset($_GET['email'])) {
    $email = trim($_GET['email']);

    $db = (new Database())->connect();
    $contact = new Contact($db);

    $isUnique = $contact->isEmailUnique($email);

    echo json_encode(['unique' => $isUnique]);
    exit;
}

echo json_encode(['error' => 'Email not provided']);
exit;
