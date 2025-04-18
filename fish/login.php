<?php
    session_start();
    require_once 'config/db.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style/cclogin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
    <div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5" tabindex="-1" role="dialog" id="modalSignin">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-4 shadow">
        <div class="modal-header p-5 pb-4 border-bottom-0">
            <h1 class="fw-bold mb-0 fs-2">เข้าสู่ระบบ</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="goHome()"></button>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        </div>

        <div class="modal-body p-5 pt-0">
            <form action="logindb.php" method="post">
            <?php if(isset($_SESSION['error'])) {?>
                <div class="alert alert-danger" role="alert">
                    <?php
                        echo $_SESSION['error'];
                        unset ($_SESSION['error']);
                    ?>
                </div>
            <?php }?>
            <?php if(isset($_SESSION['success'])) {?>
                <div class="alert alert-success" role="alert">
                    <?php
                        echo $_SESSION['success'];
                        unset ($_SESSION['success']);
                    ?>
                </div>
            <?php }?>
            <?php if(isset($_SESSION['warning'])) {?>
                <div class="alert alert-warning" role="alert">
                    <?php
                        echo $_SESSION['warning'];
                        unset ($_SESSION['warning']);
                    ?>
                </div>
            <?php }?>
            <div class="form-floating mb-3">
                <input type="email" class="form-control rounded-3" name="email" placeholder="" required >
                <label for="floatingInput">อีเมล</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control rounded-3" name="password" placeholder="" required>
                <label for="floatingPassword">รหัสผ่าน</label>
            </div>
            <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" name="login_user">เข้าสู่ระบบ</button>
            <hr class="my-4">
            <small class="text-body-secondary">ถ้ายังไม่มีบัญชี <a href="signup.php" style="text-decoration: none;">สมัครสมาชิก</a> || <a href="index.php" style="text-decoration: none; color: red;">กลับไปหน้าหลัก</a></small>
            </form>
        </div>
        </div>
    </div>
    </div>
</body>
</html>
<script>
    function goHome() {
        window.location.href = 'index.php';
    }
</script>