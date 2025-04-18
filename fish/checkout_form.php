<?php
session_start();
require_once('config/db.php');


$now = date('Y-m-d H:i:s');
if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit;
}
$user_id = $_SESSION['user_id'];
$stmt_order = $conn->prepare("INSERT INTO orders (order_date, user_id, username, address, tel, grand_total) VALUES (:now, :user_id, :username, :address, :tel, :grand_total)");

$stmt_order->bindParam(':now', $now);
$stmt_order->bindParam(':user_id', $user_id);
$stmt_order->bindParam(':username', $_POST['username']);
$stmt_order->bindParam(':address', $_POST['address']);
$stmt_order->bindParam(':tel', $_POST['tel']);
$stmt_order->bindParam(':grand_total', $_POST['grand_total']);


if ($stmt_order->execute()) {
    $last_order_id = $conn->lastInsertId();
    
    foreach ($_POST['product'] as $product_id => $product_data) {

        if (isset($product_data['name'], $product_data['price'], $product_data['quantity'])) {
            $product_name = $product_data['name'];
            $price = $product_data['price'];
            $quantity = $product_data['quantity'];
            $total = $price * $quantity;
            

            $stmt_detail = $conn->prepare("INSERT INTO order_details (order_id, product_id, product_name, price, quantity, total) VALUES (:order_id, :product_id, :product_name, :price, :quantity, :total)");

            $stmt_detail->bindParam(':order_id', $last_order_id);
            $stmt_detail->bindParam(':product_id', $product_id);
            $stmt_detail->bindParam(':product_name', $product_name);
            $stmt_detail->bindParam(':price', $price);
            $stmt_detail->bindParam(':quantity', $quantity);
            $stmt_detail->bindParam(':total', $total);

            $stmt_detail->execute();
            
        } else {
            echo "Undefined array key in product_data";
        }
    }

    unset($_SESSION['cart']);
    $_SESSION['message'] = "Checkout success";
    header('location: list_check.php');
 
} else {
    $_SESSION['message'] = "Checkout not complete!";
    header('location: list_check.php');
    
}