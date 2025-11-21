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
    <link rel="stylesheet" href="../styles/main.css">
</head>
<body>
    <main>
        <form method="post">
            <h2>Login</h2>
            
            <?php if (isset($_GET['registered']) && $_GET['registered'] == 1): ?>
                <div class="success">Registration successful</div>
            <?php if ($error !== null): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php elseif ($error !== null): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <input type="email" name="email" placeholder="email" required value="<?= isset($email) ? htmlspecialchars($email) : '' ?>"><br><br>
            <input type="password" name="password" placeholder="password" required><br><br>
            <button type="submit">Login</button>
            <p>Have no account? <a href="registration.php" class="link">Sign up</a>.</p>
        </form>
    </main>
</body>
</html>