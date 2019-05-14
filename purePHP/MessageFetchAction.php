<?php
require_once('C:\xampp\WebProgramming_Project\purePHP\MySQLConection.php');
require_once('C:\xampp\WebProgramming_Project\purePHP\MessageWindow.php');

$connect_object = MySQLConnection::DB_Connect();

$UserID = $_COOKIE['connectedUserID'];
$RoomID = $_POST['RoomID'];

// $searchAllUsersMessages = "
//   SELECT * FROM chatroomusertbl WHERE RoomID = '$RoomID'
// ";
//
// $searchAllUsersMessages = "
//   SELECT * FROM messagetbl WHERE Sender = '$ID' OR Sender =
// ";

$searchUserChattingRoomBoxes = "
SELECT *
FROM chattingroomtbl
INNER JOIN messageboxestbl
ON chattingroomtbl.UserID = messageboxestbl.SendingUserId
WHERE chattingroomtbl.UserID = '$UserID'
";

$ret = mysqli_query($connect_object, $searchUserChattingRoomBoxes);

$i = 0;

while($row = mysqli_fetch_array($ret)){

  MessageWindow::$updateIndex += 1;

  // 이미 업데이트 된 메시지를 다시 만들지 않게 함
  if($i++ < MessageWindow::$updateIndex){
    continue;
  }
  
  echo MessageWindow::CreateMessageWindow($row['SendingUserId'], $row['SendingDateTime'], $row['Message']);

}
