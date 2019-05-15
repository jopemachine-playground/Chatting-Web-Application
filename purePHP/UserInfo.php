<?php

class UserModal{

  public static GenerateUserInfo(){
    return sprintf('
    <div class="jumbotron bg-light">

    </div>

    ', $chattingRoomTitle, $participants, $chattingRoomDesc, $roomID);
  }

}
?>
