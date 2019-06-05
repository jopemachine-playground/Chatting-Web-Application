<?php
class MessageWindow{

  static public function CreateMessageWindow($sender, $sendedDateTime, $message, $profileImageName, $file, $messageIndex){

    #############################################################    
    #                                                           #
    #  내가 보낸 메시지를 검은색으로, 아닌 메시지를 하얀색으로 표시  #
    #                                                           #
    #############################################################

    $jumbotronElement;
    $profileClass;

    if($sender == $_COOKIE["connectedUserID"]){
      $jumbotronElement = '<div class="MessageBox MyMessage jumbotron" style="background-color: #8596b2 !important;">';
      $profileClass = "MyProfileImages";
    }
    else{
      $jumbotronElement = '<div class="MessageBox OthersMessage jumbotron" style="background-color: #647187 !important;">';
      $profileClass = "OthersProfileImages";
    }

    #############################################################    
    #                                                           #
    #  프로필 이미지 지정해 놓은 게 없는 경우, 디폴트 이미지를 표시  #
    #                                                           #
    #############################################################

    if(empty($profileImageName)){
      $profileImageName = 'img/userDefaultProfile.svg';
    }
    else{
      $profileImageName =  'profileImages/' . $profileImageName;
    }

    $profileImageElement = sprintf(
      '<img src="%s" class="img-fluid rounded-circle %s" alt="User Profile Image">',
      $profileImageName,
      $profileClass
    );

    ########################################################
    #                                                      #
    #   파일이 있는 경우 파일 아이콘 및 다운로드 링크를 제공   #
    #                                                      #
    ########################################################

    $fileImageElement = '';
    $messageElement = '';

    if(!empty($file)){
      $fileImageElement = '<img class="FileImage" src="/img/file-text.svg">';
      $messageElement = sprintf('<a id="%s" class="messageContent fileDownloadLink" onclick="fileDownload(this.id)" href="#">%s</a>', $messageIndex , $message);
    }
    else {
      $messageElement = sprintf('<p class="messageContent">%s</p>', $message);
    }

    return sprintf(
      ' %s
        %s
        %s
        <h6 class="sender">%s</h6>
        <p class="sendingTime">보낸 시각: %s</p>
        <hr class="my-1">
        %s
      </div>', 

        $jumbotronElement,
        $profileImageElement, 
        $fileImageElement, 
        $sender, 
        $sendedDateTime, 
        $messageElement
      );
  }

}
