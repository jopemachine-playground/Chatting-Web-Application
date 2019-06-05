<?php
header("Content-Type: application/json");
require_once('MySQLConection.php');

$connect_object = MySQLConnection::DB_Connect('chattingroomsdb');

$SenderID = $_POST['sender'];
$MessageContent = $_POST['message'];
$RoomID = $_POST['roomID'];
$ProfileImageFileName = $_POST['profileImageFileName'];
$FileBlob = '';

// 송신된 파일이 존재하는 경우 파일을 addslash를 거쳐 Blob 형태로 DB에 넣고, 이 경우에 MessageContent는 파일 이름이 된다
// 파일이 존재하지 않는 경우 일반 메시지로 취급한다
if(!empty($_POST['file'])){
  $File =  $_POST['file'];
  $FileBlob = addslashes($File); 
}

$AddMessageToDB = "
  Insert INTO ". $RoomID ." (
    SendingUserId,
    Message,
    ProfileImageFileName,
    File,
    SendingDateTime
  ) VALUES(
    '$SenderID',
    '$MessageContent',
    '$ProfileImageFileName',
    '$FileBlob',
    NOW()
)";

$ret = mysqli_query($connect_object, $AddMessageToDB) or die("Error Occured in Inserting Message to DB");

echo json_encode(array("sender" => $SenderID, "message" => $MessageContent));
