<?php
header("Content-Type: application/json");
require_once('MySQLConection.php');

$connect_object = MySQLConnection::DB_Connect('chattingroomsdb');

$SenderID = $_POST['sender'];
$MessageContent = $_POST['message'];
$RoomID = $_POST['roomID'];
$ProfileImageFileName = $_POST['profileImageFileName'];
$FileBlob = '';

if(!empty($_POST['file'])){
  $File =  $_POST['file'];
  $FileBlob = addslashes($File); 
}

// var_dump($SenderID);
// var_dump($MessageContent);
// var_dump($RoomID);
// var_dump($ProfileImageFileName);

var_dump($File); // 73.8
var_dump($FileBlob); // 152
var_dump(stripslashes($FileBlob)); // 147

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
