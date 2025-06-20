<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact List</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2>Contacts</h2>
    <a href="contact_form.php">+ Add New Contact</a>
    <br><br>

    <?php
    $sql = "SELECT con.id, con.name, con.surname, con.email,
            (SELECT COUNT(*) FROM client_contact cc WHERE cc.contact_id = con.id) AS client_count
            FROM contacts con
            ORDER BY con.surname ASC, con.name ASC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0): ?>
        <table border="1" cellpadding="8">
            <tr>
                <th align="left">Name</th>
                <th align="left">Surname</th>
                <th align="left">Email Address</th>
                <th align="center">No. of Linked Clients</th>
                <th align="left">Action</th> <!-- NEW COLUMN -->
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['surname']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td align="center"><?php echo $row['client_count']; ?></td>
                    <td>
                        <a href="contact_clients.php?contact_id=<?php echo $row['id']; ?>">View Clients</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No contact(s) found.</p>
    <?php endif; ?>
</body>
</html>
