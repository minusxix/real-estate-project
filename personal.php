<?php
include_once('db/connect.php');
session_start();
?>
<?php
if(isset($_POST['save'])) {
    $id = $_POST['id'];
    $number = $_SESSION['id'];
    $sql_save = mysqli_query($con, "insert into tbl_favorite(information_code, phone_number) values('$id', '$number')");
    if($sql_save) {
        echo "<script>alert('Bài viết đã được lưu thành công.');</script>";
    } else {
        echo "<script>alert('Có lỗi xảy ra khi lưu bài viết.');</script>";
    }
}
?>
<?php
if(isset($_POST['del'])) {
    $id = $_POST['information_code'];
    $sql = mysqli_query($con, "delete from `tbl_information` where information_code = ".$id);
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
    <title>Trang Cá Nhân</title>
    <style>
        body {
            margin-top: 100px;
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <?php
    include('incl/header.php');
    ?>
    <section id="save">
        <div class="bg">
            <?php
            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
            $item_per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 10;
            $offset = ($current_page - 1) * $item_per_page;
            $id = isset($_GET['phone_number']) ? $_GET['phone_number'] : $_SESSION['id'];
            $sql_info = mysqli_query($con, "select * from tbl_information where phone_number = " . $id .
                " order by information_code desc
                limit " . $item_per_page . " offset " . $offset);
            while($row_info = mysqli_fetch_array($sql_info)) {
            ?>
            <div class='save row'>
                <div class="save-left">
                    <a href="post.php?id=<?php echo $row_info['information_code'] ?>"><img src="up/<?php echo $row_info['picture'] ?>" width="100px" height="100px"></a>
                </div>
                <div class="save-right">
                    <div class="save-right-top">
                        <p><?php echo $row_info['title']?></p>
                        <p><?php echo $row_info['acreage']?> m<sup>2</sup> - <?php echo $row_info['room']?> phòng</p>
                        <p><?php echo $row_info['price']?> tỷ</p>
                    </div>
                    <div class="save-right-bottom">
                        <p></p>
                        <form method="POST">
                            <input type="hidden" name="information_code" value="<?php echo $row_info['information_code'] ?>">
                            <?php
                            if(isset($_SESSION['id']) && $_SESSION['id'] == $_GET['phone_number']) {
                            ?>
                            <a href="http://localhost/land/edit.php?information_code=<?php echo $row_info['information_code'] ?>" title="Sửa"><i class='bx bx-edit'></i></a>
                            <input type="submit" name="del" value="Xóa">
                            <?php
                            }
                            ?>
                            <input type="submit" name="save" value="Lưu">
                        </form>
                    </div>
                </div>
            </div>
            <?php 
            }
            ?>
            <div class='paging-container'>
                <div class='paging-wrapper'>
                    <?php
                    if($current_page != 1)
                    {
                    ?>
                    <div class='paging-item'>
                        <a href="?phone_number=<?php echo $id?>&per_page=10&page=<?php echo ($current_page > 1) ? ($current_page - 1) : 1; ?>" class='paging-text'>
                            <i class='bx bx-chevron-left'></i>
                        </a>
                    </div>
                    <?php
                    }
                    ?> 
                    <?php
                    $phone_number = isset($_GET['phone_number']) ? $_GET['phone_number'] : null;
                    $sql_info = mysqli_query($con, "select count(*) as total_rows from tbl_information where phone_number = " . $phone_number);
                    $row = mysqli_fetch_assoc($sql_info);
                    $total_rows = $row['total_rows'];
                    $page_number = $total_rows/10;
                    if($total_rows % 10 != 0) {
                        $page_number += 1;
                    }
                    $i = 1;
                    while($i <= $page_number) {  
                    ?>
                    <div class='paging-item'><a href="?phone_number=<?php echo $id?>&per_page=10&page=<?php echo $i; ?>" class='paging-text'><?php echo $i ?></a></div>
                        <?php
                        $i++;
                        }
                        ?>
                        <?php
                        if($current_page < ($page_number - 1)) {
                        ?>
                        <div class='paging-item'>
                            <a href="?phone_number=<?php echo $id?>&per_page=10&page=<?php echo ($current_page < $page_number) ? ($current_page + 1) : $current_page; ?>" class='paging-text'>
                                <i class='bx bx-chevron-right'></i>
                            </a>
                        </div>
                        <?php
                        }
                        $_SESSION['area_id'] = 0;
                        ?>            
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    include('incl/footer.php');
    ?>
</body>
</html>
