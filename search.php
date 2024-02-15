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
if(isset($_POST['search'])) {
    $key = $_POST['search'];
    $sql_search = mysqli_query($con, "select * from tbl_information, tbl_account, tbl_area
        where tbl_information.phone_number = tbl_account.phone_number
        and tbl_information.area_code = tbl_area.area_code
        and (
            tbl_information.title like '%$key%'
            or tbl_information.phone_number like '%$key%'
            or tbl_information.address like '%$key%'
            or tbl_information.description like '%$key%'
            or tbl_account.name like '%$key%'
            or tbl_area.area_name like '%$key%'
        )
        order by information_code desc limit 10");
    $title = $key;
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
    <title>Tìm Kiếm</title>
</head>
<body>
    <?php
    include('incl/header.php');
    ?>
    <section id="save">
        <div class="bg">
            <div class="save row">
                <?php
                while($row_info = mysqli_fetch_array($sql_search)) {
                ?>
                <div class="save-left">
                    <a href="post.php?id=<?php echo $row_info['information_code'] ?>"><img src="up/<?php echo $row_info['picture'] ?>" width="100px" height="100px"></a>
                </div>
                <div class="save-right">
                    <div class="save-right-top">
                        <p><?php echo $row_info['title'] ?></p>
                        <p><?php echo $row_info['acreage'] ?> m<sup>2</sup> - <?php echo $row_info['room'] ?> phòng</p>
                        <p><?php echo $row_info['price'] ?> tỷ</p>
                    </div>
                    <div class="save-right-bottom">
                        <p><?php echo $row_info['name'] ?></p>
                        <a href="save.php"><i class='bx bx-heart'></i></a>
                        <?php
                        if(isset($_SESSION['id'])) {
                        ?>
                        <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $row_info['information_code'] ?>">
                            <input type="submit" name="save" value="Lưu">
                        </form>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>
    <?php
    include('incl/footer.php');
    ?>
</body>
<script>
    const search = document.getElementById('search');
    document.addEventListener('click', function(event) {
        if (!search.contains(event.target)) {
            const openSearchBox = document.getElementById('key');
            openSearchBox.checked = false;
        }
    });
</script>
</html>