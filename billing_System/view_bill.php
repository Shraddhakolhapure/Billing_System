<?php
$host = 'localhost'; // or your host
$dbname = 'shopping_system';
$username = 'root'; // your database username
$password = ''; // your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (isset($_GET['id'])) {
    $billId = $_GET['id'];
    // Fetch bill details
    $stmt = $pdo->prepare("SELECT * FROM bills WHERE id = ?");
    $stmt->execute([$billId]);
    $bill = $stmt->fetch();

    // Fetch bill items
    $stmt = $pdo->prepare("SELECT * FROM bill_items WHERE bill_id = ?");
    $stmt->execute([$billId]);
    $items = $stmt->fetchAll();
} else {
    die("Bill ID is missing.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Bill Details</h1>
    </header>
    <main>
        <h2>Customer: <?php echo htmlspecialchars($bill['customer_name']); ?></h2>
        <h3>Total Amount: ₹<?php echo number_format($bill['total_amount'], 2); ?></h3>
        <h3>Discount Applied: <?php echo $bill['discount']; ?>%</h3>
        <table>
            <tr>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Price (₹)</th>
                <th>Total (₹)</th>
            </tr>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo number_format($item['quantity'] * $item['price'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <a href="index.html">Generate New Bill</a>
    </main>
    <footer>
        <p>© 2024 Shopping Bill Management System</p>
    </footer>
</body>
</html>
