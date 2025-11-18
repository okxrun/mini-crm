<?php
require("db.php");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorization</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="post">
        <h2 style="margin-bottom:10px;">Login</h2>
        <input type="email" name="email" placeholder="email" required><br><br>
        <input type="password" name="password" placeholder="password" required><br><br>
        <button type="submit">Login</button>
        <p style="margin-top:5px;">Have no account? <a href="registration.php">Sign up<a>.</p>
    </form>
</body>
</html>