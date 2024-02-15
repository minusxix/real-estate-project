<?php
include_once('db/connect.php');
session_start();
?>
<?php
if(isset($_SESSION['id'])) {

} else {
    header('Location: login.php');
}
?>
<?php
if(isset($_POST['del'])) {
    $id = $_POST['id'];
    $sql_del = mysqli_query($con, "delete from tbl_favorite where favorite_code = $id");
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
    <title>Lưu Tin</title>
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
            $number = $_SESSION['id'];
            $sql_info = mysqli_query($con, "select * from tbl_information 
                inner join tbl_account on tbl_information.phone_number = tbl_account.phone_number
                inner join tbl_favorite on tbl_information.information_code = tbl_favorite.information_code
                order by tbl_favorite.favorite_code desc
                limit $item_per_page offset $offset");
            while($row_info = mysqli_fetch_array($sql_info)) {
                if($row_info['phone_number'] == $number) {
            ?>
            <div class="save row">
                <div class="save-left">
                    <a href="post.php?id=<?php echo $row_info['information_code'] ?>">
                        <img src="up/<?php echo $row_info['picture'] ?>" width="100px" height="100px">
                    </a>
                </div>
                <div class="save-right">
                    <div class="save-right-top">
                        <p><?php echo $row_info['title'] ?></p>
                        <p><?php echo $row_info['acreage'] ?> m<sup>2</sup> - <?php echo $row_info['room'] ?> phòng</p>
                        <p><?php echo $row_info['price'] ?> tỷ</p>
                    </div>
                    <div class="save-right-bottom">
                        <p><?php echo $row_info['name'] ?></p>
                        <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $row_info['favorite_code'] ?>">
                            <input type="submit" name="del" value="Bỏ Lưu">
                        </form>
                    </div>
                </div>
            </div>
            <?php
                }
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
                    $sql_info = mysqli_query($con, "select count(*) as total_rows from tbl_favorite");
                    $row = mysqli_fetch_assoc($sql_info);
                    $total_rows = $row['total_rows'];
                    $page_number = $total_rows/10;
                    if($total_rows % 10 != 0) {
                        $page_number += 1;
                    }
                    $i = 1;
                    while($i <= $page_number) {  
                    ?>
                    <div class='paging-item'><a href="?page=<?php echo $i; ?>" class='paging-text'><?php echo $i ?></a></div>
                        <?php
                        $i++;
                        }
                        ?>
                        <?php
                        if($current_page < ($page_number - 1)) {
                        ?>
                        <div class='paging-item'>
                            <a href="?page=<?php echo ($current_page < $page_number) ? ($current_page + 1) : $current_page; ?>" class='paging-text'>
                                <i class='bx bx-chevron-right'></i>
                            </a>
                        </div>
                        <?php
                        }
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