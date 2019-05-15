<?php
class MessageWindow{

  static public $updateIndex = 0;

  static public function CreateMessageWindow($sender, $sendedDateTime, $message){

    // 내가 보낸 메시지를 검은색으로, 아닌 메시지를 하얀색으로 표시
    $isMe = ($sender == $_COOKIE["connectedUserID"]) ? "bg-dark" : "bg-white";

    return sprintf(
      '<div class="jumbotron %s text-white">
        <h6>%s</h6>
        <p class="sendingTime">보낸 시각: %s</p>
        <hr class="my-1">
        <p>%s</p>
      </div>', $isMe, $sender, $sendedDateTime, $message);
  }

}
