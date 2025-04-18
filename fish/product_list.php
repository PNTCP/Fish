<?php
    session_start();
    require_once('config/db.php');

    $query = $conn->query("SELECT * FROM products");
    $products = $query->fetchAll(PDO::FETCH_ASSOC);
    $rows = count($products);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/bootstrap.css" rel="stylesheet">
    <title>Product</title>
</head>
<body class="bg-body-tertiary" style="padding-top: 50px;">
    <script src="style/bootstrap.js"></script>
    <?php include 'include/menu.php'; ?>
    <div class="container" style="margin-top: 30px;"></div>
    
    <?php if (!empty($_SESSION['message'])): ?>
        <div class="alert alert-success" role="alert">
            <?php
                echo $_SESSION['message'];
                unset ($_SESSION['message']);
            ?>
        </div>
    <?php endif; ?>

    <div class ="container">
    <h4>Product</h4>
                </form>
            <?php if ($rows > 0): ?>
                <?php foreach ($products as $product): ?>
                    <div class="col-3 mb-3">
                        <div class="card" style="width: 18rem;">
                            <?php if (!empty($product['product_img'])): ?>
                                <img src="image/<?php echo $product['product_img']; ?>" class="card-img-top" width="100px">
                            <?php else: ?>
                                <img src="image/no_image.jpg" class="card-img-top" width="100px">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $product['product_name']; ?></h5>
                                <p class="card-text text-success mb-0"><?php echo number_format($product['product_price']); ?></p>
                                <p class="card-text text-nuted"><?php echo nl2br(htmlspecialchars($product['detail'])); ?></p>
                                <?php
                                    if (isset($_SESSION['user_login'])){
                                        echo '<a href="cart_add.php?id=' .$product['product_id']. '" class="btn btn-outline-primary w-100">Add Cart</a>';
                                    }elseif (isset($_SESSION['admin_login'])){
                                        echo '<a href="cart_add.php?id=' .$product['product_id']. '" class="btn btn-outline-primary w-100">Add Cart</a>';
                                    }else{
                                        echo '<a href="login.php"><button type="button" class="btn btn-outline-primary w-100">Login</button></a>';
                                    }
                                ?>
                                
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>