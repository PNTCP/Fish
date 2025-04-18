<?php
session_start();
require_once('config/db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/bootstrap.css" rel="stylesheet">
    <title>Result Order</title>
</head>
<body class="bg-body-tertiary">
    <script src="style/bootstrap.js"></script>
    <?php include 'include/menu.php'; ?>
    <div class="container" style="margin-top: 30px;"></div>
    
    <?php if (!empty($_SESSION['message'])): ?>
        <div class="alert alert-success" role="alert">
            <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            ?>
        </div>
    <?php endif; ?>

        </div>
    </form>
</body>
</html>