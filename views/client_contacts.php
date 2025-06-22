<?php include '../config/Database.php';

$db = (new Database())->connect();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Client Contacts</title>
   <link rel="stylesheet" href="../public/assets/style.css">

</head>
<body>
    <button id="themeToggle" style="float:right; margin: 10px;">🌓 Switch Theme</button>

 <?php include __DIR__ . '/navbar.php'; ?>
<?php
// Success / error messages
if (isset($_GET['success']) && $_GET['success'] === 'unlinked') {
    echo "<p style='color: green;'>Unlinked successfully.</p>";
} elseif (isset($_GET['error'])) {
    if ($_GET['error'] === 'unlink_failed') {
        echo "<p style='color: red;'>Failed to unlink contact. Please try again.</p>";
    } elseif ($_GET['error'] === 'invalid_params') {
        echo "<p style='color: red;'>Invalid parameters provided.</p>";
    }
}
?>

<?php
if (isset($_GET['client_id'])) {
    $client_id = intval($_GET['client_id']);

    // Fetch client name
    $clientStmt = $db->prepare("SELECT name FROM clients WHERE id = :id");
    $clientStmt->bindParam(':id', $client_id);
    $clientStmt->execute();
    $client = $clientStmt->fetch(PDO::FETCH_ASSOC);

    if ($client) {
        echo "<h2>Contacts linked to client: " . htmlspecialchars($client['name']) . "</h2>";

        // Fetch contacts linked to this client
        $sql = "SELECT con.id, con.name, con.surname, con.email
                FROM contacts con
                INNER JOIN client_contact cc ON cc.contact_id = con.id
                WHERE cc.client_id = :client_id
                ORDER BY con.surname, con.name";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':client_id', $client_id);
        $stmt->execute();
        $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($contacts): ?>
            <table border="1" cellpadding="8">
                <tr>
                    <th align="left">Contact Full Name</th>
                    <th align="left">Email</th>
                    <th align="left">Action</th>
                </tr>
                <?php foreach ($contacts as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['surname'] . ' ' . $row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td>
                           <a href="../controllers/unlink.php?client_id=<?php echo $client_id; ?>&contact_id=<?php echo $row['id']; ?>">Unlink</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No contacts found.</p>
        <?php endif; ?>
        <br>
        <a href="client_list.php">← Back to Client List</a>
    <?php } else {
        echo "<p>Client not found.</p>";
    }
} else {
    echo "<p>Client not specified.</p>";
}
?>
<script src="../js/theme-toggle.js"></script>
</body>
</html>
