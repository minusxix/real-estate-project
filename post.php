<?php
include_once('db/connect.php');
session_start();
?>
<?php
if(isset($_POST['save'])) {
    $id = $_GET['id'];
    $number = $_SESSION['id'];
    $sql_save = mysqli_query($con, "insert into tbl_favorite(information_code, phone_number) values('$id', '$number')");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="grid.css">
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Tin Đăng</title>
</head>
<body>
    <?php
    include('incl/header.php');
    ?>
    <section id="post">
        <div class="post row">
            <div class="post-left row">
                <?php
                $id = $_GET['id'];
                $sql_info = mysqli_query($con, 'select * from tbl_information 
                    inner join tbl_business on tbl_information.business_code = tbl_business.business_code
                    inner join tbl_category on tbl_information.category_code = tbl_category.category_code
                    inner join tbl_area on tbl_information.area_code = tbl_area.area_code
                    order by information_code');
                while($row_info = mysqli_fetch_array($sql_info)) {
                    if($row_info['information_code'] == $id) {
                ?>
                <div class="post-big">    
                    <img src= "up/<?php echo $row_info['picture'] ?>" width="500px" height="500px">
                </div>
                <!-- <div class="post-small">                
                    <img src="7.webp" width="100px" height="100px">
                    <img src="7.webp" width="100px" height="100px">
                    <img src="7.webp" width="100px" height="100px">
                    <img src="7.webp" width="100px" height="100px">
                    <div class="zoom">
                        <p>More</p>
                    </div>
                </div> -->
            </div>
            <div class="post-right">
                <div class="post-title">
                    <p><?php echo $row_info['business_name'] ?> > <?php echo $row_info['category_name'] ?> > <?php echo $row_info['area_name'] ?></p>
                    <h1><?php echo $row_info['title'] ?></h1>
                    <p><?php echo $row_info['address'] ?></p>
                </div>
                <div class="post-price">
                    <div class="post-price-left">
                        <p><?php echo $row_info['price'] ?> tỷ</p>
                        <p>- <?php echo $row_info['acreage'] ?> m<sup>2</sup></p>
                    </div>
                    <div class="post-price-right">
                        <?php
                        $currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                        ?>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($currentURL); ?>" target="_blank">
                            <i class='bx bx-share'></i>
                            <i class='bx bxl-facebook-circle'></i>
                        </a>
                        <?php
                        if(isset($_SESSION['id'])) {
                        ?>
                        <form method="POST">
                            <input type="submit" name="save" value="Lưu">
                        </form>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="post-info">
                    <div class="post-info-left">
                        <p>Diện tích: <?php echo $row_info['acreage'] ?></p>
                        <p>Số phòng: <?php echo $row_info['room'] ?></p>
                    </div>
                    <div class="post-info-right">
                        <p>Chiều ngang: <?php echo $row_info['width'] ?></p>
                        <p>Chiều dài: <?php echo $row_info['length'] ?></p>
                    </div>
                </div>
                <div class="post-more">
                    <p>Mô tả:<br><?php echo $row_info['description'] ?></p>
                </div>
                <?php
                    }
                }
                ?>
                <div class="account">
                    <div class="account-top row">
                        <img src="img/avatar.jpg" width="50px" height="50px">
                        <div class="account-info">
                            <?php
                            $id = $_GET['id'];
                            $sql_account = mysqli_query($con, 'select * from tbl_information inner join tbl_account on tbl_information.phone_number = tbl_account.phone_number');
                            while($row_account = mysqli_fetch_array($sql_account)) {
                                $phone_number = $row_account['phone_number'];
                                if($row_account['information_code'] == $id) {
                            ?>
                            <a href="personal.php?phone_number=<?php echo $row_account['phone_number'] ?>"><p><?php echo $row_account['name'] ?></p></a>
                            <a href="personal.php?phone_number=<?php echo $row_account['phone_number'] ?>">Xem trang</a>
                        </div>
                        <i class='bx bxs-show'></i>
                    </div>
                    <div class="account-bottom">
                        <div class="account-call">
                            <a href="tel:+84<?php echo $row_account['phone_number'] ?>"><i class='bx bx-phone-call'> Liên hệ </i></a>
                            <?php
                                $_SESSION['phone_user'] = $row_account['phone_number'];
                                }
                            }
                            ?>
                        </div>
                        <div class="account-chat">
                            <i class='bx bx-chat'><a href="chat_box.php?phone_number=<?php echo $_SESSION['phone_user'] ?>"> Nhắn tin </a></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="account"></section>
    <section id="hot">
        <div class="hot-top">
            <h1>Tin Mới Bất Động Sản:</h1>
        </div>
        <div class="row">
            <?php
            $sql_hot = mysqli_query($con, "select * from tbl_information order by information_code desc limit 6");
            while($row_hot = mysqli_fetch_array($sql_hot)) {
            ?>
            <div class="item col l-2">
                <a href="post.php?id=<?php echo $row_hot['information_code'] ?>"><img src="up/<?php echo $row_hot['picture']?>" width="150px" height="150px"></a>
                <h1><?php echo $row_hot['title']?></h1>
                <p><?php echo $row_hot['acreage']?>m2 - <?php echo $row_hot['room']?> phòng</p>
                <p><?php echo $row_hot['price']?> tỷ</p>
            </div>
            <?php
            }
            ?>
        </div>
    </section>
    <?php
    include('incl/footer.php');
    ?>
</body>
</html>