<?php
require_once('C:\xampp\WebProgramming_Project\purePHP\MySQLConection.php');

class MessageWindow{

  private $MessageHTML;

  function __constructor($messageBoxList){

  }

  class MessageBox{

    function __constructor($messageString){
      $MessageHTML .= '<div class="jumbotron userCard">';
      $MessageHTML .= '<p>' + $messageString + '</p>';
      $MessageHTML .= '</div>'
    }
  }

}

?>
