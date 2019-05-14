<?php
header("Content-Type: application/json");
require_once('C:\xampp\WebProgramming_Project\purePHP\MySQLConection.php');

$connect_object = MySQLConnection::DB_Connect();

$SenderID = $_POST['sender'];
$Message = $_POST['message'];

$AddMessageToDB = "
Insert INTO usersinfotbl (
    Sender,
    Message,
    SendingTime
  ) VALUES(
    '$SenderID',
    '$Message',
    NOW()
)";

$ret = mysqli_query($connect_object, $AddMessageToDB);

echo json_encode(array("sender" => $SenderID, "message" => $Message));
