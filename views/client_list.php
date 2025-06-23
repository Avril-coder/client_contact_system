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

<!-- Success or Error Messages -->
<?php if (isset($_GET['success']) && $_GET['success'] === 'created'): ?>
    <p style="color: green;">Client created successfully.</p>
<?php elseif (isset($_GET['success']) && $_GET['success'] === 'deleted'): ?>
    <p style="color: green;">Client deleted successfully.</p>
<?php elseif (isset($_GET['error']) && $_GET['error'] === 'delete_failed'): ?>
    <p style="color: red;">Failed to delete client.</p>
<?php endif; ?>

<br><br>

<?php if (count($clients) > 0): ?>
    <table border="1" cellpadding="8">
        <tr>
            <th align="left">Client Name</th>
            <th align="left">Client Code</th>
            <th align="center">No. of Linked Contacts</th>
            <th align="left">Actions</th>
        </tr>
        <?php foreach ($clients as $client): ?>
            <tr>
                <td><?php echo htmlspecialchars($client['name']); ?></td>
                <td><?php echo htmlspecialchars($client['code']); ?></td>
                <td align="center"><?php echo $client['contact_count']; ?></td>
                <td>
                    <a href="client_contacts.php?client_id=<?php echo $client['id']; ?>">View Contacts</a> |
                    <a href="../controllers/client_delete.php?id=<?php echo $client['id']; ?>"
                       onclick="return confirm('Are you sure you want to delete this client? This will also unlink all related contacts.');">
                       Delete
                    </a>
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
