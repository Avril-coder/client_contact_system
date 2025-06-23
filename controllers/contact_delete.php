<?php
require_once '../config/Database.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $db = (new Database())->connect();

    // First unlink from any clients
    $db->prepare("DELETE FROM client_contact WHERE contact_id = :id")->execute([':id' => $id]);

    // Then delete the contact
    $stmt = $db->prepare("DELETE FROM contacts WHERE id = :id");
    if ($stmt->execute([':id' => $id])) {
        header("Location: ../views/contact_list.php?success=deleted");
        exit;
    } else {
        header("Location: ../views/contact_list.php?error=delete_failed");
        exit;
    }
} else {
    header("Location: ../views/contact_list.php?error=invalid_id");
    exit;
}
