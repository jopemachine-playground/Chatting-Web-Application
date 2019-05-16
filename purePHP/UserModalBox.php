<?php

class UserModalBox{

  static public function GenerateUserInfoModal($UserID, $SignUpDate, $ProfileImageFileName){
    return sprintf('
    <div id="smallModal" class="container">
      <img id="userDefaultProfile" class="img-fluid rounded-circle" src="profileImages/%s" alt="Image For User Profile">
      <p id="Modal_USER_ID" class="lead">&nbsp;%s</p><br>
      <p id="Modal_SIGNUP_DATE" class="lead">&nbsp;%s</p><br>
    </div>
    ', $ProfileImageFileName, $UserID, $SignUpDate);
  }

}
?>
