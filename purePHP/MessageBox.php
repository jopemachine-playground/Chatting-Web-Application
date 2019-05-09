<?php
require_once('C:\xampp\WebProgramming_Project\purePHP\MessageWindow.php');

class MessageBox{

  // $messageHTML은 참조 변수로 전달되어야 함에 주의
  function __constructor($messageHTML, $messageString, $sender){
    $messageHTML .= '<div class="jumbotron userCard';

    if($sender == ConnectedUserInfo::getID()){
      $messageHTML .= ' My_Message">';
    }
    else{
      $messageHTML .= ' Oppenent_Message">';
    }

    $messageHTML .= '<p>' + $messageString + '</p>';
    $messageHTML .= '</div>';

  }
}
