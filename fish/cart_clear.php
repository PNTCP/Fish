<?php
session_start();

// ตรวจสอบว่า login แล้ว
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'กรุณาล็อกอินก่อน';
    header('location: login.php');
    exit();
}

// ลบตะกร้า
if (isset($_SESSION['cart'][$_SESSION['user_id']])) {
    unset($_SESSION['cart'][$_SESSION['user_id']]); // ลบตะกร้าของผู้ใช้คนนี้
    $_SESSION['message'] = 'ตะกร้าของคุณถูกล้างแล้ว';
} else {
    $_SESSION['message'] = 'ตะกร้าของคุณยังไม่มีสินค้า';
}

header('location: cart.php'); // แสดงหน้าตะกร้า หรือ หน้าอื่นๆ ที่คุณต้องการ
exit();
?>
