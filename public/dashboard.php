<?php 
session_start();

require __DIR__ . "/../db.php";
require_once __DIR__ . "/../app/Repositories/MySqlCustomerRepository.php";

$repo = new MySqlCustomerRepository($pdo);

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->query("SELECT name, email FROM customers ORDER BY id ASC");
$customers = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../styles/dashboard.css">
</head>
<body>
    <div class="user__info">
        <p>Now authorizied <?= $_SESSION['role'] ?>: <?= $_SESSION['name'] ?></p>
        <p>Email: <?= $_SESSION['email']?></p>
        <a href="index.php"><button>Log out</button></a>
    </div>
    <div class="table">
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
            </tr>
            <?php foreach ($customers as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['name']) ?></td>
                <td><?= htmlspecialchars($c['email']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="buttons">
        <a href="add_customer.php"><button>Add</button></a>
        <a href="edit_customer.php"><button>Edit</button></a>
        <a href="delete_customer.php"><button>Delete</button></a>
    </div>
    
</body>
</html>