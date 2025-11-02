<?php
session_start();
require_once 'config.php';

$message = '';
$type = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $type = $_SESSION['type'] ?? 'success';
    unset($_SESSION['message'], $_SESSION['type']);
}

$stmt = $pdo->query("SELECT * FROM inventory ORDER BY id ASC");
$items = $stmt->fetchAll();

// ✅ Stats
$total_items = $pdo->query("SELECT COUNT(*) AS total FROM inventory")->fetch()['total'];
$total_stock = $pdo->query("SELECT SUM(quantity) AS total_qty FROM inventory")->fetch()['total_qty'] ?? 0;
$low_stock = $pdo->query("SELECT COUNT(*) AS low_count FROM inventory WHERE quantity < 10")->fetch()['low_count'] ?? 20;

// ✅ Dropdown Data
$item_stocks = $pdo->query("SELECT name, SUM(quantity) AS total_qty FROM inventory GROUP BY name")->fetchAll();
$low_stock_items = $pdo->query("SELECT name, quantity FROM inventory WHERE quantity < 10 ORDER BY quantity ASC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory Dashboard</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* Red highlight for low stocks in table */
    tr.low-stock td {
      background-color: #ffe6e6;
      color: #b30000;
      font-weight: bold;
    }

    /* Dropdown styling inside cards */
    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
      z-index: 1;
      border-radius: 6px;
      overflow: hidden;
    }

    .dropdown-content p {
      color: #333;
      padding: 10px 15px;
      margin: 0;
      border-bottom: 1px solid #eee;
    }

    .dropdown-content p:hover {
      background-color: #f1f1f1;
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }

    .dropdown-btn {
      background: none;
      border: none;
      color: white;
      font-size: 14px;
      cursor: pointer;
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h2>Electornic Inventory</h2>
    <ul>
      <li><a href="index.php">🏠 Dashboard</a></li>
      <li><a href="reports.php">📊 Reports</a></li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="topbar">
      <h1>Inventory Dashboard</h1>
      <span>Welcome, Admin</span>
      
    </div>

    <div class="stats-container">
      <div class="stat-card">
        <h2><?= $total_items ?></h2>
        <p>Total Items</p>
      </div>

      <!-- ✅ Total Stocks with dropdown -->
      <div class="stat-card">
        <h2><?= $total_stock ?></h2>
        <p>Total Stocks</p>
        <div class="dropdown">
          <button class="dropdown-btn">View by Item ⮟</button>
          <div class="dropdown-content">
            <?php foreach ($item_stocks as $row): ?>
              <p><?= htmlspecialchars($row['name']) ?> — <?= $row['total_qty'] ?></p>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- ✅ Low Stock Items dropdown -->
      <div class="stat-card">
        <h2><?= $low_stock ?></h2>
        <p>Low Stock Items</p>
        <div class="dropdown">
          <button class="dropdown-btn">View List ⮟</button>
          <div class="dropdown-content">
            <?php if ($low_stock_items): ?>
              <?php foreach ($low_stock_items as $low): ?>
                <p><?= htmlspecialchars($low['name']) ?> — <?= $low['quantity'] ?></p>
              <?php endforeach; ?>
            <?php else: ?>
              <p>No low stock items</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <?php if ($message): ?>
      <div class="alert alert-<?php echo $type; ?>"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <!-- Add Item Button -->
    <button class="add-btn" id="openModalBtn">+ Add New Item</button>

    <!-- Modal -->
    <div id="addItemModal" class="modal">
      <div class="modal-content">
        <span class="close-btn" id="closeModalBtn">&times;</span>
        <h2>Add New Inventory Item</h2>
        <form method="POST" action="add_item.php">
          <label for="name">Name (required):</label>
          <input type="text" id="name" name="name" required>

          <label for="description">Description:</label>
          <textarea id="description" name="description"></textarea>

          <label for="quantity">Quantity (required):</label>
          <input type="number" id="quantity" name="quantity" min="0" required>

          <label for="price">Price (required):</label>
          <input type="number" id="price" name="price" min="0.01" step="0.01" required>

          <label for="supplier">Supplier:</label>
          <input type="text" id="supplier" name="supplier">

          <input type="submit" value="Add Item" class="submit-btn">
        </form>
      </div>
    </div>

    <?php if (empty($items)): ?>
      <p style="text-align: center;">No items in inventory.</p>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Supplier</th>
            <th>Actions</th>
          </tr>
        </thead>
       <tbody>
  <?php foreach ($items as $item): ?>
    <tr class="<?= ($item['quantity'] < 20) ? 'low-stock' : '' ?>">
      <td><?= $item['id']; ?></td>
      <td><?= htmlspecialchars($item['name']); ?></td>
      <td><?= htmlspecialchars($item['description'] ?? ''); ?></td>
      <td><?= $item['quantity']; ?></td>
      <td>$<?= number_format($item['price'], 2); ?></td>
      <td><?= htmlspecialchars($item['supplier'] ?? ''); ?></td>
      <td>
  <button class="edit-btn" onclick='openEditModal(<?= json_encode($item); ?>)'>Edit</button>
  <a href="delete_item.php?id=<?= $item['id']; ?>" onclick="return confirm('Are you sure?')">
    <button class="delete-btn">Delete</button>
  </a>
</td>
    </tr>
  <?php endforeach; ?>
</tbody>

      </table>
      <!-- Edit Modal (shared for all items) -->
<div id="editModal" class="modal">
  <div class="modal-content">
    <span class="close-edit">&times;</span>
    <h2>Edit Inventory Item</h2>
    <form id="editForm" method="POST" action="edit_item.php">
      <input type="hidden" name="id" id="edit-id">

      <label for="edit-name">Name:</label>
      <input type="text" id="edit-name" name="name" required>

      <label for="edit-description">Description:</label>
      <textarea id="edit-description" name="description"></textarea>

      <label for="edit-quantity">Quantity:</label>
      <input type="number" id="edit-quantity" name="quantity" min="0" required>

      <label for="edit-price">Price:</label>
      <input type="number" id="edit-price" name="price" step="0.01" min="0.01" required>

      <label for="edit-supplier">Supplier:</label>
      <input type="text" id="edit-supplier" name="supplier">

      <button type="submit" class="btn-update">Update Item</button>
    </form>
  </div>
</div>

    <?php endif; ?>
  </div>

<script>
const addModal = document.getElementById('addItemModal');
const openAddBtn = document.getElementById('openModalBtn');
const closeAddBtn = document.getElementById('closeModalBtn');

// 🟢 Add Modal (Add New Item)
openAddBtn.addEventListener('click', () => addModal.style.display = 'flex');
closeAddBtn.addEventListener('click', () => addModal.style.display = 'none');
window.addEventListener('click', (e) => {
  if (e.target === addModal) addModal.style.display = 'none';
});

// 🟡 Edit Modal (Edit Item)
const editModal = document.getElementById("editModal");
const closeEditBtn = document.querySelector(".close-edit");

function openEditModal(item) {
  editModal.style.display = "flex";
  document.getElementById("edit-id").value = item.id;
  document.getElementById("edit-name").value = item.name;
  document.getElementById("edit-description").value = item.description;
  document.getElementById("edit-quantity").value = item.quantity;
  document.getElementById("edit-price").value = item.price;
  document.getElementById("edit-supplier").value = item.supplier;
}

closeEditBtn.onclick = () => editModal.style.display = "none";
window.onclick = (e) => {
  if (e.target === editModal) editModal.style.display = "none";
};
</script>
<?php if (isset($_GET['updated']) && $_GET['updated'] == 1): ?>
<script>
  alert("✅ Item updated successfully!");
  // Remove the query string so alert doesn't show again
  window.history.replaceState(null, "", window.location.pathname);
</script>
<?php endif; ?>

</body>
</html>
