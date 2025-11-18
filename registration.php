<?php
require("db.php");

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $rawPassword = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';
    
    if ($name === '' || $email === '' || $rawPassword === '' || $passwordConfirm === '') {
        $error = "All fields are required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email adress";
    } elseif (mb_strlen($rawPassword) < 8) {
        $error = "Password must be at least 8 characters";
    } elseif ($rawPassword !== $passwordConfirm) {
        $error = "Paswords do not match";
    } else {
        $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$email]);

        if ($check->fetch()) {
            $error = "Email already exists";
        } else {
            $hashPassword = password_hash($rawPassword, PASSWORD_DEFAULT);

            $dsn = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            $dsn->execute([$name, $email, $hashPassword, 'user']);

            header("Location: index.php?registered=1");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="post">
        <h2 style="margin-bottom:10px;">Sign up</h2>

        <?php if (!empty($error)): ?>
            <div style="background-color:rgba(238, 78, 78, 0.94);color: white;font-family:sans-serif;font-weight:bold;padding:5px;margin-bottom:10px"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <input type="text" name="name" placeholder="name" required value="<?= isset($name) ? htmlspecialchars($name) : '' ?>"><br><br>
        <input type="email" name="email" placeholder="email" required value="<?= isset($email) ? htmlspecialchars($email) : '' ?>"><br><br>
        <input type="password" name="password" placeholder="password" required minlength="8"><br><br>
        <input type="password" name="password_confirm" placeholder="password confirm" required>
        <button type="submit">Sign up</button>
        <p style="margin-top:5px;">Already have an account? <a href="index.php">Log in</a>.</p><br>
    </form>

</body>
</html>