<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
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
            <tr>
                <td>kir</td>
                <td>cvrsed@gmail.com</td>
            </tr>
        </table>
    </div>
    
</body>
</html>