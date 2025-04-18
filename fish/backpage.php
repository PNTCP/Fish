<?php
    session_start();

    if (!isset($_SESSION['admin_login'])) {
        header('location: index.php');
        exit;
    }
    

    require_once('./config/db.php');
    include ('include/menu.php');

    // ดึงข้อมูลสินค้า พร้อมหมวดหมู่ (JOIN)
    $query = $conn->query("SELECT p.*, c.category_name FROM products p LEFT JOIN categories c ON p.type_id = c.category_id");
    $products = $query->fetchAll(PDO::FETCH_ASSOC);
    $rows = count($products);

    // ดึงข้อมูลหมวดหมู่สำหรับ <select>
    $stmt = $conn->query("SELECT * FROM categories");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?php

    ?>
</head>
<body>
<div class="container" style="margin-top: 30px">
    <h4></h4>
    <div class="row g-5">
        <div class="col-md-8 col-sm-12">
            <hr class="my-4">
            <form action="product_form.php" method="post" enctype="multipart/form-data">
                <div class="row g-3 mb-3" style="padding-top: 50px;">
                    <div class="col-sm-6">
                        <label class="form-label">ชื่อ</label>
                        <input type="text" name="product_name" class="form-control" required>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">ราคา</label>
                        <input type="text" name="product_price" class="form-control" required>
                    </div>
                    <div class="col-sm-6">
                        <label for="formFile" class="form-label">รูปภาพ</label>
                        <input type="file" name="product_img" class="form-control" accept="image/png, image/jpg, image/jpeg">
                    </div>
                    <div class="col-sm-6">
                        <label for="product_type" class="form-label">หมวดหมู่</label>
                        <select name="type_id" class="form-select" required>
                            <option value="">-- กรุณาเลือกหมวดหมู่ --</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['category_id']; ?>">
                                    <?php echo htmlspecialchars($category['category_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">รายละเอียด</label>
                        <textarea name="detail" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Create</button>
                <button class="btn btn-primary" type="" style="background-color: gray;"><a href="index.php" style="text-decoration: none; color: white;">ย้อนกลับ</a></button>
                <hr class="my-4">
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table class="table table-bordered border-info">
                <thead>
                    <tr>
                        <th style="width: 100px;">Image</th>
                        <th>Product Name</th>
                        <th style="width: 200px;">Price</th>
                        <th style="width: 200px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($rows > 0): ?>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($product['product_img'])): ?>
                                        <img src="image/<?php echo $product['product_img']; ?>" width="100px">
                                    <?php else: ?>
                                        <img src="image/no_image.jpeg" width="100px">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($product['product_name']); ?>
                                    <div>
                                        <small class="text-muted">หมวดหมู่: <?php echo htmlspecialchars($product['category_name']); ?></small><br>
                                        <small class="text-muted"><?php echo nl2br(htmlspecialchars($product['detail'])); ?></small>
                                    </div>
                                </td>
                                <td><?php echo number_format($product['product_price']); ?></td>
                                <td>
                                    <a onclick="return confirm('Are you sure you want to delete?')" href="product_delete.php?id=<?php echo $product['product_id']; ?>" class="btn btn-outline-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4"><h4 class="alert alert-warning">ไม่มีรายการสินค้า</h4></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
