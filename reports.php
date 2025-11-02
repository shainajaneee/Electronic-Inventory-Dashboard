<?php
session_start();
require_once 'config.php';

// Fetch out-of-stock items
$stmt1 = $pdo->query("SELECT * FROM inventory WHERE quantity = 0 ORDER BY name ASC");
$out_of_stock_items = $stmt1->fetchAll();

// Fetch low-stock items (quantity between 1 and 5)
$stmt2 = $pdo->query("SELECT * FROM inventory WHERE quantity BETWEEN 1 AND 19 ORDER BY name ASC");
$low_stock_items = $stmt2->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory Reports</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .report-container {
      display: flex;
      justify-content: space-between;
      gap: 20px;
      padding: 20px;
      flex-wrap: wrap;
    }

    .report-section {
      flex: 1;
      min-width: 45%;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      padding: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th, td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f5f5f5;
    }

    .out-of-stock-row {
      background-color: #ffe6e6;
      color: #b30000;
    }

    .low-stock-row {
      background-color: #fff8e6;
      color: #b36b00;
    }

    .sidebar {
      width: 220px;
      background: #2d3436;
      color: white;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      padding: 20px;
    }

    .main-content {
      margin-left: 240px;
      padding: 20px;
    }

    .topbar h1 {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <h2>Electronic Inventory</h2>
    <ul>
      <li><a href="index.php">🏠 Dashboard</a></li>
      <li><a href="reports.php" class="active">📊 Reports</a></li>
    </ul>
  </div>

  <div class="main-content">
    <div class="topbar">
      <h1>📊 Inventory Reports</h1>
    </div>

    <?php if (isset($_SESSION['message'])): ?>
      <script>
        alert("<?= addslashes($_SESSION['message']) ?>");
      </script>
      <?php unset($_SESSION['message'], $_SESSION['type']); ?>
    <?php endif; ?>

    <div class="report-container">
      <!-- 🟥 Out of Stock Section -->
      <div class="report-section">
        <h2>🚨 Out of Stock</h2>
        <?php if (empty($out_of_stock_items)): ?>
          <p>✅ All items are in stock.</p>
        <?php else: ?>
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Item Name</th>
                <th>Description</th>
                <th>Supplier</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($out_of_stock_items as $item): ?>
                <tr class="out-of-stock-row">
                  <td><?= $item['id'] ?></td>
                  <td><?= htmlspecialchars($item['name']) ?></td>
                  <td><?= htmlspecialchars($item['description']) ?></td>
                  <td><?= htmlspecialchars($item['supplier']) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>

      <!-- 🟨 Low Stock Section -->
      <div class="report-section">
        <h2>⚠️ Low Stock (5)</h2>
        <?php if (empty($low_stock_items)): ?>
          <p>✅ No low-stock alerts.</p>
        <?php else: ?>
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Item Name</th>
                <th>Description</th>
                <th>Quantity</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($low_stock_items as $item): ?>
                <tr class="low-stock-row">
                  <td><?= $item['id'] ?></td>
                  <td><?= htmlspecialchars($item['name']) ?></td>
                  <td><?= htmlspecialchars($item['description']) ?></td>
                  <td><?= $item['quantity'] ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html>
