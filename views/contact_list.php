<?php
require_once '../config/Database.php';
require_once '../models/Contact.php';

$db = (new Database())->connect();
$contactModel = new Contact($db);

// Get all contacts using PDO
$contacts = $contactModel->getAll();

// Count linked clients for each contact
$linkedCounts = [];
$stmt = $db->query("SELECT contact_id, COUNT(client_id) as total FROM client_contact GROUP BY contact_id");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $linkedCounts[$row['contact_id']] = $row['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact List</title>
    <link rel="stylesheet" href="../public/assets/style.css">
</head>
<body>
<button id="themeToggle" style="float:right; margin: 10px;">🌓 Switch Theme</button>

<?php include __DIR__ . '/navbar.php'; ?>

<h2>Contacts</h2>
<a href="contact_form.php">+ Add New Contact</a>

<!-- Success / Error Messages -->
<?php if (isset($_GET['success']) && $_GET['success'] === 'deleted'): ?>
    <p style="color: green;">Contact deleted successfully.</p>
<?php elseif (isset($_GET['error']) && $_GET['error'] === 'delete_failed'): ?>
    <p style="color: red;">Failed to delete contact.</p>
<?php elseif (isset($_GET['success']) && $_GET['success'] === 'created'): ?>
    <p style="color: green;">Contact created successfully.</p>
<?php endif; ?>

<br><br>

<?php if (!empty($contacts)): ?>
    <table border="1" cellpadding="8">
        <tr>
            <th align="left">Name</th>
            <th align="left">Surname</th>
            <th align="left">Email Address</th>
            <th align="center">No. of Linked Clients</th>
            <th align="left">Action</th>
        </tr>
        <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?php echo htmlspecialchars($contact['name']); ?></td>
                <td><?php echo htmlspecialchars($contact['surname']); ?></td>
                <td><?php echo htmlspecialchars($contact['email']); ?></td>
                <td align="center"><?php echo $contact['client_count']; ?></td>
                <td>
                    <a href="../controllers/contact_delete.php?id=<?php echo $contact['id']; ?>"
                       onclick="return confirm('Are you sure you want to delete this contact? This will also unlink all related clients.');">
                       Delete
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No contact(s) found.</p>
<?php endif; ?>

<script src="../js/theme-toggle.js"></script>
</body>
</html>
