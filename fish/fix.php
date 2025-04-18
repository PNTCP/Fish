<?php
    session_start();
    require_once('config/db.php');
    include('include/menu.php');

    $query = $conn->query("SELECT * FROM products");
    $products = $query->fetchAll(PDO::FETCH_ASSOC);
    $rows = count($products);
    $cat_stmt = $conn->query("SELECT * FROM categories");
    $categories = $cat_stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($categories as $category): ?>
        <a href="product.php?category=<?= $category['category_id'] ?>" class="dropdown-item">
        </a>
    <?php endforeach; ?>
    <?php
        if (isset($_GET['category'])) {
            $category_id = $_GET['category'];
            $stmt = $conn->prepare("SELECT * FROM products WHERE type_id = ?");
            $stmt->execute([$category_id]);
        } else {
            $stmt = $conn->query("SELECT * FROM products");
        }
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/index.css">
</head>
<body style="padding-top: 20px;">
<?php if(isset($_SESSION['success'])) {?>
                <div class="alert alert-success" role="alert">
                    <?php
                        echo $_SESSION['success'];
                        unset ($_SESSION['success']);
                    ?>
                </div>
            <?php }?>
<div class="menu-bar" style="margin-top: 80px;">
    <a href="index.php" class="nav-link d-flex flex-column align-items-center">
        <i class="fa-solid fa-house fs-3"></i>
        หน้าหลัก
    </a>
    <a href="product.php" class="nav-link d-flex flex-column align-items-center">
        <i class="fa-solid fa-store fs-3"></i>
        สินค้า
    </a>
    <a href="contact.php" class="nav-link d-flex flex-column align-items-center">
        <i class="fa-solid fa-address-book fs-3"></i>
        ติดต่อพวกเรา
    </a>
        <?php if (isset($_SESSION['admin_login'])): ?>
        <a href="backpage.php" class="nav-link d-flex flex-column align-items-center">
            <i class="fa-solid fa-user-cog fs-3"></i>
            Admin
        </a>
    <?php endif; ?>
</div>
<div id="carouselExample" class="carousel slide" data-bs-ride="carousel" style="margin: 20px 80px;">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="https://transcode-v2.app.engoo.com/image/fetch/f_auto,c_lfill,w_300,dpr_3/https://assets.app.engoo.com/images/x7jPxj9YtJfv97hnC3mMmQog5VwuYojZ7tlrhczGXIV.jpeg" class="d-block w-100" alt="Image 1" style="height: 500px; object-fit: cover; border-radius: 15px;">
        </div>
        <div class="carousel-item">
            <img src="https://i.ytimg.com/vi/R1KIXldYNls/maxresdefault.jpg?sqp=-oaymwEmCIAKENAF8quKqQMa8AEB-AHUBoAC4AOKAgwIABABGGUgVChIMA8=&rs=AOn4CLBDDPyAqihZhcI9Qxg7M1V_uoYCvg" class="d-block w-100" alt="Image 2" style="height: 500px; object-fit: cover; border-radius: 15px;">
        </div>
        <div class="carousel-item">
            <img src="https://ihavecpu.com/_next/image?url=https%3A%2F%2Fihcupload.s3.ap-southeast-1.amazonaws.com%2Fimg%2Fslidebanner%2F174055782567bece01bfbab.&w=1200&q=75" class="d-block w-100" alt="Image 3" style="height: 500px; object-fit: cover; border-radius: 15px;">
        </div>
        <div class="carousel-item">
            <img src="https://cms.dmpcdn.com/travel/2021/05/17/ef287e00-b6bb-11eb-a753-ed580dade28e_original.jpg" class="d-block w-100" alt="Image 4" style="height: 500px; object-fit: cover; border-radius: 15px;">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<div style="margin-left: 60px; background-color: gray; margin-top: 40px; margin-right: 83%; padding: 20px; border-radius: 20px; display: flex; align-items: center;">
    <i class="fa-solid fa-boxes-stacked fs-3 me-2"></i> 
    <h4>หมวดหมู่</h4>
</div>
<div class="container-item" style="margin-right: 50px; margin-left: 50px;">
<ul class="dropdown-menu position-static ms-5 d-grid gap-1 p-2 rounded-5 mx-0 shadow w-220px border-secondary"
    style="max-width: 290px; max-height: 300px;" data-bs-theme="light">
    <?php foreach ($categories as $category): ?>
        <li>
            <a class="dropdown-item rounded-2" href="type.php?category=<?php echo $category['category_id']; ?>">
                <?php echo htmlspecialchars($category['category_name']); ?>
            </a>
        </li>
        <li><hr class=""></li>
    <?php endforeach; ?>
</ul>

    <div class="col-md-9">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        <?php foreach ($products as $product): ?>
            <div class="col">
                <div class="card shadow-sm" style="height: 100%;">
                    <?php if (!empty($product['product_img'])): ?>
                        <div class="bg-light rounded-top"
                            style="height: 300px;
                            background-image: url('image/<?php echo $product['product_img']; ?>');
                            background-size: 280px;
                            background-position: center;
                            background-repeat: no-repeat;">
                            
                        </div>
                    <?php else: ?>
                        <div class="bg-light rounded-top"
                            style="height: 300px;
                            background-image: url('image/no_image.jpeg');
                            background-size: cover;
                            background-position: center;
                            background-repeat: no-repeat;">
                        </div>
                    <?php endif; ?>
                    <div class="card-body text-center">
                        <h6 class="text-muted"><?php echo $product['product_name']; ?></h6>
                        <p class="text-success fw-bold"><?php echo number_format($product['product_price']); ?> บาท</p>
                        <p class="text-muted small"><?php echo nl2br(htmlspecialchars($product['detail'])); ?></p>
                        <?php if (isset($_SESSION['user_login']) || isset($_SESSION['admin_login'])): ?>
                            <a href="cart_add.php?id=<?php echo $product['product_id']; ?>" class="btn btn-outline-primary w-100">Add Cart</a>
                        <?php else: ?>
                            <a href="login.php"><button type="button" class="btn btn-outline-primary w-100">Login</button></a>
                        <?php endif; ?>
                        <form action="product_detail.php" method="get" class="w-100 mb-2">
                            <input type="hidden" name="id" value="<?php echo $product['product_id']; ?>">
                            <button type="submit" class="btn btn-info w-100">ดูรายละเอียด</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
</div>


</div>
<script>
    var myCarousel = document.querySelector('#carouselExample');
    var carousel = new bootstrap.Carousel(myCarousel, {
        interval: 5000, // 5 seconds
        ride: 'carousel'
    });
</script>
<style>
    
</style>
</body>
</html>