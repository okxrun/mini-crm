<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

if ($_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit;
}

require_once __DIR__ . "/../app/Repositories/MySqlCustomerRepository.php";

$repo = new MySqlCustomerRepository($pdo);
$status = null;

$id = $_GET['id'] ?? '';
if (!$id) {
    header("Location: dashboard.php");
    exit;
}

$customer = $repo->find($id);
if (!$customer) {
    header("Location: dashboard.php");
    exit;
}

$repo->delete($id);

header("Location: dashboard.php?deleted=1");
exit;
?>