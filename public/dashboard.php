<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

require_once __DIR__ . "/../app/Repositories/MySqlCustomerRepository.php";
require __DIR__ . "/../app/helpers.php";

$repo = new MySqlCustomerRepository($pdo);
$customers = $repo->getAll();

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
    <h2 style="text-align:center">Customers</h2>

    <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
        <div class="message">
            <div class="success">Delete successful</div>
        </div>    
    <?php endif; ?>

    <div class="table">
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($customers as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['name']) ?></td>
                <td><?= htmlspecialchars($c['email']) ?></td>
                <td>
                    <a href="edit_customer.php?id=<?= $c['id'] ?>"><button>Edit</button></a>
                    <?php if (isAdmin()): ?>
                        <a href="delete_customer.php?id=<?= $c['id'] ?>" onclick="return confirm('Are you sure?')"><button>Delete</button></a>
                    <?php else: ?>
                        <button disabled>No acces</button>
                    <?php endif; ?>                    
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <a href="add_customer.php" class="add__button"><button>Add</button></a>
    
</body>
</html>