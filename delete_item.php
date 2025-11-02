<?php
session_start();
require_once 'config.php';

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    $_SESSION['message'] = 'Invalid item ID.';
    $_SESSION['type'] = 'error';
    header("Location: index.php");
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM inventory WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['message'] = 'Item deleted successfully!';
    $_SESSION['type'] = 'success';
} catch (PDOException $e) {
    $_SESSION['message'] = 'Error deleting item: ' . $e->getMessage();
    $_SESSION['type'] = 'error';
}

header("Location: index.php");
exit;
?>