<?php
require_once('C:\xampp\WebProgramming_Project\purePHP\MySQLConection.php');

class MessageWindow{

  // $IndexHashValue는 User들 ID와 채팅방 Title로 만든 Hash value
  public $IndexHashValue;
  private $MessageHTML;

  function __constructor($messageBoxList){

    $connect_object = MySQLConnection::DB_Connect();

    $searchMessageBoxes = "
      SELECT * FROM messageboxestbl;
    ";

    $MessageHTML =
  }

}
