<?php
include_once('config/config.php');
session_start();
?>
<?php
class MessageController{
    private Config $conn;
    public function __construct()
    {
        if(!isset($_SESSION)){
            session_start();
        }
        $this->conn = new Config();
    }
    public function insertMessage(){
        $outgoing_id = $_SESSION['message_outgoing'];
        var_dump($outgoing_id);
        $incoming_id = mysqli_real_escape_string($this->conn->connect(), $_POST['incoming_id']);
        var_dump($incoming_id);
        $message = mysqli_real_escape_string($this->conn->connect(), $_POST['message']);
        var_dump($message);
        if(!empty($message)){
            $sql = "insert into tbl_message (incoming_msg_id, outgoing_msg_id, msg)
            values (".$incoming_id.", ".$outgoing_id.", '{$message}')";
            mysqli_query($this->conn->connect(), $sql) or die();
        }
    }
    public function getChat(){
        $outgoing_id = $_SESSION['message_outgoing'];
        $incoming_id = mysqli_real_escape_string($this->conn->connect(), $_POST['incoming_id']);
        $output = "";
        $sql = "select * from tbl_message left join tbl_account on tbl_account.message_id = tbl_message.outgoing_msg_id
        where (outgoing_msg_id = ".$outgoing_id." and incoming_msg_id = ".$incoming_id.")
        or (outgoing_msg_id = ".$incoming_id." and incoming_msg_id = ".$outgoing_id.") order by tbl_message.message_id";
        $query = mysqli_query($this->conn->connect(), $sql) or die();
        if(mysqli_num_rows($query)){
            while($row = mysqli_fetch_assoc($query)){
                if($row['outgoing_msg_id'] === $outgoing_id){
                    $output .= "<div class='chat outgoing'>
                                    <div class='details'>
                                        <p>".$row['msg']."</p>
                                    </div>
                                </div>";
                }else{
                    $output .= "<div class='chat incoming'>
                                    <div class='details'>
                                        <p>".$row['msg']."</p>
                                    </div>
                                </div>";
                }
            }
        }
        else{
            $output .= "<div class='text'>Không có tin nhắn. Khi bạn có, tin nhắn sẽ hiện tại đây.</div>";
        }
        echo $output;
    }
}
?>
