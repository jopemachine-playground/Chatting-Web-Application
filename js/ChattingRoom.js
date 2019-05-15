var RoomID = getQueryParam("RoomID");
var UserID = $.cookie('connectedUserID');
var UpdatedIndex = 0;

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

  UpdatedIndex = $('.jumbotron').length;

  $.ajax({
      type: "POST",
      url : "../purePHP/MessageFetchAction.php",
      data : { RoomID : RoomID, UpdatedIndex : UpdatedIndex} ,
      dataType:"HTML",

      success : function(response) {
          console.log("서버에서 채팅 메시지를 받아오는데 성공했습니다!");
          $('#Message_Window').append(response);
      },
      error: function(jqXHR, textStatus, errorThrown) {
          console.log("Ajax 수신에 실패했습니다!" + jqXHR.responseText);
      }
  })
  .then(function(){
    UpdatedIndex = $('.jumbotron').length;
    checkOutFooterStyle();
  });
}

// 콜백함수 setInterval를 이용해 1초마다 새로 보내진 채팅 데이터를 가져옴
window.onload = function(){
  FetchMessageWithAjax();
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

function checkOutFooterStyle(){
  // Footer의 높이가 176px 이므로, window.innerHeight - 176 보다 문서 전체의 높이가 더 클 때 stiky로 전환한다
  if(document.body.scrollHeight > window.innerHeight - 176){
    $('#Message_Writing_Box').addClass('stikyFooter');
  }
}
