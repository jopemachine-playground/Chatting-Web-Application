<?php
require_once('C:\xampp\WebProgramming_Project\purePHP\MySQLConection.php');
require_once('C:\xampp\WebProgramming_Project\purePHP\MessageWindow.php');

$connect_object = MySQLConnection::DB_Connect();

$RoomID = $_GET['RoomID'];
$ID = $_POST['connectedUserID'];

// $searchAllUsersMessages = "
//   SELECT * FROM chatroomusertbl WHERE RoomID = '$RoomID'
// ";
//
// $searchAllUsersMessages = "
//   SELECT * FROM messagetbl WHERE Sender = '$ID' OR Sender =
// ";

$searchUserChattingRoomBoxes = "
SELECT *
FROM chatroomusertbl
INNER JOIN messagetbl
ON chatroomusertbl.UserID = messagetbl.Sender
WHERE chatroomusertbl.UserID = '$ID'
";

$ret = mysqli_query($connect_object, $searchUserChattingRoomBoxes);

// while($row = mysqli_fetch_array($ret)){
//
// }

for(let i = 0; !empty(mysqli_fetch_array($ret); i++)){

  MessageWindow::$updateIndex += 1;

  if(i < MessageWindow::$updateIndex){
    continue;
  }

}
