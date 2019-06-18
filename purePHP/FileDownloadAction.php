<?php

require_once('MySQLConection.php');

$Message_Index = $_POST['Index'];
$RoomID = $_POST['roomID'];

$connect_object = MySQLConnection::DB_Connect("chattingroomsdb");

// 채팅방 테이블에서 파일을 검색
$searchFile = "
  SELECT * FROM " . $RoomID . " WHERE MessageIndex = '$Message_Index'";

$ret = mysqli_query($connect_object, $searchFile) or die("Error Ouccured Searching File in DB");

$row = mysqli_fetch_array($ret);

// stripslashes를 통해 DB에 addslash로 Blob 형태로 저장되어 있던 파일을 원래 형태로 되돌리고 
// 되돌린 파일 및 파일 이름을 전송함
echo json_encode(array("File" => ($row['File']), "FileName" => $row['Message']));