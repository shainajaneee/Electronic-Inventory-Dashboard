<?php
session_start();
require_once 'config.php';

$message = '';
$type = 'error';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $quantity = (int)($_POST['quantity'] ?? 0);
    $price = (float)($_POST['price'] ?? 0);
    $supplier = trim($_POST['supplier'] ?? '');

    if (!empty($name) && $quantity >= 0 && $price > 0) {
        try {
            $stmt = $pdo->prepare("INSERT INTO inventory (name, description, quantity, price, supplier) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $description, $quantity, $price, $supplier]);
            $_SESSION['message'] = 'Item added successfully!';
            $_SESSION['type'] = 'success';
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            $message = 'Error adding item: ' . $e->getMessage();
        }
    } else {
        $message = 'Please fill in all required fields correctly.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Add New Inventory Item</h2>
    
    <?php if ($message): ?>
        <div class="alert alert-<?php echo $type; ?>"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <label for="name">Name (required):</label>
        <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
        
        <label for="description">Description:</label>
        <textarea id="description" name="description"><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
        
        <label for="quantity">Quantity (required, non-negative):</label>
        <input type="number" id="quantity" name="quantity" min="0" required value="<?php echo htmlspecialchars($_POST['quantity'] ?? ''); ?>">
        
        <label for="price">Price (required, positive):</label>
        <input type="number" id="price" name="price" min="0.01" step="0.01" required value="<?php echo htmlspecialchars($_POST['price'] ?? ''); ?>">
        
        <label for="supplier">Supplier:</label>
        <input type="text" id="supplier" name="supplier" value="<?php echo htmlspecialchars($_POST['supplier'] ?? ''); ?>">
        
        <input type="submit" value="Add Item">
    </form>
    
    <p><a href="index.php">Back to Inventory</a></p>
</body>
</html>