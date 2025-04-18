<?php
    session_start();
    require_once('./config/db.php');
    include ('include/menu.php');
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
<body style="padding-top: 120px; text-align: center;">
    <h2 style="text-align: center;">ติดต่อพวกเราได้ที่</h2>
    <i class="fa-brands fa-facebook" style="padding-top: 50px; font-size: 20px;">
        <span>Facebook</span> :
        <a href="https://www.facebook.com/nattapon.chanprom" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Nattapon Chanprom</a>
    </i>
    <br><br>
    <i class="fa-brands fa-facebook" style="padding-top: 20px; font-size: 20px;">
        <span>Facebook</span> :
        <a href="https://www.facebook.com/sarayut.dechpaeng/" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Sarayut Dechpaeng</a>
    </i>
    <a href="index.php"><button style="display: block; margin: 50px auto 0; padding: 10px 20px; font-size: 16px;" class="btn btn-primary">ย้อนกลับไปหน้าหลัก</button></a>
</body>
</html>