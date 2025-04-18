<?php
session_start();
require_once 'config/db.php';
include 'include/menu.php';

// ตรวจสอบและตั้งค่าเริ่มต้นให้ session cart
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$productids = [];

if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $cartid => $cartqty) {
        $productids[] = $cartid;
    }

    if (!empty($productids)) {

        $placeholders = array_fill(0, count($productids), '?');

        $placeholderString = implode(',', $placeholders);

        $sql = "SELECT * FROM products WHERE product_id IN ($placeholderString)";

        $query = $conn->prepare($sql);
        $query->execute($productids);

        $products = $query->fetchAll(PDO::FETCH_ASSOC);
        $rows = count($products);
    }
} else {
    $products = [];
    $rows = 0;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body style="padding-top: 120px"></body>
    <h1 style="text-align: center">รายการสินค้า</h1>

<form action="checkout_form.php" method="post">
    <div class="row g-3" style="margin-left: 550px; margin-right: 100px;">
                        <div class="col-sm-12">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" placeholder="" value="" required>
                        </div>
                        <div class="col sm-6">
                            <label class="form-label">Tel</label>
                            <input type="text" class="form-control" name="tel" placeholder="" value="" required>
                        </div>
                        <div class="col sm-6">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" name="address" placeholder="บ้านเลขที่ ซอย(ถ้ามี) ถ./ต./อ./จ./" value="" required>
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="text-end">
                        <a href="product.php" class="btn btn-secondary btn-lg" role="button">Back</a>
                        <button class="btn btn-primary btn-lg" type="submit">Continue</button>
                    </div>
                </div>

            <div class="col-md-5 col-lg-4 order-md-last" style="margin-top: -255px; margin-left: 50px;">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Your cart</span>
                    <span class="badge bg-primary rounded-pill"><?php echo $rows; ?></span>
                </h4>

                <?php if(isset($products) && $rows > 0): ?>
                    <ul class="list-group mb-3">
                        <?php $grand_total = 0; ?>
                        <?php foreach ($products as $product): ?>
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                               
                                <div>
                                    <h6 class="my-0"><?php echo $product['product_name']; ?> (<?php echo $_SESSION['cart'][$product['product_id']]; ?>)</h6>
                                    <small class="text-body-secondary"><?php echo nl2br($product['detail']); ?></small>
                                    <input type="hidden" name="product[<?php echo $product['product_id'];?>][price]" value="<?php echo $product['product_price']; ?>">
                                    <input type="hidden" name="product[<?php echo $product['product_id'];?>][name]" value="<?php echo $product['product_name']; ?>">
                                    <input type="hidden" name="product[<?php echo $product['product_id'];?>][quantity]" value="<?php echo $_SESSION['cart'][$product['product_id']]; ?>">
                                </div>
                            </li>
                            <?php $grand_total += $_SESSION['cart'][$product['product_id']] * $product['product_price']; ?>
                        <?php endforeach; ?>
                        <li class="list-group-item d-flex justify-content-between bg-body-tertiary">
                            <div class="text-success">
                                <h6 class="my-0">Grand Total</h6>
                                <small>Amount</small>
                            </div>
                            <span class="text-success"><strong>$<?php echo number_format($grand_total)?></strong></span>
                        </li>
                    </ul>
                    <input type="hidden" name="grand_total" value="<?php echo $grand_total; ?>">
                <?php endif; ?>
            </form>
</body>
</html>