<?php

require_once '../config/Database.php';
require_once '../models/Client.php';

$db = (new Database())->connect();
$clientModel = new Client($db);

// Get clients with linked contacts count
$clients = $clientModel->getAllWithContactCount();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Client List</title>
    <link rel="stylesheet" href="../public/assets/style.css">
</head>
<body>
<button id="themeToggle" style="float:right; margin: 10px;">🌓 Switch Theme</button>

    <?php include __DIR__ . '/navbar.php'; ?>

    <h2>Clients</h2>
    <a href="client_form.php">+ Add New Client</a>
    <br><br>

    <?php if (count($clients) > 0): ?>
        <table border="1" cellpadding="8">
            <tr>
                <th align="left">Client Name</th>
                <th align="left">Client Code</th>
                <th align="center">No. of Linked Contacts</th>
                <th align="left">Action</th>
            </tr>
            <?php foreach ($clients as $client): ?>
                <tr>
                    <td><?php echo htmlspecialchars($client['name']); ?></td>
                    <td><?php echo htmlspecialchars($client['code']); ?></td>
                    <td align="center"><?php echo $client['contact_count']; ?></td>
                    <td>
                        <a href="client_contacts.php?client_id=<?php echo $client['id']; ?>">View Contacts</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No client(s) found.</p>
    <?php endif; ?>
  <script src="../js/theme-toggle.js"></script>
</body>
</html>
