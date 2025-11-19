<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    haeder("Location: index.php");
    exit;
}

require_once __DIR__ . "/../app/Repositories/MySqlCustomerRepository.php";

$repo = new MySqlCustomerRepository($pdo);
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($name === '' || $email === '') {
        $error = "All fields are required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } else {
        $repo->create([
            'name' => $name,
            'email' => $email
        ]);

        header("Location: dashboard.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add customer</title>
    <!-- <link rel="stylesheet" href="../styles/style.css"> я хз, у меня почему-то стили не обновляются -->
</head>
<body>
    <h2>Add customer</h2>

    <?php if ($error): ?>
        <div style="background-color:rgba(238, 78, 78, 0.94);color:white;padding:5px;margin-bottom:10px;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="name" placeholder="name" required value="<?= isset($name) ? htmlspecialchars($name) : '' ?>"><br><br>
        <input type="text" name="email" placeholder="email" required><br><br>
        <button type="submit">Add</button>
    </form>

    <p class="back"><a href="dashboard.php">Back</a></p>
</body>
</html>