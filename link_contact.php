<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Link Contact to Client(s)</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2>Link Contact to Client(s)</h2>

    <?php
    $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $contact_id = $_POST['contact_id'];
        $client_ids = isset($_POST['client_ids']) ? $_POST['client_ids'] : [];

        if (!empty($contact_id) && !empty($client_ids)) {
            foreach ($client_ids as $client_id) {
                // Prevent duplicates
                $check = $conn->prepare("SELECT * FROM client_contact WHERE client_id = ? AND contact_id = ?");
                $check->bind_param("ii", $client_id, $contact_id);
                $check->execute();
                $check->store_result();

                if ($check->num_rows == 0) {
                    $insert = $conn->prepare("INSERT INTO client_contact (client_id, contact_id) VALUES (?, ?)");
                    $insert->bind_param("ii", $client_id, $contact_id);
                    $insert->execute();
                    $insert->close();
                }

                $check->close();
            }
            $message = "<p style='color: green;'>Contact linked to selected client(s).</p>";
        } else {
            $message = "<p style='color: red;'>Please select a contact and at least one client.</p>";
        }
    }

    // Fetch contacts
    $contacts = $conn->query("SELECT id, name, surname FROM contacts ORDER BY surname, name");

    // Fetch clients
    $clients = $conn->query("SELECT id, name FROM clients ORDER BY name");
    ?>

    <form method="POST" action="">
        <label>Select Contact:</label><br>
        <select name="contact_id" required>
            <option value="">-- Select Contact --</option>
            <?php while ($con = $contacts->fetch_assoc()): ?>
                <option value="<?php echo $con['id']; ?>">
                    <?php echo htmlspecialchars($con['surname'] . " " . $con['name']); ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Select Client(s):</label><br>
        <?php if ($clients->num_rows > 0): ?>
            <?php while ($cli = $clients->fetch_assoc()): ?>
                <label>
                    <input type="checkbox" name="client_ids[]" value="<?php echo $cli['id']; ?>">
                    <?php echo htmlspecialchars($cli['name']); ?>
                </label><br>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No clients found.</p>
        <?php endif; ?>

        <br>
        <button type="submit">Link</button>
    </form>

    <?php echo $message; ?>
</body>
</html>
