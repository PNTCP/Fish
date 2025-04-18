<?php
session_start();
include('config/db.php');

// ตรวจสอบว่า login แล้ว
if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = 'Please login first';
    header('location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if (!empty($_GET['id'])) {
    $product_id = $_GET['id'];

    // ตรวจสอบว่า user มีตะกร้าอยู่แล้วหรือยัง
    if (empty($_SESSION['cart'][$user_id][$product_id])) {
        $_SESSION['cart'][$user_id][$product_id] = 1;
    } else {
        $_SESSION['cart'][$user_id][$product_id] += 1;
    }

    $_SESSION['message'] = 'Cart Add Success';
}

header('location: product.php');
