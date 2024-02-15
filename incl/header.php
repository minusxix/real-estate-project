<?php
if(isset($_GET['status'])) {
    $logout = $_GET['status'];
} else {
    $logout = '';
}
if($logout == 'logout') {
    unset($_SESSION['login']);
    session_destroy();
    header('Location: index.php');
    exit();
}
?>
<header>
    <div class="logo">
    	<a href="index.php"><img src="logo.png" alt="Logo" width="100px"></a>
    </div>
    <div class="type">  
        <div class="row">
            <i class="bx bx-menu"></i>
            <p>Danh Mục</p>
        </div>
        <ul class="sub-type">
            <li><a href="list_purchase.php">Mua Bán</a></li>
            <li><a href="list_lease.php">Cho Thuê</a></li>
        </ul>
    </div>
    <div class="search">
        <form action="search.php" method="POST"><input placeholder=" Tìm Kiếm... " name="search" type="text"><i class="bx bx-search" name="button" type="submit"></i></form>
    </div>
    <div class="heart">
        <a href="save.php" class="bx bx-heart"></a>
    </div>
    <div class="message">
        <a href="#" class="bx bx-message-rounded-dots"></a>
    </div>
    <div class="user">
        <a class="bx bx-user" id="user"></a>
        <ul class="sub-user" id="sub-user">
            <?php if(isset($_SESSION['id']) && isset($_SESSION['login'])) { ?>
            <li><a href="personal.php?phone_number=<?php echo $_SESSION['id'] ?>"><?php echo $_SESSION['login'] ?></a></li>
            <?php } ?>
            <li><a href="upload.php">Đăng tin</a></li>
            <li><a href="save.php">Tin lưu</a></li>
            <li><a href="chart.php">Biểu đồ</a></li>
            <?php if(!isset($_SESSION['id']) && !isset($_SESSION['login'])) { ?>
            <li><a href="register.php">Đăng ký</a></li>
            <li><a href="login.php">Đăng nhập</a></li>
            <?php } else { ?>
            <li><a href="?status=logout">Đăng xuất</a></li>
            <?php } ?>
        </ul>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $("#user").click(function() {
            $("#sub-user").toggle();
        });
    });
    </script>
</header>