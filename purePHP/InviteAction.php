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

if(!empty($row)){
    echo "이미 채팅방에 존재하는 계정입니다.";
    exit();
}

$insertNewUser = "
  Insert INTO usersinchattingroom (
    RoomID,
    UserID
    ) VALUES(
      '$RoomID',
      '$InvitedUserID'
)";

$ret = mysqli_query($connect_object, $insertNewUser) or die('error occur');

echo "초대에 성공했습니다";