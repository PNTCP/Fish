<?php
    session_start();
    require_once('config/db.php');

    if(isset($_POST['login_user'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "ใส่อีเมลไม่ถูกต้อง";
            header('location: login.php');
            exit();
        } else if(strlen($password) < 6) {
            $_SESSION['error'] = "รหัสผ่านไม่ถูกต้อง";
            header('location: login.php');
            exit();
        } else {
            try {
                $check_data = $conn->prepare("SELECT * FROM users WHERE email = :email");
                $check_data->bindParam(':email', $email);
                $check_data->execute();


                if($check_data->rowCount() > 0) {
                    $row = $check_data->fetch(PDO::FETCH_ASSOC);

                    if (!password_verify($password, $row['password'])) {
                        $_SESSION['error'] = "รหัสผ่านไม่ถูกต้อง";
                        header('location: login.php');
                        exit();
                    } else if ($row['urole'] == 'admin') {
                        $_SESSION['admin_login'] = $row['id'];
                        $_SESSION['user_id'] = $row['id'];
                        header('location: index.php');
                        exit();
                    } else {
                        $_SESSION['user_login'] = $row['id'];
                        $_SESSION['user_id'] = $row['id'];
                        header('location: index.php');
                        exit();
                    }
                } else {
                    $_SESSION['error'] = "ไม่พบข้อมูล";
                    header('location: login.php');
                    exit();
                }
            } catch(PDOException $e) {
                $_SESSION['error'] = "เกิดข้อผิดพลาด: " . $e->getMessage();
                header('location: login.php');
                exit();
            }
        }
    }
    $user_id = $_SESSION['user_id'];

?>
