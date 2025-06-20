<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Client Contacts</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php
    if (isset($_GET['client_id'])) {
        $client_id = intval($_GET['client_id']);

        $client = $conn->query("SELECT name FROM clients WHERE id = $client_id")->fetch_assoc();
        echo "<h2>Contacts linked to client: " . htmlspecialchars($client['name']) . "</h2>";

        $sql = "SELECT con.id, con.name, con.surname, con.email
                FROM contacts con
                INNER JOIN client_contact cc ON cc.contact_id = con.id
                WHERE cc.client_id = $client_id
                ORDER BY con.surname, con.name";

        $result = $conn->query($sql);

        if ($result->num_rows > 0): ?>
            <table border="1" cellpadding="8">
                <tr>
                    <th align="left">Contact Full Name</th>
                    <th align="left">Email</th>
                    <th align="left">Action</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['surname'] . ' ' . $row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td>
                            <a href="unlink.php?client_id=<?php echo $client_id; ?>&contact_id=<?php echo $row['id']; ?>">
                                Unlink
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No contacts found.</p>
        <?php endif; ?>

        <br>
        <a href="client_list.php">← Back to Client List</a>
    <?php } else {
        echo "<p>Client not specified.</p>";
    } ?>
</body>
</html>
