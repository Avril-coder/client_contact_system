<?php
require_once '../config/Database.php';

if (isset($_GET['client_id']) && isset($_GET['contact_id'])) {
    $client_id = intval($_GET['client_id']);
    $contact_id = intval($_GET['contact_id']);

    $db = (new Database())->connect();

    $sql = "DELETE FROM client_contact WHERE client_id = :client_id AND contact_id = :contact_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':client_id', $client_id);
    $stmt->bindParam(':contact_id', $contact_id);

    if ($stmt->execute()) {
        // Redirect back with success message
        header("Location: ../views/client_contacts.php?client_id=$client_id&success=unlinked");
        exit;
    } else {
        header("Location: ../views/client_contacts.php?client_id=$client_id&error=unlink_failed");
        exit;
    }
} else {
    header("Location: ../views/client_contacts.php?error=invalid_params");
    exit;
}
?>
