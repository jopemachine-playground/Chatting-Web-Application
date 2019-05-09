<?php

class ChattingRoomSelectorBox{

  public static function GetInstance($chattingRoomTitle, $chattingRoomDesc){

    $chattingRoomSelectorHTML = '';
    $chattingRoomSelectorHTML .= '<div class="jumbotron userCard">';
    $chattingRoomSelectorHTML .= '<h1 class="display-4">';
    $chattingRoomSelectorHTML .= $chattingRoomTitle;
    $chattingRoomSelectorHTML .= '</h1>';
    $chattingRoomSelectorHTML .= '<hr class="my-4">';
    $chattingRoomSelectorHTML .= '<p>';
    $chattingRoomSelectorHTML .= $chattingRoomDesc;
    $chattingRoomSelectorHTML .= '</p>';
    $chattingRoomSelectorHTML .= '<p class="lead">';
    $chattingRoomSelectorHTML .= '<a class="btn btn-primary btn-lg" href="#" role="button">채팅방으로 이동</a>';
    $chattingRoomSelectorHTML .= '</p>';
    $chattingRoomSelectorHTML .= '</div>';

    return $chattingRoomSelectorHTML;
  }


}
