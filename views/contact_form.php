<!DOCTYPE html>
<html>
<head>
    <title>Create Contact</title>
    <link rel="stylesheet" href="../public/assets/style.css">

</head>
<body>
    <button id="themeToggle" style="float:right; margin: 10px;">🌓 Switch Theme</button>

     <?php include __DIR__ . '/navbar.php'; ?>
    <h2>Create New Contact</h2>

    <?php
    if (isset($_GET['error']) && $_GET['error'] === 'email_exists') {
        echo "<p style='color: red;'>This email already exists.</p>";
    } elseif (isset($_GET['error']) && $_GET['error'] === 'missing_fields') {
        echo "<p style='color: red;'>All fields are required.</p>";
    } elseif (isset($_GET['error'])) {
        echo "<p style='color: red;'>Something went wrong. Please try again.</p>";
    } elseif (isset($_GET['success'])) {
        echo "<p style='color: green;'>Contact created successfully.</p>";
    }
    ?>

    <form method="POST" action="../controllers/contact_create.php">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Surname:</label><br>
        <input type="text" name="surname" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <button type="submit">Create Contact</button>
    </form>

    <br>
    <a href="contact_list.php">← Back to Contact List</a>
    <script src="../js/contact_validation.js"></script>
    <script src="../js/email_validation.js"></script>

<script src="../js/theme-toggle.js"></script>
</body>
</html>
