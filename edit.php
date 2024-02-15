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
if(isset($_POST['edit'])) {
    $information_code = isset($_GET['information_code']) ? $_GET['information_code'] : null;
    $img = $_FILES['img']['name'];
    $img_tmp = $_FILES['img']['tmp_name'];
    $business = $_POST['business'];
    $category = $_POST['category'];
    $title = $_POST['title'];
    $area = $_POST['area'];
    $address = $_POST['address'];
    $price = $_POST['price'];
    $acreage = $_POST['acreage'];
    $length = $_POST['length'];
    $width = $_POST['width'];
    $room = $_POST['room'];
    $description = $_POST['description'];
    $path = 'up/';
    $sql_insert_post = mysqli_query($con, "UPDATE `tbl_information` SET 
    `business_code` = '$business',
    `category_code` = '$category',
    `picture` = '$img',
    `title` = '$title',
    `address` = '$address',
    `price` = '$price',
    `acreage` = '$acreage',
    `width` = '$width',
    `length` = '$length',
    `room` = '$room',
    `description` = '$description',
    `date_time` = DATE_FORMAT(NOW(), '%Y-%m'),
    `area_code` = '$area' 
    WHERE `information_code` = '$information_code'");
    move_uploaded_file($img_tmp, $path.$img);   
    header("Location: personal.php?phone_number=".$_SESSION['id']); 
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
    <title>Sửa Tin</title>
</head>
<body>
<style>
    body {
        background-color: #f4f4f4;
    }
    .upload {
        display: flex;
        justify-content: space-between;
    }
    .upload a {
        font-size: 14px;
        color: blue;
    }
</style>
<section id="upload">
    <div class="upload">
        <h1><a href="index.php"><i class='bx bx-arrow-back' ></i></a>Sửa Tin</h1>
        <a href="index.php">(Trở về trang chủ)</a>
    </div>
    <?php
        $sql_inf = mysqli_query($con, "select * from tbl_information where information_code = " . $_GET['information_code']);
        if($row_inf = mysqli_fetch_assoc($sql_inf)) {
    ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <label>Sửa hình ảnh</label><br>
        <input type="file" name="img" placeholder="Hình ảnh" class="form-control"><br>
        <label>Danh mục</label><br>
        <?php
        $sql_business = mysqli_query($con, "select * from tbl_business order by business_code");
        ?>
        <select name="business" class="form-control">
            <!-- <option value="0">---Chọn---</option> -->
            <?php
            while($row_business = mysqli_fetch_array($sql_business)) {
            ?>
            <option value="<?php echo $row_business['business_code'] ?>"><?php echo $row_business['business_name'] ?></option>
            <?php
            }
            ?>
        </select>
        <br>
        <label>Loại bất động sản</label><br>
        <?php
        $sql_category = mysqli_query($con, "select * from tbl_category order by category_code");
        ?>
        <select name="category" class="form-control">
            <!-- <option value="0">---Chọn---</option> -->
            <?php
            while($row_category = mysqli_fetch_array($sql_category)) {
            ?>
            <option value="<?php echo $row_category['category_code'] ?>"><?php echo $row_category['category_name'] ?></option>
            <?php
            }
            ?>
        </select>
        <br>
        <label>Tiêu đề tin đăng</label><br>
        <input type="text" name="title" value="<?php echo $row_inf['title']?>" class="form-control"><br>
        <label>Địa chỉ tin đăng</label><br>
        <?php
        $sql_area = mysqli_query($con, "select * from tbl_area order by area_code");
        ?>
        <select name="area" class="form-control">
            <!-- <option value="0">---Chọn---</option> -->
            <?php
            while($row_area = mysqli_fetch_array($sql_area)) {
            ?>
            <option value="<?php echo $row_area['area_code'] ?>"><?php echo $row_area['area_name'] ?></option>
            <?php
            }
            ?>
        </select>
        <br>
        <input type="text" name="address" value="<?php echo $row_inf['address']?>" class="form-control"><br>
        <label>Giá bán</label><br>
        <input type="text" name="price" value="<?php echo $row_inf['price']?>" class="form-control"><br>
        <label>Diện tích</label><br>
        <input type="text" name="acreage" value="<?php echo $row_inf['acreage']?>" class="form-control"><br>
        <label>Chiều ngang</label><br>
        <input type="text" name="length" value="<?php echo $row_inf['width']?>" class="form-control"><br>
        <label>Chiều dài</label><br>
        <input type="text" name="width" value="<?php echo $row_inf['length']?>" class="form-control"><br>
        <label>Số phòng</label><br>
        <input type="text" name="room" value="<?php echo $row_inf['room']?>" class="form-control"><br>
        <label>Mô tả</label><br>
        <textarea name="description" class="form-control"><?php echo $row_inf['description']?></textarea><br>
        <?php
        if($_SESSION['id'] == $row_inf['phone_number']) {
        ?>
        <input type="submit" name="edit" value="Sửa tin">
        <?php
        }
        ?>
    </form>
    <?php
    }
    ?>
</section>
</body>
</html>