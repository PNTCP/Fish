<?php
require_once('config/db.php');

// Handle "Clear Cart" button
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_cart'])) {
    unset($_SESSION['cart']); // Clear the cart
    header("Location: " . $_SERVER['PHP_SELF']); // Refresh the page
    exit;
}
$user_id = $_SESSION['user_id'];
$stmt_order = $conn->prepare("INSERT INTO orders ( user_id) VALUES (:user_id)");
$stmt_order->bindParam(':user_id', $user_id);
$stmt_order->execute();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offcanvas Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        .nav i {
            font-size: 16px;
        }
        .nav .nav-link {
            color: black;
        }
        .nav .nav-link i {
            font-size: 16px; 
        }
        .nav .nav-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: black;
        }
    </style>
</head>
<body>
<header class="d-flex flex-wrap justify-content-between align-items-center py-3 mb-4 border-bottom" style="position: fixed; top: 0; width: 100%; z-index: 1030; background-color: white;">
    <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none" style="padding-left: 150px;">
        <span class="brand-name">Cgood</span>
    </a>

    <form class="d-flex mx-auto" style="width: 40%;">
        <input class="form-control me-2" type="search" placeholder="ค้นหา..." aria-label="Search">
        <button class="btn btn-outline-dark" type="submit"><i class="fa-solid fa-search"></i></button>
    </form>

    <ul class="nav nav-pills me-5">
        <li class="nav-item text-center">
            <a href="#" class="nav-link d-flex flex-column align-items-center" style="color: black;">
                <i class="fa-solid fa-bell fs-5"></i>
                <span>การแจ้งเตือน</span>
            </a>
        </li>
        <li class="nav-item dropdown text-center">
    <?php
    if (isset($_SESSION['user_login'])) {
        $user_id = $_SESSION['user_login'];
        if (isset($conn)) {
            $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row !== false) {
                echo '
                <a href="#" class="nav-link dropdown-toggle d-flex flex-column align-items-center"
                   id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-user fs-5"></i>
                    <span>' . htmlspecialchars($row['username']) . '</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">

                    <li><a class="dropdown-item" href="data_user.php">ข้อมูลผู้ใช้</a></li>
                    <li><a class="dropdown-item" href="logout.php">ลงชื่อออก</a></li>
                </ul>';
            }

        }
    } elseif (isset($_SESSION['admin_login'])) {
        $admin_id = $_SESSION['admin_login'];
        if (isset($conn)) {
            $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->bindParam(':id', $admin_id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row !== false) {
                echo '
                <a href="#" class="nav-link dropdown-toggle d-flex flex-column align-items-center"
                   id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-user fs-5"></i>
                    <span>' . htmlspecialchars($row['username']) . '</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                    <li><a class="dropdown-item" href="data_user.php">ข้อมูลผู้ดูแล</a></li>
                    <li><a class="dropdown-item" href="logout.php">ลงชื่อออก</a></li>
                </ul>';
            }
        }
    } else {
        echo '
        <a href="login.php" class="nav-link d-flex flex-column align-items-center" style="color: black;">
            <div>
                <i class="fa-solid fa-user-plus fs-5"></i>
            </div>
            <span>สมัครบัญชี</span>
        </a>';
    }
    ?>
</li>
        </div>

            <li class="nav-item text-center">
                <a href="list_check.php" class="nav-link d-flex flex-column align-items-center" style="color: black;">
                    <i class="fa-solid fa-bag-shopping fs-5"></i>
                    <span>รายการสั่งซื้อ</span>
                </a>
            </li>

            <li class="nav-item text-center">
                <?php if (!isset($_SESSION['user_login']) && !isset($_SESSION['admin_login'])): ?>
                    <a href="#" class="nav-link d-flex flex-column align-items-center" style="color: black;" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="fa-solid fa-cart-shopping fs-5"></i>
                        <span>ตะกร้าสินค้า</span>
                    </a>
                <?php else: ?>
                    <a href="#" class="nav-link d-flex flex-column align-items-center" style="color: black;" data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas" aria-controls="cartOffcanvas">
                        <i class="fa-solid fa-cart-shopping fs-5"></i>
                        <span>ตะกร้าสินค้า</span>
                    </a>
                    <?php
                    ?>
                <?php endif; ?>
            </li>
        </ul>
    </header>

<!-- Offcanvas Cart -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="cartOffcanvasLabel">ตะกร้าสินค้า</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <!-- Cart Content -->
    <form action="cart_update.php" method="post">
        <div class="cart-content">
            <table class="table">
                <thead>
                    <tr>
                        <th>สินค้า</th>
                        <th>จำนวน</th>
                        <th>ราคา</th>
                        <th>รวม</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;

                    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                        echo "<tr><td colspan='4' class='text-center'>ตะกร้าสินค้าว่างเปล่า</td></tr>";
                    } else {
                        $productids = array_keys($_SESSION['cart']);

                        $placeholders = implode(',', array_fill(0, count($productids), '?'));
                        $sql = "SELECT * FROM products WHERE product_id IN ($placeholders)";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute($productids);
                        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($products as $product) {
                            $quantity = $_SESSION['cart'][$product['product_id']];
                            $price = $product['product_price'];
                            $subtotal = $quantity * $price;
                            $total += $subtotal;

            echo "<tr>
                <td>" . htmlspecialchars($product['product_name']) . "</td>
                <td>
                    <input type='number' name='quantity[{$product['product_id']}]' value='{$quantity}' min='1' class='form-control quantity-input' data-price='{$price}' style='width: 80px;'>
                </td>
                <td>" . number_format($price) . " บาท</td>
                <td class='subtotal'>" . number_format($subtotal) . " บาท</td>
                <td>
                    <form action='cart_clear.php' method='post' style='display: inline-block;'>
                        <input type='hidden' name='product_id' value='{$product['product_id']}'>
                        <button type='submit' name='remove_item' class='btn btn-danger btn-sm'>ลบ</button>
                    </form>
                </td>
            </tr>";

      

                        }
                    }
                    ?>

                    <script>
