<?php
require_once('MySQLConection.php');

// DB 연결
$connect_object = MySQLConnection::DB_Connect('chattingdb');

$Target_RoomID = $_POST["DeleteingRoomID"];
$Target_UserID = $_POST["DeleteingUserID"];

// DB에 새 레코드 입력
$deleteData = "
  DELETE FROM usersinchattingroom WHERE RoomID ='$Target_RoomID' AND UserID ='$Target_UserID'
";

$ret = mysqli_query($connect_object, $deleteData);

// 채팅방에 아무도 남아 있지 않으면 채팅방을 제거한다.
// 채팅방 레코드와 함께 채팅방 로그에 해당하는 테이블 전체를 제거한다.
$searchRemainUserExist = "
  SELECT * FROM usersinchattingroom WHERE RoomID = '$Target_RoomID'
";

$deleteChattingRoom = "
  DELETE FROM chattingroomtbl WHERE RoomID ='$Target_RoomID'
";

$deleteChattingRoomTable = "DROP TABLE chattingroomsdb." . $Target_RoomID;

$ret = mysqli_query($connect_object, $searchRemainUserExist);

$row = mysqli_fetch_array($ret);

if(empty($row)){
  $ret = mysqli_query($connect_object, $deleteChattingRoom);
  $connect_object = MySQLConnection::DB_Connect('chattingroomsdb');
  $ret = mysqli_query($connect_object, $deleteChattingRoomTable);
}

