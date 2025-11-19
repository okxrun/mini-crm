<?php
session_start();
require __DIR__ . "/../db.php";

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = "Both fields are required.";
    } else {
        $check = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $check->execute([$email]);
        $user = $check->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Wrong email or password";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorization</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
    <form method="post">
        <h2 style="margin-bottom:10px;">Login</h2>
        
        <?php if (isset($_GET['registered']) && $_GET['registered'] == 1): ?>
            <div style="background-color:rgba(102, 226, 98, 0.94);color: white;font-family:sans-serif;font-weight:bold;padding:5px;margin-bottom:10px">Registration successful</div>
        <?php if ($error !== null): ?>
            <div style="background-color:rgba(238, 78, 78, 0.94);color: white;font-family:sans-serif;font-weight:bold;padding:5px;margin-bottom:10px"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php elseif ($error !== null): ?>
            <div style="background-color:rgba(238, 78, 78, 0.94);color: white;font-family:sans-serif;font-weight:bold;padding:5px;margin-bottom:10px"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <input type="email" name="email" placeholder="email" required value="<?= isset($email) ? htmlspecialchars($email) : '' ?>"><br><br>
        <input type="password" name="password" placeholder="password" required><br><br>
        <button type="submit">Login</button>
        <p style="margin-top:5px;">Have no account? <a href="registration.php">Sign up</a>.</p>
    </form>
</body>
</html>