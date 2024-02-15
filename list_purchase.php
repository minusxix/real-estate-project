<?php
ini_set('session.cookie_lifetime', 86400); // 86400 seconds (1 day)
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="grid.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Mua Bán</title>
</head>
<body>
    <?php
    include('incl/header.php');
    ?>
    <script>
        $(document).ready(function() {
            $("#select").change(function() {
                var selectedValue = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "get_area_id.php",
                    data: { area_id: selectedValue },
                    success: function(data) {
                        selectedValue = JSON.parse(data);
                    }
                });
            });
        });
    </script>
    <section id="filter" class='list-container'>
        <div class="body-wrapper">
            <div class="body-left">
                <div class="body-left-top">
                    <div class="quick-filter-wrapper">
                        <div class="quick-filter-content">
                            <a href="?category=2" class="quick-filter-link">
                                <div class="quick-filter-item">
                                    <img src="img/house.jpg" class="quick-filter-item-icon">
                                    <span>Nhà</span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="quick-filter-wrapper">
                        <div class="quick-filter-content">
                            <a href="?category=1" class="quick-filter-link">
                                <div class="quick-filter-item">
                                    <img src="img/land.jpg" class="quick-filter-item-icon">
                                    <span>Đất</span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="quick-filter-wrapper">
                        <div class="quick-filter-content">
                            <a href="?category=3" class="quick-filter-link">
                                <div class="quick-filter-item">
                                    <img src="img/apartment.jpg" class="quick-filter-item-icon">
                                    <span>Chung cư</span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="quick-filter-wrapper">
                        <div class="quick-filter-content">
                            <a href="?category=4" class="quick-filter-link">
                                <div class="quick-filter-item">
                                    <img src="img/business.jpg" class="quick-filter-item-icon">
                                    <span>Mặt bằng</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="arrange-wrapper" style='height: 40px'>
                    <select class='form-control province' id='select' style='width: 90px;' onchange="reloadPage(this)">
                        <option value="0">Khu vực</option>
                        <?php
                        $sql_info = mysqli_query($con, "select * from tbl_area");
                        $i = 1; 
                        while($row_info = mysqli_fetch_array($sql_info)) {
                        ?>
                        <option value="<?php echo $i; ?>"><?php echo $row_info['area_name']; ?></option>  
                        <?php
                        $i++;
                        }
                        ?>
                    </select>
                    <script>
                        function reloadPage(selectElement) {
                            // Get the selected value from the <select>
                            var selectedValue = selectElement.value;
                            // Reload the page
                            location.reload();
                        }
                    </script>
                    <a href="?category=<?php echo $_SESSION['category'] ?>&filter=1&arrange=<?php echo $_SESSION['arrange'] ?>">Dưới 2 tỷ</a>
                    <a href="?category=<?php echo $_SESSION['category'] ?>&filter=2&arrange=<?php echo $_SESSION['arrange'] ?>">2 tỷ - 4 tỷ</a>
                    <a href="?category=<?php echo $_SESSION['category'] ?>&filter=3&arrange=<?php echo $_SESSION['arrange'] ?>">4 tỷ - 10 tỷ</a>
                    <a href="?category=<?php echo $_SESSION['category'] ?>&filter=4&arrange=<?php echo $_SESSION['arrange'] ?>">Trên 10 tỷ</a>
                    <?php
                    $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
                    ?>
                    <a href="?category=<?php echo $_SESSION['category'] ?>&filter=<?php echo $filter; ?>&arrange=1">Tăng dần</a>
                    <a href="?category=<?php echo $_SESSION['category'] ?>&filter=<?php echo $filter; ?>&arrange=2">Giảm dần</a>
                </div>
                <div class="save-wrapper">
                    <div>
                        <?php
                        $item_per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 10;
                        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $offset = ($current_page - 1) * $item_per_page;
                        $_SESSION['arrange'] = isset($_GET['arrange']) ? $_GET['arrange'] : null;
                        $_SESSION['category'] = isset($_GET['category']) ? $_GET['category'] : 0;
                        $area_id = isset($_SESSION['area_id']) ? $_SESSION['area_id'] : 0;
                        $_SESSION['filter'] = $filter;
                        $value_left = 0.0;
                        $value_right = 10000.0;
                        if($_SESSION['filter'] == 1) {
                            $value_right = 2.0;
                        } else if($_SESSION['filter'] == 2) {
                            $value_left = 2.0;
                            $value_right = 4.0;
                        } else if($_SESSION['filter'] == 3) {
                            $value_left = 4.0;
                            $value_right = 10.0;
                        }
                        if($_SESSION['arrange'] == 1) {
                            $orderByClause = " price ASC ,";
                        } else if ($_SESSION['arrange'] == 2) {
                            $orderByClause = " price DESC ,";
                        } else {
                            $orderByClause = "";
                        }
                        if($_SESSION['category'] == 0) {
                            $category_query = "";
                        } else {
                            $category_query = " and category_code = " .$_SESSION['category'];
                        }
                        if($area_id == 0) {
                            $area = "";
                        } else {
                            $area = " and area_code = ".$area_id;
                        }         
                        $sql_info = mysqli_query($con, "select * from tbl_information
                            inner join tbl_account on tbl_information.phone_number = tbl_account.phone_number
                            where business_code = 1 ". $category_query ." 
                            ".$area." and price > ".$value_left." and price <= ".$value_right." order by ".$orderByClause."
                            information_code DESC limit ". $item_per_page ." offset ". $offset);                    
                        while($row_info = mysqli_fetch_array($sql_info)) {
                        ?>
                        <div class='save-row-wrapper'>
                            <div class="save-left">
                                <a href="post.php?id=<?php echo $row_info['information_code'] ?>">
                                    <img src="up/<?php echo $row_info['picture'] ?>" width="100px" height="100px">
                                </a>
                            </div>
                            <div class="save-right">
                                <div class="save-right-top">
                                    <p><?php echo $row_info['title']?></p>
                                    <p><?php echo $row_info['acreage']?> m<sup>2</sup> - <?php echo $row_info['room']?> phòng</p>
                                    <p><?php echo $row_info['price']?> tỷ</p>
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
                        </div>
                        <?php 
                        }
                        ?>
                    </div>
                </div>
                <div class='paging-container'>
                    <div class='paging-wrapper'>
                        <?php
                        if($current_page != 1) {
                        ?>
                        <div class='paging-item'>
                            <a href="?per_page=10&page=<?php echo ($current_page > 1) ? ($current_page - 1) : 1; ?>" class='paging-text'>
                                <i class='bx bx-chevron-left'></i>
                            </a>
                        </div>
                        <?php
                        }
                        ?>
                        <?php
                        $sql_info = mysqli_query($con, "select count(*) AS total_rows from tbl_information
                            where business_code = 1 ".$category_query." ".$area." and price > ".$value_left."
                            and price <= ".$value_right);
                        $row = mysqli_fetch_assoc($sql_info);
                        $total_rows = $row['total_rows'];
                        $page_number = $total_rows/10;
                        if($total_rows % 10 != 0) {
                            $page_number += 1;
                        }
                        $i = 1;
                        while($i <= $page_number) {
                        ?>
                        <div class='paging-item'><a href="?per_page=10&page=<?php echo $i; ?>
                            &filter=<?php echo $filter; ?>&arrange=<?php echo $_SESSION['arrange']; ?>
                            &category=<?php echo $_SESSION['category'] ?>"
                            class='paging-text'><?php echo $i ?></a>
                        </div>
                        <?php
                        $i++;
                        }
                        ?>
                        <?php
                        if($current_page < ($page_number - 1)) {
                        ?>
                        <div class='paging-item'>
                            <a href="?per_page=10&page=<?php echo ($current_page < $page_number) ? ($current_page + 1) : $current_page; ?>" class='paging-text'>
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
    $_SESSION['area_id'] = 0;
    ?>
</body>
</html>
