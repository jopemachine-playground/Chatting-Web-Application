<?php

class UserModalBox{

  static public function GenerateUserInfoModal($UserID, $SignUpDate, $ProfileImageFileName){

    // 프로필 이미지 지정해 놓은 게 없는 경우, 디폴트 이미지를 표시
    if(empty($ProfileImageFileName)){
      $ProfileImageFileName = 'img/userDefaultProfile.svg';
    }
    else{
      $ProfileImageFileName = 'profileImages/' . $ProfileImageFileName;
    }

    return sprintf('
      <div id="smallModal" class="container">
        <img id="userDefaultProfile" class="img-fluid rounded-circle" src="%s" alt="Image For User Profile">
        <p id="Modal_USER_ID" class="lead">&nbsp;%s</p><br>
        <p id="Modal_SIGNUP_DATE" class="lead">&nbsp;%s</p><br>
      </div>
    ', $ProfileImageFileName, $UserID, $SignUpDate);
  }

}
