<?php
header("Content-Type: application/json");
require_once('MySQLConection.php');

$connect_object = MySQLConnection::DB_Connect('chattingroomsdb');

$SenderID = $_POST['sender'];
$MessageContent = $_POST['message'];
$RoomID = $_POST['roomID'];
$ProfileImageFileName = $_POST['profileImageFileName'];

$AddMessageToDB = "
  Insert INTO ". $RoomID ." (
    SendingUserId,
    Message,
    ProfileImageFileName,
    SendingDateTime
  ) VALUES(
    '$SenderID',
    '$MessageContent',
    '$ProfileImageFileName',
    NOW()
)";

$ret = mysqli_query($connect_object, $AddMessageToDB);

echo json_encode(array("sender" => $SenderID, "message" => $Message));
