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
          <img id="%s" src="img/log-out.svg" class="responsiveSmall" style="width: 32px; height:32px;" data-toggle="modal" onclick="setIndexToDeleteRoom(this.id)" data-target="#DeleteConfirmModal" alt="Chatting Room Delete Button" />
        </div>
      </div>
      <hr class="my-2">
      <p class="MessageContent">%s</p>
      <form action="../ChattingRoom.php" method="get">
        <label for="RoomID">
        <button class="btn btn-secondary btn-lg ToChattingRoomButton" type="submit" name="RoomID" value="%s">채팅방으로 이동</button>
      </form>
    </div>

    ', $chattingRoomTitle , $participants, $roomID, $chattingRoomDesc, $roomID);
  }

}
