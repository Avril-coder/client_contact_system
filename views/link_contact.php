<?php
require_once '../config/Database.php';

$db = new Database();
$conn = $db->connect();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $contact_id = $_POST['contact_id'] ?? null;
    $client_ids = $_POST['client_ids'] ?? [];

    if (!empty($contact_id) && !empty($client_ids)) {
        foreach ($client_ids as $client_id) {
            // Prevent duplicates
            $checkStmt = $conn->prepare("SELECT COUNT(*) FROM client_contact WHERE client_id = :client_id AND contact_id = :contact_id");
            $checkStmt->execute([':client_id' => $client_id, ':contact_id' => $contact_id]);
            $count = $checkStmt->fetchColumn();

            if ($count == 0) {
                $insertStmt = $conn->prepare("INSERT INTO client_contact (client_id, contact_id) VALUES (:client_id, :contact_id)");
                $insertStmt->execute([':client_id' => $client_id, ':contact_id' => $contact_id]);
            }
        }
        $message = "<p style='color: green;'>Contact linked to selected client(s).</p>";
    } else {
        $message = "<p style='color: red;'>Please select a contact and at least one client.</p>";
    }
}

// Fetch contacts
$contactsStmt = $conn->query("SELECT id, name, surname FROM contacts ORDER BY surname, name");
$contacts = $contactsStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch clients
$clientsStmt = $conn->query("SELECT id, name FROM clients ORDER BY name");
$clients = $clientsStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Link Contact to Client(s)</title>
   <link rel="stylesheet" href="../public/assets/style.css">

</head>
<body>
    <button id="themeToggle" style="float:right; margin: 10px;">🌓 Switch Theme</button>
     <?php include __DIR__ . '/navbar.php'; ?>
    <h2>Link Contact to Client(s)</h2>

    <form method="POST" action="">
        <label>Select Contact:</label><br>
        <select name="contact_id" required>
            <option value="">-- Select Contact --</option>
            <?php foreach ($contacts as $con): ?>
                <option value="<?php echo $con['id']; ?>">
                    <?php echo htmlspecialchars($con['surname'] . " " . $con['name']); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Select Client(s):</label><br>
        <?php if (count($clients) > 0): ?>
            <?php foreach ($clients as $cli): ?>
                <label>
                    <input type="checkbox" name="client_ids[]" value="<?php echo $cli['id']; ?>">
                    <?php echo htmlspecialchars($cli['name']); ?>
                </label><br>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No clients found.</p>
        <?php endif; ?>

        <br>
        <button type="submit">Link</button>
    </form>

    <?php echo $message; ?>
    <script src="../js/theme-toggle.js"></script>
</body>
</html>
