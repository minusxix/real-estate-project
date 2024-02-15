<?php
include_once('db/connect.php');
include_once ('message_controller.php');
$mess = new MessageController();
if (isset($_POST['incoming_id'])) {
    // Xử lý dữ liệu ở đây
    error_log('incoming_id: ' . $_POST['incoming_id']);
    $mess->insertMessage();
} else {
    echo "Không có incoming_id được cung cấp!";
}
?>