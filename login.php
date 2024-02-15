<?php
include_once('db/connect.php');
session_start();
?>
<?php
if(isset($_POST['login'])) {
    $number = $_POST['number'];
    $password = $_POST['password'];
    if($number == '' || $password == '') {
        echo '<script>
            if(confirm("Nhập đầy đủ!")) {
                window.location.href = "login.php";
            }
            </script>';
    } else {
        $sql_login = mysqli_query($con, "select * from tbl_account where phone_number = '$number' and password = '$password' limit 1");
        $count = mysqli_num_rows($sql_login);
        $row_login = mysqli_fetch_array($sql_login);
        if($count > 0) {
            $_SESSION['login'] = $row_login['name'];
            $_SESSION['id'] = $row_login['phone_number'];
            header('Location: index.php');
        } else {
            echo '<script>alert("Lỗi đăng nhập!");</script>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Đăng Nhập</title>
</head>
<body>
    <div class='login-layout'>
        <div class='wrapper'>
            <div class='form-login-wrapper'>
                <h2 class='login-title'>ĐĂNG NHẬP</h2>
                <div class='login-inf-wrapper'>
                    <form action="" method="POST">
                        <div class='inner'>
                            <input type="text" name="number" class='input-login' placeholder='Số điện thoại'></input>
                        </div>
                        <div class='inner'>
                            <input type="password" name="password" class='input-login' placeholder='Mật khẩu'></input>
                        </div>
                        <a href="#" class='forgot-password'>Quên mật khẩu?</a>
                        <input type="submit" name="login" class='btn-login' value="ĐĂNG NHẬP">
                    </form>
                </div>
                <div class='social-media-options'>
                    <span class='divider'></span>
                    <span class='divider-text'>Hoặc đăng nhập bằng</span>
                    <span class='divider'></span>
                </div>
                <div class='login-method'>
                    <button class='btn-wrapper'>
                        <img src='img/facebook.jpg' class='btn-icon'/>
                        Facebook
                    </button>
                    <button class='btn-wrapper'>
                        <img src='img/google.jpg' class='btn-icon'/>
                        Google
                    </button>
                    <button class='btn-wrapper'>
                        <img src='img/apple.jpg' class='btn-icon'/>
                        Apple ID
                    </button>
                </div>
                <div class='footer'>
                    Chưa có tài khoản?
                    <a href="register.php" class='register-option'>Đăng ký tài khoản mới</a>
                </div>
            </div>
        </div>
    </div>
</body>