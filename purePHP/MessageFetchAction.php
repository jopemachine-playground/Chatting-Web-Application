<?php
require_once('C:\xampp\WebProgramming_Project\purePHP\MySQLConection.php');
require_once('C:\xampp\WebProgramming_Project\purePHP\MessageWindow.php');

$connect_object = MySQLConnection::DB_Connect();

$UserID = $_COOKIE['connectedUserID'];
$RoomID = $_POST['RoomID'];
$UpdatedIndex = $_POST['UpdatedIndex'];

$searchUserChattingRoomBoxes = "
SELECT * FROM messageboxestbl WHERE RoomID = '$RoomID'
";

$ret = mysqli_query($connect_object, $searchUserChattingRoomBoxes);

$i = 0;

while($row = mysqli_fetch_array($ret)){

  // 이미 업데이트 된 메시지를 다시 만들지 않게 함
  if($i++ < $UpdatedIndex){
    continue;
  }

  echo MessageWindow::CreateMessageWindow(
    $row['SendingUserId'],
    $row['SendingDateTime'],
    $row['Message'],
    $row['ProfileImageFileName']);
}
