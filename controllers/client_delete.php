<?php
require_once '../config/Database.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $db = (new Database())->connect();

    // First unlink contacts
    $db->prepare("DELETE FROM client_contact WHERE client_id = :id")->execute([':id' => $id]);

    // Then delete client
    $stmt = $db->prepare("DELETE FROM clients WHERE id = :id");
    if ($stmt->execute([':id' => $id])) {
        header("Location: ../views/client_list.php?success=deleted");
        exit;
    } else {
        header("Location: ../views/client_list.php?error=delete_failed");
        exit;
    }
} else {
    header("Location: ../views/client_list.php?error=invalid_id");
    exit;
}
