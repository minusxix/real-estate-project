<?php
include_once('db/connect.php');
include_once('message_controller.php');
$chat = new MessageController();
if (isset($_POST['incoming_id'])) {
    $chat->getChat();
} else {
    echo "Không có incoming_id được cung cấp!";
}
?>