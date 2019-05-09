<?php

class ChattingRoomSelectorBox{

  public static function GetInstance($chattingRoomTitle, $chattingRoomDesc, $participants){

    printf('
    <div class="jumbotron bg-light">
      <div class="row">
        <div class="col-sm-11">
          <h1 class="display-6">%s</h1>
          <p style="font-size: 9pt; color: #939496;">채팅방 참가자: %s</p>
        </div>
        <div class="col-sm-1">
          <img src="img/delete.svg" style="width: 32px; height:32px;" alt="Chatting Room Delete Button"></img>
        </div>
      </div>
      <hr class="my-2">
      <p>%s</p>
      <p class="lead">
        <a class="btn btn-primary btn-lg" href="#" role="button">채팅방으로 이동</a>
      </p>
    </div>

    ', $chattingRoomTitle, $participants, $chattingRoomDesc);
  }

}
