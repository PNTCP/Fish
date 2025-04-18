<?php
session_start();
include("config/db.php");

if (!empty($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch product information for deleting
    $stmt_select = $conn->prepare("SELECT * FROM products WHERE product_id = :product_id");
    $stmt_select->bindParam(':product_id', $product_id);
    $stmt_select->execute();
    $result = $stmt_select->fetch(PDO::FETCH_ASSOC);

    if ($result) {

        @unlink('upload_img/' . $result['product_img']);

        $stmt_delete = $conn->prepare("DELETE FROM products WHERE product_id = :product_id");
        $stmt_delete->bindParam(':product_id', $product_id);
        $stmt_delete->execute();

        if ($stmt_delete->rowCount() > 0) {
            $_SESSION['message'] = 'Product Deleted successfully';
            header('location: backpage.php');
            exit;
        } else {
            $_SESSION['message'] = 'Product could not be deleted';
        }
    } else {
        $_SESSION['message'] = 'Product not found';
    }
}

header('location: backpage.php');