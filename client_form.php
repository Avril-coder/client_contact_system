<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Client</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2>Create New Client</h2>

    <?php
    $name = "";
    $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = strtoupper(trim($_POST["name"]));

        if (!empty($name)) {
            // Step 1: Get first 3 letters
            $prefix = strtoupper(substr($name, 0, 3));
            if (strlen($prefix) < 3) {
                $prefix = str_pad($prefix, 3, "A");
            }

            // Step 2: Generate code like PRO001, PRO002, etc.
            $number = 1;
            do {
                $code = $prefix . str_pad($number, 3, "0", STR_PAD_LEFT);
                $result = $conn->query("SELECT id FROM clients WHERE code = '$code'");
                $number++;
            } while ($result->num_rows > 0);

            // Step 3: Insert into database
            $stmt = $conn->prepare("INSERT INTO clients (name, code) VALUES (?, ?)");
            $stmt->bind_param("ss", $name, $code);

            if ($stmt->execute()) {
                $message = "<p style='color: green;'>Client created with code: <strong>$code</strong></p>";
                $name = ""; // Reset form field
            } else {
                $message = "<p style='color: red;'>Error: " . $stmt->error . "</p>";
            }

            $stmt->close();
        } else {
            $message = "<p style='color: red;'>Client name is required.</p>";
        }
    }
    ?>

    <form method="POST" action="">
        <label>Client Name:</label><br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required><br><br>
        <button type="submit">Create Client</button>
    </form>

    <?php echo $message; ?>
</body>
</html>
