<?php
    session_start();
    require_once('config/db.php');

    $errors = array();

    if(isset($_POST['reg_user'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $tel = $_POST['tel'];
        $confirmpassword = $_POST['confirmpassword'];
        $address = $_POST['address'];
        $urole = 'user';
    

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "ใส่อีเมลไม่ถูกต้อง";
        header('location: signup.php');
    }else if(strlen($password) < 6) {
        $_SESSION['error'] = "รหัสผ่านต้องมีอย่างน้อย 6 ตัว";
        header('location: signup.php');
    }else if($password != $confirmpassword) {
        $_SESSION['error'] = "รหัสผ่านไม่ตรงกัน";
        header('location: signup.php');
    }else if ($tel < 10) {
        $_SESSION['error'] = "เบอร์โทรต้องมีอย่างน้อย 10 ตัว";
        header('location: signup.php');
    }else {
        try{
            $check_email = $conn->prepare("SELECT email FROM users WHERE email = :email");
            $check_email->bindParam(':email', $email);
            $check_email->execute();
            $check_user = $conn->prepare("SELECT username FROM users WHERE username = :username");
            $check_user->bindParam(':username', $username);
            $check_user->execute();

            if($check_email->rowCount() > 0) {
                $_SESSION['error'] = "อีเมลนี้มีผู้ใช้งานแล้ว" ;
                header('location: signup.php');
            }else {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO users (username, email, password, tel, address, urole) 
                                        VALUES (:username, :email, :password, :tel, :address, :urole)");
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $passwordHash);
                $stmt->bindParam(':tel', $tel);
                $stmt->bindParam(':address', $address);
                $stmt->bindParam(':urole', $urole);
                $stmt->execute();
                $_SESSION['success'] = "สมัครสมาชิกสำเร็จ";
                header('location: index.php');
            }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} 

        
}
?>