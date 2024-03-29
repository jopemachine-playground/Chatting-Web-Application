<?php

require_once('MySQLConection.php');

class ChattingRoomSelectorBox{

  // 검색된 채팅방이 없으면 닫을 수 있는 알림창 (채팅방이 존재하지 않는다는 것을 알려주는) 을 띄운다 
  public static function WarnNoChattingRoomsToShow(){

    return sprintf('
      <div class="alert alert-success alert-dismissible fade show">
        <button type="button" class="close" aria-label="Close" data-dismiss="alert">
          <span aria-hidden="true">&times;</span>
        </button>
        <p id="ChattingRoomNotExistedWarning" class="lead" style="font-size: 14px; color: #4c4c4c;"><br>채팅방이 존재하지 않습니다. <br><br>우측 상단바의 + 버튼을 눌러 채팅방을 추가해보세요!</p>
      </div>
    ');
  }

  public static function CreateChattingRoomBox($chattingRoomTitle, $chattingRoomDesc, $roomID){

    // RoomID를 통해 usersinchattingroom에서 해당하는 ID를 모두 찾아 array에 넣어 놓고, implode로 string 형태로 만들어
    // Participant에 넣어놓는다.

    $connect_object = MySQLConnection::DB_Connect('chattingdb');

    $participantsArray = array();

    $searchRoom = "
      SELECT * FROM usersinchattingroom WHERE RoomID = '$roomID'
    ";

    $ret = mysqli_query($connect_object, $searchRoom) or die("Error Ouccured Searching File in DB");

    while($row = mysqli_fetch_array($ret)){
      array_push($participantsArray, $row['UserID']);
    }

    $participants = implode(', ' , $participantsArray);

    return sprintf('
      <div id="%s" class="jumbotron" style="background-color: #e8f9ff !important; padding: 33px 32px 30px 32px">
        <div class="row">
          <div class="col-sm-11">
            <h1 class="display-6">%s</h1>
            <p style="font-size: 10pt; color: #939496;">Partipants: %s</p>
          </div>
          <div class="col-sm-1">
            <img src="img/log-out.svg" class="responsiveSmall sizeUpOnHover" style="width: 32px; height:32px;" data-toggle="modal" onclick="setIndexToDeleteRoom(this.parentNode.parentNode.parentNode.id)" data-target="#DeleteConfirmModal" alt="Chatting Room Delete Button" />
          </div>
        </div>
        <hr class="my-2">
        <p class="MessageContent">%s</p>
        <form action="../ChattingRoom.php" method="get">
          <label for="RoomID">
          <button class="btn btn-secondary btn-lg Buttons" type="submit" name="RoomID" value="%s">채팅방으로 이동</button>
          </label>
          <button class="btn btn-danger btn-lg Buttons responsiveSmallReverse" type="button" data-toggle="modal" onclick="setIndexToDeleteRoom(this.parentNode.parentNode.id)" data-target="#DeleteConfirmModal">채팅방 삭제</button>
        </form>
      </div>
    ', $roomID, $chattingRoomTitle , $participants, $chattingRoomDesc, $roomID);
  }

}
