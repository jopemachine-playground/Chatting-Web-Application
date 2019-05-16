<?php
class MessageWindow{

  static public function CreateMessageWindow($sender, $sendedDateTime, $message, $profileImageName){

    $colorClass;
    $profileClass;

    // 내가 보낸 메시지를 검은색으로, 아닌 메시지를 하얀색으로 표시
    if($sender == $_COOKIE["connectedUserID"]){
      $colorClass = "MyMessage bg-dark";
      $profileClass = "MyProfileImages";
    }
    else{
      $colorClass = "OthersMessage bg-white";
      $profileClass = "OthersProfileImages";
    }

    // 프로필 이미지 지정해 놓은 게 없는 경우, 디폴트 이미지를 표시
    if(empty($profileImageName)){
      $profileImageName = 'img/userDefaultProfile.svg';
    }
    else{
      $profileImageName =  'profileImages/' . $profileImageName;
    }

    return sprintf(
      '<div class="MessageBox jumbotron %s">
        <img src="%s" class="img-fluid rounded-circle %s" alt="User Profile Image">
        <h6 class="sender">%s</h6>
        <p class="sendingTime">보낸 시각: %s</p>
        <hr class="my-1">
        <p class="messageContent">%s</p>
      </div>', $colorClass, $profileImageName, $profileClass, $sender, $sendedDateTime, $message);
  }

}
