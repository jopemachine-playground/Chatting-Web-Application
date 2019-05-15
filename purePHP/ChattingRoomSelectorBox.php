<?php

class ChattingRoomSelectorBox{

  public static function CreateChattingRoomBox($chattingRoomTitle, $chattingRoomDesc, $participants, $roomID){

    return sprintf('
    <div class="jumbotron bg-light">
      <div class="row">
        <div class="col-sm-11">
          <h1 class="display-6">%s</h1>
          <p style="font-size: 9pt; color: #939496;">Partipants: %s</p>
        </div>
        <div class="col-sm-1">
          <img src="img/delete.svg" class="responsiveSmall" style="width: 32px; height:32px;" onclick="DeleteChattingRoom()" alt="Chatting Room Delete Button"></img>
        </div>
      </div>
      <hr class="my-2">
      <p class="MessageContent">%s</p>
      <form action="../ChattingRoom.php" method="get">
        <label for="RoomID">
        <button class="btn btn-primary btn-lg ToChattingRoomButton" type="submit" name="RoomID" value="%s">채팅방으로 이동</button>
      </form>
    </div>

    ', $chattingRoomTitle, $participants, $chattingRoomDesc, $roomID);
  }

}
