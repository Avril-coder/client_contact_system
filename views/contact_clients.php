<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact's Clients</title>
    <link rel="stylesheet" href="../public/assets/style.css">

</head>
<body>
    <button id="themeToggle" style="float:right; margin: 10px;">🌓 Switch Theme</button>

     <?php include __DIR__ . '/navbar.php'; ?>
    <?php
    if (isset($_GET['contact_id'])) {
        $contact_id = intval($_GET['contact_id']);

        $contact = $conn->query("SELECT name, surname FROM contacts WHERE id = $contact_id")->fetch_assoc();
        echo "<h2>Clients linked to contact: " . htmlspecialchars($contact['surname'] . ' ' . $contact['name']) . "</h2>";

        $sql = "SELECT cli.id, cli.name, cli.code
                FROM clients cli
                INNER JOIN client_contact cc ON cc.client_id = cli.id
                WHERE cc.contact_id = $contact_id
                ORDER BY cli.name ASC";

        $result = $conn->query($sql);

        if ($result->num_rows > 0): ?>
            <table border="1" cellpadding="8">
                <tr>
                    <th align="left">Client Name</th>
                    <th align="left">Client Code</th>
                    <th align="left">Action</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['code']); ?></td>
                        <td>
                            <a href="unlink.php?client_id=<?php echo $row['id']; ?>&contact_id=<?php echo $contact_id; ?>">
                                Unlink
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No client(s) found.</p>
        <?php endif; ?>

        <br>
        <a href="contact_list.php">← Back to Contact List</a>
    <?php } else {
        echo "<p>Contact not specified.</p>";
    } ?>
  <script src="../js/theme-toggle.js"></script>
</body>
</html>