document.addEventListener("DOMContentLoaded", function () {
    const quantityInputs = document.querySelectorAll(".quantity-input");

    quantityInputs.forEach(input => {
        input.addEventListener("input", function () {
            const price = parseFloat(this.dataset.price);
            const quantity = parseInt(this.value);
            const row = this.closest("tr");
            const subtotalCell = row.querySelector(".subtotal");

            if (!isNaN(price) && !isNaN(quantity)) {
                const subtotal = price * quantity;
                subtotalCell.textContent = subtotal.toLocaleString() + " บาท";
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const quantityInputs = document.querySelectorAll(".quantity-input");

    function updateGrandTotal() {
        let grandTotal = 0;

        document.querySelectorAll("tr").forEach(row => {
            const input = row.querySelector(".quantity-input");
            const subtotalCell = row.querySelector(".subtotal");

            if (input && subtotalCell) {
                const price = parseFloat(input.dataset.price);
                const quantity = parseInt(input.value);
                if (!isNaN(price) && !isNaN(quantity)) {
                    const subtotal = price * quantity;
                    subtotalCell.textContent = subtotal.toLocaleString() + " บาท";
                    grandTotal += subtotal;
                }
            }
        });

        const grandTotalElement = document.querySelector(".grand-total");
        if (grandTotalElement) {
            grandTotalElement.textContent = grandTotal.toLocaleString() + " บาท";
        }
    }

    quantityInputs.forEach(input => {
        input.addEventListener("input", updateGrandTotal);
    });
});
</script>

                </tbody>

                <?php if (!empty($_SESSION['cart'])): ?>
                <tfoot>
                    <tr>
                        <td colspan='3' class='text-end'><strong>รวมทั้งหมด</strong></td>
                        <td><strong class="grand-total"><?php echo number_format($total); ?> บาท</strong></td>
                    </tr>
                </tfoot>
                <?php endif; ?>
            </table>

            <div class="text-end">
                <form method="post" action="cart_clear.php" style="display: inline-block;">
                    <button type="submit" name="clear_cart" class="btn btn-danger">ล้างตะกร้า</button>
                </form>
                <?php if (!empty($_SESSION['cart'])): ?>
                <a href="checkout.php" class="btn btn-primary">ชำระเงิน</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</form>
</div>



    <!-- Login Required Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">โปรดเข้าสู่ระบบ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="fs-5">คุณต้องลงชื่อเข้าใช้ก่อนเพื่อเข้าถึงตะกร้าสินค้า</p>
                    <a href="login.php" class="btn btn-primary">ลงชื่อเข้าใช้</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const offcanvas = document.getElementById('cartOffcanvas');
            const cartToggleButton = document.querySelector('[data-bs-target="#cartOffcanvas"]');

            // Ensure proper behavior when the offcanvas is shown
            offcanvas.addEventListener('shown.bs.offcanvas', function () {
                document.body.classList.remove('modal-open'); // Remove Bootstrap's modal-open class
                document.body.style.overflow = 'auto'; // Ensure scrolling is enabled
            });

            // Ensure proper behavior when the offcanvas is hidden
            offcanvas.addEventListener('hidden.bs.offcanvas', function () {
                document.body.style.overflow = 'auto'; // Reset scrolling
                const backdrop = document.querySelector('.offcanvas-backdrop');
                if (backdrop) {
                    backdrop.remove(); // Remove the backdrop manually if it persists
                }
            });

            // Remove custom click detection logic to avoid conflicts
            // Bootstrap already handles outside clicks and backdrop behavior
        });
    </script>

    <!-- Add the provided script here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const userDropdown = document.getElementById('userDropdown');
        if (userDropdown) {
            new bootstrap.Dropdown(userDropdown);
        }

        const adminDropdown = document.getElementById('adminDropdown');
        if (adminDropdown) {
            new bootstrap.Dropdown(adminDropdown);
        }

        const offcanvas = document.getElementById('cartOffcanvas');
        if (offcanvas) {
            offcanvas.addEventListener('shown.bs.offcanvas', function () {
                document.body.classList.remove('modal-open');
                document.body.style.overflow = 'auto';
            });

            offcanvas.addEventListener('hidden.bs.offcanvas', function () {
                document.body.style.overflow = 'auto';
                const backdrop = document.querySelector('.offcanvas-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
            });
        }
    });
    </script>
</body>
</html>