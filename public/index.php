<!DOCTYPE html>
<html>
<head>
    <title>Client-Contact System</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <button id="themeToggle" style="float: right; margin: 10px;">🌓 Switch Theme</button>

    <h2>Welcome to the Client-Contact System</h2>
    <?php include '../views/navbar.php'; ?>

    
    <ul>
        <li><a href="../views/client_form.php">Add Client</a></li>
        <li><a href="../views/contact_form.php">Add Contact</a></li>
        <li><a href="../views/link_contact.php">Link Contact to Client</a></li>
        <li><a href="../views/client_list.php">View All Clients</a></li>
        <li><a href="../views/contact_list.php">View All Contacts</a></li>
    </ul>
   <script src="../js/theme-toggle.js"></script>
</body>
</html>
