<?php
session_start();
require_once('config/db.php');
include('include/menu.php');

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$product_id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = :id");
$stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "<div class='alert alert-danger mt-5 text-center'>ไม่พบข้อมูลสินค้า</div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>รายละเอียดสินค้า</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body style="padding: 30px; padding-top: 100px;">
    <div class="container">
        <div class="card mb-3 shadow-lg">
            <div class="row g-0">
                <div class="col-md-5">
                    <img src="image/<?php echo !empty($product['product_img']) ? $product['product_img'] : 'no_image.jpeg'; ?>" 
                         class="img-fluid rounded-start" alt="product image" style="height: 100%; object-fit: cover;">
                </div>
                <div class="col-md-7">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo htmlspecialchars($product['product_name']); ?></h3>
                        <h5 class="text-success fw-bold"><?php echo number_format($product['product_price']); ?> บาท</h5>
                        <p class="card-text text-muted"><?php echo nl2br(htmlspecialchars($product['detail'])); ?></p>

                        <div class="mt-4">
                            <?php if (isset($_SESSION['user_login']) || isset($_SESSION['admin_login'])): ?>
                                <a href="cart_add.php?id=<?php echo $product['product_id']; ?>" class="btn btn-primary">เพิ่มลงตะกร้า</a>
                            <?php else: ?>
                                <a href="login.php" class="btn btn-outline-secondary">เข้าสู่ระบบเพื่อสั่งซื้อ</a>
                            <?php endif; ?>
                            <a href="<?php echo isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'product.php'; ?>" 
                                class="btn btn-secondary">
                                    กลับไปหน้าสินค้า
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
