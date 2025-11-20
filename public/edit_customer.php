<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

require_once __DIR__ . "/../app/Repositories/MySqlCustomerRepository.php";

$repo = new MySqlCustomerRepository($pdo);
$error = null;

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: dashboard.php");
    exit;
}

$customer = $repo->find($id);
if (!$customer) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($name === '' || $email === '') {
        $error = "All fields required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } else {
        try {
            $repo->update($id, [
            'name' => $name,
            'email' => $email
        ]);
        header("Location: dashboard.php");
        exit;
        } catch (Exception $e) {
            if ($e->getMessage() === 'duplicate_email') {
                $error = "Email already use";
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
    <title>Edit customers</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
    <h2>Edit customer</h2>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="name" placeholder="edit name" value="<?= htmlspecialchars($customer['name']) ?>">
        <input type="email" name="email" placeholder="edit email" value="<?= htmlspecialchars($customer['email']) ?>">
        <button type="submit">Save changes</button>
    </form>
    <a class="back" href="dashboard.php"><p>Back</p></a>
</body>
</html>