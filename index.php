<?php
include_once('db/connect.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="grid.css">
    <link rel="stylesheet" href="style.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <title>Trang Chủ</title>
</head>
<body>
    <?php
    include('incl/header.php');
    ?>
    <section id="slider">
        <div class="slider-show">
            <div class="slider">
                <img src="img/1.webp" width="100%" alt="">
                <!-- <img src="2.webp" width="100%" alt=""> -->
            </div>
            <!-- <div class="arrow">
                <div class="prev control"><i class='bx bx-chevron-left-circle'></i></div>
                <div class="next control"><i class='bx bx-chevron-right-circle'></i></div>
            </div>
            <div class="index">
                <div class="index-item index-item-0 active"></div>
                <div class="index-item index-item-1"></div>
                <div class="index-item index-item-2"></div>
                <div class="index-item index-item-3"></div>
            </div> -->
        </div>
    </section> 
    <section id="type">
        <div class="row">
            <div class="button col l-3">
                <a href="list_purchase.php"><img src="img/3.png" width="100px" height="100px"></a>
                <h1>Mua Bán</h1>
            </div>
            <div class="button col l-3">
                <a href="list_lease.php"><img src="img/4.webp" width="100px" height="100px"></a>
                <h1>Cho Thuê</h1>
            </div>
            <div class="button col l-3">
                <a href="chart.php"><img src="img/5.png" width="100px" height="100px"></a>
                <h1>Biểu Đồ</h1>
            </div>
            <div class="button col l-3">
                <img src="img/6.webp" width="100px" height="100px">
                <h1>Vay Mua</h1>
            </div>
        </div>
    </section>
    <section id="sell">
        <div class="sell-top">
            <p>Mua bán Bất Động Sản:</p>
        </div>
        <div class="row">
            <?php
            $sql_sell = mysqli_query($con, "select * from tbl_information where business_code = 1 order by information_code desc limit 6");
            while($row_sell = mysqli_fetch_array($sql_sell)) {
            ?>
            <div class="item col l-2">
                <a href="post.php?id=<?php echo $row_sell['information_code'] ?>"><img src="up/<?php echo $row_sell['picture']?>" width="150px" height="150px"></a>
                <h1><?php echo $row_sell['title']?></h1>
                <p><?php echo $row_sell['acreage']?>m2 - <?php echo $row_sell['room']?> phòng</p>
                <p><?php echo $row_sell['price']?> tỷ</p>
            </div>
            <?php
            }
            ?>
        </div>
        <div class="sell-bottom">
            <a href="list_purchase.php">Xem thêm</a>
        </div>
    </section>
    <section id="rent">
        <div class="rent-top">
            <p>Cho thuê Bất Động Sản:</p>
        </div>
        <div class="row">
            <?php
            $sql_rent = mysqli_query($con, "select * from tbl_information where business_code = 2 order by information_code desc limit 6");
            while($row_rent = mysqli_fetch_array($sql_rent)) {
            ?>
            <div class="item col l-2">
                <a href="post.php?id=<?php echo $row_rent['information_code'] ?>"><img src="up/<?php echo $row_rent['picture']?>" width="150px" height="150px"></a>
                <h1><?php echo $row_rent['title']?></h1>
                <p><?php echo $row_rent['acreage']?>m2 - <?php echo $row_rent['room']?> phòng</p>
                <p><?php echo $row_rent['price']?> tỷ</p>
            </div>
            <?php
            }
            ?>
        </div>
        <div class="rent-bottom">
            <a href="list_lease.php">Xem thêm</a>
        </div>
    </section>
    <section id="chart">
        <div class="chart row">
            <div class="chart-left">
                <p>Biểu đồ giá Bất Động Sản:</p>
            </div>
            <div class="chart-right">
                <select class='form-control province' id='select' style='height: 25px;'>
                    <?php
                    $sql_info = mysqli_query($con, "select * from tbl_area");
                    $i = 1;
                    while ($row_info = mysqli_fetch_array($sql_info)) {
                    ?>
                    <option value="<?php echo $i; ?>">
                        <?php echo $row_info['area_name']; ?>
                    </option>
                    <?php
                        $i++;
                    }
                    ?>
                </select>
            </div>
        </div>
        <div id="myfirstchart" style="height: 250px;"></div>
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                var chartData;
                var area_code = 1; // Giá trị mặc định
                $.ajax({
                    type: 'POST',
                    url: 'get_chart_data.php',
                    data: {
                        select_national: area_code
                    },
                    success: function(data) {
                        chartData = JSON.parse(data);
                        char.setData(chartData);
                    }
                });
                $(".province").change(function() {
                    var area_code = $(".province").val();
                    $.ajax({
                        type: 'POST',
                        url: 'get_chart_data.php',
                        data: {
                            select_national: area_code
                        },
                        success: function(data) {
                            chartData = JSON.parse(data);
                            char.setData(chartData);
                        }
                    });
                });
                // Initialize the chart with default data
                char = new Morris.Area({
                    element: 'myfirstchart',
                    data: chartData,
                    xkey: 'year',
                    ykeys: ['value'],
                    labels: ['Giá'],
                    parseTime: false,
                    xLabelAngle: 0,
                    padding: 60,
                    hoverCallback: function(index, options, content, row) {
                        var formattedValue = '<span style="font-size: 16px;">Giá: ' + row.value + ' Tỷ</span>';
                        return formattedValue;
                    },
                });
            });
        </script>
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