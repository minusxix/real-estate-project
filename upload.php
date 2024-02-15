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
if(isset($_POST['upload'])) {
    $id = $_POST['id'];
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
    $sql_insert_post = mysqli_query($con, "insert into tbl_information(phone_number, picture, business_code, category_code, title, address, price, acreage, length, width, room, description, area_code)
        values('$id', '$img', '$business', '$category', '$title', '$address', '$price', '$acreage', '$length', '$width', '$room', '$description', '$area')");
    move_uploaded_file($img_tmp, $path.$img);    
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
    <title>Đăng Tin</title>
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
        <h1><a href="index.php"><i class='bx bx-arrow-back' ></i></a>Đăng Tin</h1>
        <a href="index.php">(Trở về trang chủ)</a>
    </div>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $_SESSION['id'] ?>" class="form-control"><br>
        <label>Đăng hình ảnh</label><br>
        <input type="file" name="img" placeholder="Hình ảnh" class="form-control"><br>
        <label>Danh mục</label><br>
        <?php
        $sql_business = mysqli_query($con, "select * from tbl_business order by business_code");
        ?>
        <select name="business" class="form-control">
            <option value="0">---Chọn---</option>
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
            <option value="0">---Chọn---</option>
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
        <input type="text" name="title" placeholder="Tiêu đề" class="form-control"><br>
        <label>Địa chỉ tin đăng</label><br>
        <?php
        $sql_area = mysqli_query($con, "select * from tbl_area order by area_code");
        ?>
        <select name="area" class="form-control">
            <option value="0">---Chọn---</option>
            <?php
            while($row_area = mysqli_fetch_array($sql_area)) {
            ?>
            <option value="<?php echo $row_area['area_code'] ?>"><?php echo $row_area['area_name'] ?></option>
            <?php
            }
            ?>
        </select>
        <br>
        <input type="text" name="address" placeholder="Địa chỉ" class="form-control"><br>
        <label>Giá bán</label><br>
        <input type="text" name="price" placeholder="VND" class="form-control"><br>
        <label>Diện tích</label><br>
        <input type="text" name="acreage" placeholder="" class="form-control"><br>
        <label>Chiều ngang</label><br>
        <input type="text" name="length" placeholder="" class="form-control"><br>
        <label>Chiều dài</label><br>
        <input type="text" name="width" placeholder="" class="form-control"><br>
        <label>Số phòng</label><br>
        <input type="text" name="room" placeholder="" class="form-control"><br>
        <label>Mô tả</label><br>
        <textarea name="description" class="form-control"></textarea><br>
        <button type="button" onclick="saveDraft()">Lưu nháp</button>
        <input type="submit" name="upload" value="Đăng Tin">
    </form>
</section>
<script>
function saveDraft() {
    var id = document.querySelector('input[name="id"]').value;
    var img = document.querySelector('input[name="img"]').value;
    var business = document.querySelector('select[name="business"]').value;
    var category = document.querySelector('select[name="category"]').value;
    var title = document.querySelector('input[name="title"]').value;
    var area = document.querySelector('select[name="area"]').value;
    var address = document.querySelector('input[name="address"]').value;
    var price = document.querySelector('input[name="price"]').value;
    var acreage = document.querySelector('input[name="acreage"]').value;
    var length = document.querySelector('input[name="length"]').value;
    var width = document.querySelector('input[name="width"]').value;
    var room = document.querySelector('input[name="room"]').value;
    var description = document.querySelector('textarea[name="description"]').value;
    var draft = {
        id: id,
        img: img,
        business: business,
        category: category,
        title: title,
        area: area,
        address: address,
        price: price,
        acreage: acreage,
        length: length,
        width: width,
        room: room,
        description: description
    };
    localStorage.setItem('draft', JSON.stringify(draft));
    alert('Bản nháp đã được lưu thành công!');
}
</script>
<script>
window.onload = function() {
    var draftData = localStorage.getItem('draft');
    if (draftData) {
        var draft = JSON.parse(draftData);
        document.querySelector('input[name="id"]').value = draft.id;
        document.querySelector('input[name="img"]').value = draft.img;
        document.querySelector('select[name="business"]').value = draft.business;
        document.querySelector('select[name="category"]').value = draft.category;
        document.querySelector('input[name="title"]').value = draft.title;
        document.querySelector('select[name="area"]').value = draft.area;
        document.querySelector('input[name="address"]').value = draft.address;
        document.querySelector('input[name="price"]').value = draft.price;
        document.querySelector('input[name="acreage"]').value = draft.acreage;
        document.querySelector('input[name="length"]').value = draft.length;
        document.querySelector('input[name="width"]').value = draft.width;
        document.querySelector('input[name="room"]').value = draft.room;
        document.querySelector('textarea[name="description"]').value = draft.description;
    }
}
</script>
</body>
</html>