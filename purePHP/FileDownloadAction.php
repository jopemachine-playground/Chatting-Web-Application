<?php

require_once('MySQLConection.php');

$Message_Index = $_POST['Index'];
$RoomID = $_POST['roomID'];

$connect_object = MySQLConnection::DB_Connect("chattingroomsdb");

$searchFile = "
  SELECT * FROM " . $RoomID . " WHERE MessageIndex = '$Message_Index'";

$ret = mysqli_query($connect_object, $searchFile) or die("Error Ouccured Searching File in DB");

$row = mysqli_fetch_array($ret);

echo json_encode(array("File" => stripslashes($row['File']), "FileName" => $row['Message']));