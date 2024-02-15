<?php
session_start();
$area_id = $_POST['area_id'];
$_SESSION['area_id'] = $area_id; 
echo $data = json_encode($data);
?>
