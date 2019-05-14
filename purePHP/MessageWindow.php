<?php
class MessageWindow{

  static public $updateIndex = 0;

  static public $innerHTML = "";

  static public function CreateMessageWindow($sender, $sendedDateTime, $message){
    return sprintf(
      '<div class="jumbotron bg-dark text-white">
        <h6>%s</h6>
        <p>보낸 시각: %s</p>
        <hr class="my-1">
        <p>%s</p>
      </div>', $sender, $sendedDateTime, $message);
  }

}
