<?php
session_start();

// ตรวจสอบการส่งข้อมูลจากฟอร์ม
if (isset($_POST['quantity'])) {
    foreach ($_POST['quantity'] as $product_id => $quantity) {
        // อัปเดตจำนวนสินค้าภายในตะกร้า
        $_SESSION['cart'][$product_id] = $quantity;
    }
}

// รีเฟรชหน้าปัจจุบัน (จะทำการโหลดหน้าปัจจุบันใหม่)
header('Refresh: 0; url=product.php'); // ถ้าอยากรีเฟรชที่หน้า cart.php
exit();
