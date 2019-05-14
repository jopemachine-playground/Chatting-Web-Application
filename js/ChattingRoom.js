var RoomID = getQueryParam("RoomID");
var UserID = $.cookie('connectedUserID');

function ToChattingRoom(){
  location.href='ChattingRoomSelector.php';
}

// 메시지 전송 버튼 클릭 이벤트
function HandlingSendEvent(){
  SendJsonMessageToServer(createMessageHTML($('#Sending_Message_Box').val(), UserID, RoomID));
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

function createMessageHTML(sendingMessage, senderID, roomID){
  let newMessage = {
    message: sendingMessage,
    sender: senderID,
    roomID: roomID
  };

  return newMessage;
  //return JSON.stringify(newMessage);
}

function FetchMessageWithAjax(){
  $.ajax({
      type: "POST",
      url : "../purePHP/MessageFetchAction.php",
      data : { RoomID : RoomID } ,
      dataType:"HTML",

      success : function(response) {
          console.log("서버에서 채팅 메시지를 받아오는데 성공했습니다!" + response);
          $('#Message_Window').html(response);
      },
      error: function(jqXHR, textStatus, errorThrown) {
          console.log("Ajax 수신에 실패했습니다!" + jqXHR.responseText);
      }
  });
}

window.onload = function(){
  setInterval(FetchMessageWithAjax, 1000);
}

// https://systemoutofmemory.com/blogs/the-programmer-blog/javascript-getting-query-string-values 참고
function getQueryParam(param){
  var query = window.location.search.substring(1);
  var vars = query.split("?");
  for (let i =0; i<vars.length; i++){
    let pair = vars[i].split("=");
    if(pair[0] == param){
      return pair[1];
    }
  }
  return false;
}
