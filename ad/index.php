<?php
include_once('../db/connect.php');
session_start();
?>
<?php
if(isset($_POST['login_admin'])) {
    $user = $_POST['user'];
    $pass = md5($_POST['pass']);
    if($user == '' || $pass == '') {
        echo '<p>Nhập đầy đủ!<p>';
    } else {
        $sql_admin = mysqli_query($con, "select * from tbl_admin where user = '$user' and pass = '$pass' limit 1");
        $count_admin = mysqli_num_rows($sql_admin);
        $row_admin = mysqli_fetch_array($sql_admin);
        if($count_admin > 0) {
            $_SESSION['admin_id'] = $row_admin['id'];
            $_SESSION['login_admin'] = $row_admin['user'];
            header('Location: dashboard.php');
        } else {
            echo '<p>Lỗi đăng nhập!<p>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Đăng Nhập</title>
    <style>
        body, html {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            border: 2px solid black;
            border-radius: 5%;
            margin: 10px;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-3" align="center">
        <h2>Đăng Nhập Admin</h2>
        <form action="" method="POST">
            <div class="mb-3 mt-3">
                <!-- <label>Tài khoản (ad)</label><br> -->
                <input type="text" name="user" placeholder="Nhập id" class="from-control">
            </div>
            <div class="mb-3">
                <!-- <label>Mật khẩu (123)</label><br> -->
                <input type="password" name="pass" placeholder="Nhập mật khẩu" class="from-control">
            </div>
            <div class="form-check mb-3">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="remember"> Remember me
                </label>
            </div>
            <button type="submit" name="login_admin" class="btn btn-primary">Đăng nhập admin</button>
        </form>
    </div>
    <!-- <h1 align="center">Đăng Nhập Admin</h1>
    <div class="from-group" align="center">
        <form action="" method="POST">
            <label>Tài khoản (ad)</label><br>
            <input type="text" name="user" placeholder="Nhập id" class="from-control"><br>
            <label>Mật khẩu (123)</label><br>
            <input type="password" name="pass" placeholder="Nhập mật khẩu" class="from-control"><br>
            <input type="submit" name="login_admin" value="Đăng nhập admin">
        </form>
    </div> -->
</body>
</html>