<?php
    session_start();
    require_once('config/db.php');

    $type_id = $_POST['type_id'];
    $product_name = trim($_POST['product_name']);
    $product_price = trim($_POST['product_price']);
    $detail = trim($_POST['detail']);
    $img_name = $_FILES['product_img']['name'];

    $img_tmp = $_FILES['product_img']['tmp_name'];
    $folder = 'upload_img/';
    $img_location = $folder . $img_name;
    
    try{
    $stmt = $conn->prepare("INSERT INTO products(type_id, product_name, product_price, product_img, detail)
                                           VALUES(:type_id, :product_name, :product_price,:product_img, :detail)");
    if($stmt) {
        move_uploaded_file($img_tmp, $img_location);
        $_SESSION['message'] = 'Product Saved success';
    }
    $stmt->bindParam(":type_id", $type_id);
    $stmt->bindParam(":product_name", $product_name);
    $stmt->bindParam(":product_price", $product_price);
    $stmt->bindParam(":product_img", $img_name);
    $stmt->bindParam(":detail", $detail);
    $stmt->execute();
    header('location: backpage.php');
    }catch(PDOException $e){
        echo "Error" . $e->getMessage();
    }