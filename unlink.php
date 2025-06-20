<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Unlink Contact</title>
</head>
<body>
    <?php
    if (isset($_GET['client_id']) && isset($_GET['contact_id'])) {
        $client_id = intval($_GET['client_id']);
        $contact_id = intval($_GET['contact_id']);

        $stmt = $conn->prepare("DELETE FROM client_contact WHERE client_id = ? AND contact_id = ?");
        $stmt->bind_param("ii", $client_id, $contact_id);

        if ($stmt->execute()) {
            echo "<p style='color: green;'>Contact unlinked successfully.</p>";
        } else {
            echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p style='color: red;'>Invalid request.</p>";
    }
    ?>

    <br>
    <a href="client_list.php">← Back to Client List</a>
</body>
</html>
