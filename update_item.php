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
        // Update item
        $stmt = $pdo->prepare("UPDATE inventory 
                               SET name = ?, description = ?, quantity = ?, price = ?, supplier = ? 
                               WHERE id = ?");
        $stmt->execute([$name, $description, $quantity, $price, $supplier, $id]);

        // If quantity is 0, move to out_of_stock and remove from inventory
        if ($quantity == 0) {
            // Get item details first
            $stmt2 = $pdo->prepare("SELECT * FROM inventory WHERE id = ?");
            $stmt2->execute([$id]);
            $item = $stmt2->fetch(PDO::FETCH_ASSOC);

            if ($item) {
                // Insert into out_of_stock
                $insert = $pdo->prepare("INSERT INTO out_of_stock (name, description, price, supplier)
                                         VALUES (?, ?, ?, ?)");
                $insert->execute([$item['name'], $item['description'], $item['price'], $item['supplier']]);

                // Delete from inventory
                $delete = $pdo->prepare("DELETE FROM inventory WHERE id = ?");
                $delete->execute([$id]);
            }

            header("Location: reports.php?outofstock=1");
            exit();
        }

        // Normal update
        header("Location: index.php?updated=1");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
