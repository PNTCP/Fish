<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_login']) && !isset($_SESSION['admin_login'])) {
    header('location: login.php');
}

$user_id = isset($_SESSION['user_login']) ? $_SESSION['user_login'] : $_SESSION['admin_login'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/bootstrap.css" rel="stylesheet">
    <title>History </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body class="bg-body-tertiary">
    <script src="style/bootstrap.js"></script>
    <?php include 'include/menu.php'; ?>
    <div class="container" style="margin-top: 150px;"></div>
    <div class="container">
        <h4>รายการสั่งซื้อสินค้า</h4>
        <div class="row">
            <div class="col-12">
                <form action="cart_update.php" method="post">
                    <table class="table table-bordered border-secondary"> 
                        <thead>
                            <tr>
                                <th style="width: 100px">รหัสรายการสินค้า</th>
                                <th style="width: 100px">ชื่อรายการสั่งซื้อ</th>
                                <th style="width: 50px">จำนวนสินค้า</th>
                                <th style="width: 100px;">ราคาทั้วหมด</th>
                                <th style="width: 100px;">วันที่ทำการสั่งซื้อ</th>
                                <th style="width: 100px;">สถานะการจัดส่ง</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT od.product_name, od.total, o.order_date, o.order_status, od.quantity, od.order_id
                                    FROM orders o
                                    INNER JOIN order_details od ON o.id = od.order_id  WHERE o.user_id = :user_id ORDER BY o.order_date DESC";


                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                            $stmt->execute();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $status = $row['order_status'];
                            ?>
                                <tr>
                                    <td><?php echo $row['order_id']; ?></td>
                                    <td><?php echo $row['product_name']; ?></td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td><?php echo $row['total']; ?></td>
                                    <td><?php echo $row['order_date']; ?></td>
                                    <td>
                                        <?php
                                        if ($status == 1) {
                                            echo "กำลังจัดส่ง";
                                        } elseif ($status == 2) {
                                            echo "จัดส่งเสร็จสิ้น";
                                        } else {
                                            echo "จัดการพัสดุ";
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</body>

</html>