<?php
include_once('db/connect.php');
if (isset($_POST['select_national'])) {
    $area_code = $_POST['select_national'];
    $data = array();
    $sql_info = mysqli_query($con, "select date_time, ROUND(AVG(price), 2) as total_price from tbl_information where area_code = ".$area_code." group by date_time");
    while ($row_info = mysqli_fetch_array($sql_info)) {
        $data[] = array(
            'year' => $row_info['date_time'],
            'value' => $row_info['total_price'],
        );
    }
}
echo $data = json_encode($data);
?>
