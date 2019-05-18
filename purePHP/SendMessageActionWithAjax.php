<?php
header("Content-Type: application/json");
require_once('C:\xampp\WebProgramming_Project\purePHP\MySQLConection.php');

$connect_object = MySQLConnection::DB_Connect();

$SenderID = $_POST['sender'];
$Message = $_POST['message'];
$RoomID = $_POST['roomID'];
$ProfileImageFileName = $_POST['profileImageFileName'];

// $AddMessageToDB = "
// Insert INTO messageboxestbl (
//     SendingUserId,
//     Message,
//     RoomID,
//     ProfileImageFileName,
//     SendingDateTime
//   ) VALUES(
//     '$SenderID',
//     '$Message',
//     '$RoomID',
//     '$ProfileImageFileName',
//     NOW()
// )";

$AddMessageToDB = "
Insert INTO ". $RoomID ." (
    SendingUserId,
    Message,
    ProfileImageFileName,
    SendingDateTime
  ) VALUES(
    '$SenderID',
    '$Message',
    '$ProfileImageFileName',
    NOW()
)";

$ret = mysqli_query($connect_object, $AddMessageToDB);

echo json_encode(array("sender" => $SenderID, "message" => $Message));
