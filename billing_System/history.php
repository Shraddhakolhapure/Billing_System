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

$stmt = $pdo->query("SELECT * FROM bills ORDER BY created_at DESC");
$bills = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill History</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Bill History</h1>
    </header>
    <main>
        <table>
            <tr>
                <th>Customer Name</th>
                <th>Total Amount</th>
                <th>Discount</th>
                <th>Date</th>
                <th>View</th>
            </tr>
            <?php foreach ($bills as $bill): ?>
                <tr>
                    <td><?php echo htmlspecialchars($bill['customer_name']); ?></td>
                    <td>₹<?php echo number_format($bill['total_amount'], 2); ?></td>
                    <td><?php echo $bill['discount']; ?>%</td>
                    <td><?php echo $bill['created_at']; ?></td>
                    <td><a href="view_bill.php?id=<?php echo $bill['id']; ?>">View</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </main>
    <footer>
        <p>© 2024 Shopping Bill Management System</p>
    </footer>
</body>
</html>
