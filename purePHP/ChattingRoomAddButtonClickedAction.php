<?php
require_once('C:\xampp\WebProgramming_Project\purePHP\MySQLConection.php');
// DB 연결

$connect_object = MySQLConnection::DB_Connect();

$RoomTitle = $_POST["RoomTitle"];
$RoomDesc = $_POST["RoomDesc"];
$OppenentID = $_POST["OppenentID"];
$UserID = $_COOKIE["connectedUserID"];
$Hash = 3;

$insertNewRoom = "
Insert INTO chattingroomtbl (
  Title,
  Description,
  UserID,
  Hash,
  CreatedDate
  ) VALUES(
    '$RoomTitle',
    '$RoomDesc',
    '$UserID',
    '$Hash',
    Now()
)";

$ret = mysqli_query($connect_object, $insertNewRoom);

echo ("<script>location.href='../ChattingRoomSelectorBox.php';</script>");

function HashingWithUsersAllIDAndRoomTitle($UsersAllID, $RoomTitle){

}
