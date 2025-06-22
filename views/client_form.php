<!DOCTYPE html>
<html>
<head>
    <title>Add New Client</title>
  <link rel="stylesheet" href="../public/assets/style.css">

</head>
<body>
    <button id="themeToggle" style="float:right; margin: 10px;">🌓 Switch Theme</button>

     <?php include __DIR__ . '/navbar.php'; ?>
    <h2>Add New Client</h2>

    <!--  Corrected form action path -->
    <form method="POST" action="../controllers/client_create.php">
        <label for="name">Client Name:</label><br>
        <input type="text" name="name" required><br><br>

        <button type="submit">Save</button>
    </form>

    <br>
    <a href="client_list.php">← Back to Client List</a>
    <script src="../js/theme-toggle.js"></script>
</body>
</html>

