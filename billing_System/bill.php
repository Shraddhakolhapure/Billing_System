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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customerName = $_POST['customerName'];
    $discount = isset($_POST['discount']) ? $_POST['discount'] : 0;
    $itemNames = $_POST['itemName'];
    $quantities = $_POST['quantity'];
    $prices = $_POST['price'];

    // Calculate total
    $totalAmount = 0;
    for ($i = 0; $i < count($itemNames); $i++) {
        $totalAmount += $quantities[$i] * $prices[$i];
    }

    // Apply discount
    $totalAmount -= ($totalAmount * $discount) / 100;

    // Insert bill into database
    $stmt = $pdo->prepare("INSERT INTO bills (customer_name, discount, total_amount) VALUES (?, ?, ?)");
    $stmt->execute([$customerName, $discount, $totalAmount]);
    $billId = $pdo->lastInsertId();

    // Insert items into database
    for ($i = 0; $i < count($itemNames); $i++) {
        $stmt = $pdo->prepare("INSERT INTO bill_items (bill_id, item_name, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->execute([$billId, $itemNames[$i], $quantities[$i], $prices[$i]]);
    }

    // Redirect to the view bill page
    header("Location: view_bill.php?id=$billId");
    exit();
}
?>
