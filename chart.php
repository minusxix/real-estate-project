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
    <link rel="stylesheet" href="style.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <title>Biểu Đồ</title>
</head>
<body>
    <?php
    include('incl/header.php');
    ?>
    <div style='margin: 100px 30px 10px; height: 25px;'>
        <select class='form-control province' id='select' style='height: 25px;'>
            <!-- <option value="0">---Chọn khu vực---</option> -->
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
    <?php
    include('incl/footer.php');
    ?>
</body>
</html>