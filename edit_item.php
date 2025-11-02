<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $supplier = $_POST['supplier'];

    try {
        $stmt = $pdo->prepare("UPDATE inventory 
                               SET name = ?, description = ?, quantity = ?, price = ?, supplier = ? 
                               WHERE id = ?");
        $stmt->execute([$name, $description, $quantity, $price, $supplier, $id]);

        if ($quantity == 0) {
            $_SESSION['message'] = "⚠️ Item marked as Out of Stock!";
            $_SESSION['type'] = "warning";
            header("Location: reports.php?outofstock=1");
        } else {
            $_SESSION['message'] = "✅ Item updated successfully!";
            $_SESSION['type'] = "success";
            header("Location: index.php");
        }
        exit();

    } catch (PDOException $e) {
        $_SESSION['message'] = "❌ Error updating item: " . $e->getMessage();
        $_SESSION['type'] = "error";
        header("Location: index.php");
        exit();
    }
}
?>
