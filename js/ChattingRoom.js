function ToChattingRoom(){
  location.href='ChattingRoomSelector.php';
}

// 메시지 전송 버튼 클릭 이벤트
function HandlingSendEvent(){
  SendJsonMessageToServer(createMessageToJson($('#Sending_Message_Box').val(), $.cookie('connectedUserID')));
  // console.log($('#Sending_Message_Box').val());
  // console.log($.cookie('connectedUserID'));

}

function SendJsonMessageToServer(sendingMessageJson){
  $.ajax({
      type: "POST",
      url : "../purePHP/SendMessageActionWithAjax.php",
      data: sendingMessageJson,
      dataType:"JSON",

      success : function(data, status, xhr) {
          console.log("서버로 채팅 데이터 전송 성공" + data);
      },
      error: function(jqXHR, textStatus, errorThrown) {
          console.log("Ajax 전송에 실패했습니다!" + jqXHR.responseText);
      }
  });
}

function createMessageToJson(sendingMessage, senderID){
  let newMessage = {
    message: sendingMessage,
    sender: senderID
  };

  return newMessage;
  //return JSON.stringify(newMessage);
}

function FetchMessageWithAjax(){

}
