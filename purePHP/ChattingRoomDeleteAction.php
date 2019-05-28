<?php
require_once('MySQLConection.php');

// DB 연결
$connect_object = MySQLConnection::DB_Connect();

$Target_RoomID = $_POST["DeleteingRoomID"];
$Target_UserID = $_POST["DeleteingUserID"];

// DB에 새 레코드 입력
$insertData = "(
  DELETE FROM usersinchattingroom WHERE RoomID='$Target_RoomID' AND UserID='$Target_UserID'
)";
