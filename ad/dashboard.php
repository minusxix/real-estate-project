<?php
include_once('../db/connect.php');
?>
<?php
session_start();
if(!isset($_SESSION['login_admin'])) {
    header('Location: dashboard.php');
}
?>
<?php
if(isset($_GET['status'])) {
    $logout = $_GET['status'];
} else {
    $logout = '';
}
if($logout == 'logout') {
    unset($_SESSION['login_admin']);
    header('Location: index.php');
}
?>
<?php
if(isset($_GET['del_user'])) {
    $id_user = $_GET['del_user'];
    $sql_del = mysqli_query($con, "delete from tbl_account where phone_number = $id_user");
}
?>
<?php
if(isset($_GET['del_post'])) {
    $id_post = $_GET['del_post'];
    $sql_del = mysqli_query($con, "delete from tbl_information where information_code = $id_post");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Chào Mừng</title>
    <style>
        table {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            text-align: center;
            border: 1px solid black;
        }
        .user {
            display: none;
        }
        .info {
            text-align: center;
        }
        .info1, .info2 {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand">Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                <a class="nav-link info2">Danh sách tin đăng</a>
                </li>
                <li class="nav-item">
                <a class="nav-link info1">Danh sách tài khoản</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="?status=logout">Đăng xuất</a>
                </li>
            </ul>
            <!-- <form class="d-flex">
                <input class="form-control me-2" type="text" placeholder="Search">
                <button class="btn btn-primary" type="button">Search</button>
            </form> -->
            </div>
        </div>
    </nav> 
    <!-- <h1 align="center">Admin</h1>
    <p align="center"><a href="?status=logout">Đăng xuất</a></p>
    <div class="info">
        <p><a class="info2">Danh sách tin đăng</a> | 
        <a class="info1">Danh sách tài khoản</a></p>
    </div> -->
    <div class="post">
        <div class="top">
            <?php
            $search_term = '';
            if (isset($_GET['search_term'])) {
                $search_term = mysqli_real_escape_string($con, $_GET['search_term']);
            }
            $sql_search = "select * from tbl_information, tbl_business, tbl_category, tbl_account
                where tbl_information.business_code = tbl_business.business_code
                and tbl_information.category_code = tbl_category.category_code
                and tbl_information.phone_number = tbl_account.phone_number
                and (
                    tbl_information.title like '%$search_term%'
                    or tbl_information.address like '%$search_term%'
                    or tbl_information.price like '%$search_term%'
                    or tbl_account.name like '%$search_term%'
                )
                order by information_code desc limit 100";
            $result_post = mysqli_query($con, $sql_search);
            $sql_count_post = mysqli_query($con, "select * from tbl_information");
            $count_search_term = mysqli_num_rows($sql_count_post);
            ?>
            <form action="" method="get">
                <input type="text" name="search_term" placeholder="Search...">
                <input type="submit" value="Search">
            </form>
        </div>
        <h3>Danh sách tin đăng</h3>
        <p>Có tất cả <?php echo $count_search_term ?> tin đăng</p>
        <table class="post">
            <tr>
                <th>STT</th>
                <th>Loại kinh doanh</th>
                <th>Loại bất động sản</th>
                <th>Hình ảnh</th>
                <th>Tiêu đề</th>
                <th>Địa chỉ</th>
                <th>Giá (tỷ)</th>
                <th>Diện tích</th>
                <th>Số phòng</th>
                <th>Người đăng</th>
                <th>Quản lý</th>
            </tr>
            <?php
            $i = 0;
            while ($row_post = mysqli_fetch_array($result_post)) {
                $i++;
            ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $row_post['business_name'] ?></td>
                    <td><?php echo $row_post['category_name'] ?></td>
                    <td><img src="../up/<?php echo $row_post['picture'] ?>" height="50" width="50"></td>
                    <td><?php echo $row_post['title'] ?></td>
                    <td><?php echo $row_post['address'] ?></td>
                    <td><?php echo $row_post['price'] ?></td>
                    <td><?php echo $row_post['acreage'] ?></td>
                    <td><?php echo $row_post['room'] ?></td>
                    <td><?php echo $row_post['name'] ?></td>
                    <td><a href="../post.php?id=<?php echo $row_post['information_code'] ?>">Xem</a> | <a href="?del_post=<?php echo $row_post['information_code'] ?>" onclick="alert('Xóa?')">Xóa</a></td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>
    <div class="user">
        <div class="top">
            <?php
            $search = '';
            if (isset($_GET['search'])) {
                $search = mysqli_real_escape_string($con, $_GET['search']);
            }
            $sql_account = "select * from tbl_account
                where name like '%$search%'
                or phone_number like '%$search%' limit 100";
            $result_user = mysqli_query($con, $sql_account);
            $sql_count_user = mysqli_query($con, "select * from tbl_account");
            $count_search = mysqli_num_rows($sql_count_user);
            ?>
            <br>
            <form action="" method="get">
                <input type="text" name="search" placeholder="Search...">
                <input type="submit" value="Search">
            </form>
        </div>
        <h3>Danh sách tài khoản</h3>
        <p>Có tất cả <?php echo $count_search ?> tài khoản</p>    
        <table>
            <tr>
                <th>STT</th>
                <th>Tên</th>
                <th>Số điện thoại</th>
                <th>Quản lý</th>
            </tr>
            <?php
            $i = 0;
            while($row_user = mysqli_fetch_array($result_user)) {
                $i++;
            ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row_user['name'] ?></td>
                <td><?php echo $row_user['phone_number'] ?></td>
                <td><a href="../personal.php?phone_number=<?php echo $row_user['phone_number'] ?>" target="_blank">Xem</a> | <a href="?del_user=<?php echo $row_user['phone_number'] ?>" onclick="alert('Xóa?')">Xóa</a></td>
            </tr>
            <?php
            }
            ?>
        </table>
    </div>
</body>
<script>
    const info1 = document.querySelector(".info1")
    const info2 = document.querySelector(".info2")
    if(info1) { 
        info1.addEventListener("click", function() {
            document.querySelector(".user").style.display = "block"
            document.querySelector(".post").style.display = "none"
        })
    }
    if(info2) { 
        info2.addEventListener("click", function() {
            document.querySelector(".post").style.display = "block"
            document.querySelector(".user").style.display = "none"
        })
    }
</script>
</html>