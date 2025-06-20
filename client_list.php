<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Client List</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2>Clients</h2>
    <a href="client_form.php">+ Add New Client</a>
    <br><br>

    <?php
    $sql = "SELECT c.id, c.name, c.code,
            (SELECT COUNT(*) FROM client_contact cc WHERE cc.client_id = c.id) AS contact_count
            FROM clients c
            ORDER BY c.name ASC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0): ?>
        <table border="1" cellpadding="8">
            <tr>
                <th align="left">Client Name</th>
                <th align="left">Client Code</th>
                <th align="center">No. of Linked Contacts</th>
                <th align="left">Action</th> <!-- Added header -->
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['code']); ?></td>
                    <td align="center"><?php echo $row['contact_count']; ?></td>
                    <td>
                        <a href="client_contacts.php?client_id=<?php echo $row['id']; ?>">View Contacts</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No client(s) found.</p>
    <?php endif; ?>
</body>
</html>

