<?php

require_once('MySQLConection.php');

$InvitedUserID = $_POST['InvitedUserID'];
$RoomID = $_POST['RoomID'];

$connect_object = MySQLConnection::DB_Connect("chattingdb");

// DB에서 PK (ID) 를 찾음
$searchUserID = "
  SELECT * FROM usersinchattingroom WHERE UserID = '$InvitedUserID' AND RoomID = '$RoomID'
";

$ret = mysqli_query($connect_object, $searchUserID);
$row = mysqli_fetch_array($ret);

// 이미 채팅방에 존재하는 유저일 경우 에러
if(!empty($row)){
    echo "이미 채팅방에 존재하는 계정입니다.";
    exit();
}

// 채팅방에 없는 초대받은 유저가 존재하는 경우 chattingRoomTbl에 추가하면
// 해당 유저가 채팅방에 접근할 수 있게 된다
$insertNewUser = "
  Insert INTO usersinchattingroom (
    RoomID,
    UserID
    ) VALUES(
      '$RoomID',
      '$InvitedUserID'
)";

// 존재하지 않는 유저를 초대한 경우, 에러
$ret = mysqli_query($connect_object, $insertNewUser) or die('error occur');

echo "초대에 성공했습니다";