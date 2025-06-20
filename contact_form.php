<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Contact</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2>Create New Contact</h2>

    <?php
    $name = "";
    $surname = "";
    $email = "";
    $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = trim($_POST["name"]);
        $surname = trim($_POST["surname"]);
        $email = trim($_POST["email"]);

        if (!empty($name) && !empty($surname) && !empty($email)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // Check if email already exists
                $check = $conn->prepare("SELECT id FROM contacts WHERE email = ?");
                $check->bind_param("s", $email);
                $check->execute();
                $check->store_result();

                if ($check->num_rows == 0) {
                    // Insert new contact
                    $stmt = $conn->prepare("INSERT INTO contacts (name, surname, email) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $name, $surname, $email);

                    if ($stmt->execute()) {
                        $message = "<p style='color: green;'>Contact created successfully.</p>";
                        $name = $surname = $email = ""; // reset
                    } else {
                        $message = "<p style='color: red;'>Error: " . $stmt->error . "</p>";
                    }
                    $stmt->close();
                } else {
                    $message = "<p style='color: red;'>This email already exists.</p>";
                }

                $check->close();
            } else {
                $message = "<p style='color: red;'>Invalid email format.</p>";
            }
        } else {
            $message = "<p style='color: red;'>All fields are required.</p>";
        }
    }
    ?>

    <form method="POST" action="">
        <label>Name:</label><br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required><br><br>

        <label>Surname:</label><br>
        <input type="text" name="surname" value="<?php echo htmlspecialchars($surname); ?>" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br><br>

        <button type="submit">Create Contact</button>
    </form>

    <?php echo $message; ?>
</body>
</html>
