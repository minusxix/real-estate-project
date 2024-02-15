<?php
include_once('db/connect.php');
?>
<?php
if(isset($_POST['register'])) {
    $number = $_POST['number'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    if($number == '' || $password == '' || $name == '') {
        echo '<script>
            if(confirm("Nhập đầy đủ!")) {
                window.location.href = "register.php";
            }
            </script>';
    } else {
        $sql_register = mysqli_query($con, "insert into tbl_account(phone_number, password, name) values('$number', '$password', '$name')");
        echo '<script>
            if(confirm("Tạo tài khoản thành công! Đăng nhập để tiếp tục.")) {
                window.location.href = "login.php";
            }
            </script>';
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
    <title>Đăng Ký</title>
</head>
<body>
    <div class='login-layout'>
        <div class='wrapper'>
            <div class='form-login-wrapper'>
                <h2 class='login-title'>ĐĂNG KÝ</h2>
                <div class='login-inf-wrapper'>
                    <form action="" method="POST">
                        <div class='inner'>
                            <input type="text" name="name" class='input-login' placeholder='Họ và tên'></input>
                        </div>
                        <div class='inner'>
                            <input type="text" name="number" class='input-login' placeholder='Số điện thoại'></input>
                        </div>
                        <div class='inner'>
                            <input type="password" name="password" class='input-login' placeholder='Mật khẩu'></input>
                        </div>
                        <input type="submit" name="register" class='btn-login' value="ĐĂNG KÝ">
                    </form>
                </div>
                <div class='social-media-options'>
                    <span class='divider'></span>
                    <span class='divider-text'>Hoặc đăng ký bằng</span>
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
                    Đã có tài khoản?
                    <a href="login.php" class='register-option'>Đăng nhập tài khoản sẵn có</a>
                </div>
            </div>
        </div>
    </div>
</body>