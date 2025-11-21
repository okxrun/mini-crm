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
        try {
            $repo->create([
            'name' => $name,
            'email' => $email
            ]);
        
            header("Location: dashboard.php");
            exit;
        } catch (Exception $e) {
            if ($e->getMessage() === "duplicate_email") {
                $error = "Email already exists";
            } else {
                throw $e;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add customer</title>
    <link rel="stylesheet" href="../styles/main.css">
</head>
<body>
    <main>
        <h2>Add customer</h2>

        <?php if ($error): ?>
            <div class="error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="text" name="name" placeholder="name" required value="<?= isset($name) ? htmlspecialchars($name) : '' ?>"><br><br>
            <input type="email" name="email" placeholder="email" required><br><br>
            <button type="submit">Add</button>
        </form>

        <a class="back__btn" href="dashboard.php"><button>Back→</button></a>
    </main>
</body>
</html>