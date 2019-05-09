<?php
require_once('C:\xampp\WebProgramming_Project\purePHP\MySQLConection.php');

// DB 연결
$connect_object = MySQLConnection::DB_Connect();

$RoomTitle = $_POST["RoomTitle"];
$RoomDesc = $_POST["RoomDesc"];
$OppenentID = $_POST["OppenentID"];
$UserID = $_COOKIE["connectedUserID"];

$searchRoomIndex = "
  SELECT * FROM usersinchattingroom WHERE UserID = '$UserID'
";

$ret = mysqli_query($connect_object, $searchRoomIndex);

# Hasing 값은 UserID, Index로 결정된다.
# 이 값은 ID로 사용할 수 없는 특수문자로 결합됨.
# 즉, 어떤 유저가 채팅방을 만들 때 항상 DB에 없는 고유의 값을 지니게 됨
# 따라서, 이 Hashing 값을 사용하면 데이터 무결성이 보장됨 (해시 충돌이 일어나는 경우는 예외로 함)
$HashingRoomID = Hashing("sha256", mysqli_num_rows($ret), $UserID);

$insertNewRoom = "
Insert INTO chattingroomtbl (
  Title,
  Description,
  Chief,
  RoomID,
  CreatedDate
  ) VALUES(
    '$RoomTitle',
    '$RoomDesc',
    '$UserID',
    '$HashingRoomID',
    Now()
)";

$insertParticipants = "
Insert INTO usersinchattingroom (
  RoomID,
  UserID
  ) VALUES(
    '$HashingRoomID',
    '$UserID'
)";

$insertOppenent = "
Insert INTO usersinchattingroom (
  RoomID,
  UserID
  ) VALUES(
    '$HashingRoomID',
    '$OppenentID'
)";

$ret = mysqli_query($connect_object, $insertNewRoom);
$ret = mysqli_query($connect_object, $insertParticipants);
$ret = mysqli_query($connect_object, $insertOppenent);

echo ("<script>location.href='../ChattingRoomSelector.php';</script>");

function Hashing($Algorithm, $UserRoomsIndex, $UserID){
  $uniqueString = "";
  $uniqueString .= $UserRoomsIndex;
  $uniqueString .= "#";
  $uniqueString .= $UserID;
  return hash($Algorithm, $uniqueString);
}
