<?php

session_start();

if (!isset($_SESSION['logged in']) || $_SESSION['logged in'] !== true) {
    header("location: login.php");
}
?>


<html>
<head>
    <title>PHP login system!- HOME</title>
</head>
<body>
<a href="logout.php">Logout</a>

<div class="container mt-4">
    <h3><?php echo "Welcome " . $_SESSION['username'] ?>! You can now use this website</h3>
    <hr>
</div>
</body>
</html>