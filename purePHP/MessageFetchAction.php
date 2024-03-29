<?php
require_once('MySQLConection.php');
require_once('MessageWindow.php');

$connect_object = MySQLConnection::DB_Connect("chattingroomsdb");

if(empty($_COOKIE['connectedUserID']) | empty($_POST['RoomID'])){
  exit();
}

$UserID = $_COOKIE['connectedUserID'];
$RoomID = $_POST['RoomID'];
 
// 이미 업데이트 된 메시지를 다시 만들지 않게 함
// Primary Key + Auto Index => 빠른 조회가 가능.
$UpdatedIndex = $_POST['UpdatedIndex'];

$searchUserChattingRoomBoxes = "
  SELECT * FROM " . $RoomID . " WHERE MessageIndex > '$UpdatedIndex'";

$ret = mysqli_query($connect_object, $searchUserChattingRoomBoxes);

while($row = mysqli_fetch_array($ret)){

  echo MessageWindow::CreateMessageWindow(
    $row['SendingUserId'],
    $row['SendingDateTime'],
    $row['Message'],
    $row['ProfileImageFileName'],
    $row['File'],
    $row['MessageIndex']
  );
}
