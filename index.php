<?php
require("db.php");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorization</title>
</head>
<body>
    <form method="post">
        <h2>Login</h2>
        <input type="email" name="email" placeholder="email"><br><br>
        <input type="password" name="password" placeholder="password"><br><br>
        <button type="submit">Login</button>
        <p>Have no account?<a href="registration.php">Sign up<a>.</p>
    </form>
</body>
</html>