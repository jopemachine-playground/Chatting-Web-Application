var RoomID = getQueryParam("RoomID");
var UserID = $.cookie('connectedUserID');
var ProfileImageFileName = $.cookie('profileImageFileName');

// 업데이트 된 메시지들을 가리키기 위한 변수.
// 업데이트 되어 있는 메시지들을 DB에서 조회하지 않게 해, 조회 속도 및 전송 효율을 높이려고 했음.
var UpdatedIndex = 0;

function ToChattingRoom(){
  location.href='ChattingRoomSelector.php';
}

// 메시지 전송 버튼 클릭 이벤트
function HandlingSendEvent(){
  SendJsonMessageToServer(createMessageHTML($('#Sending_Message_Box').val(), UserID, RoomID, ProfileImageFileName));
  $("#Sending_Message_Box").val("");
}

// 맨 아래로 스크롤을 내린다.
function ScrollToBottom(){
  $(document).scrollTop($(document).height());
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


function FetchMessageWithAjax(){
  $.ajax({
    type: "POST",
    url : "../purePHP/MessageFetchAction.php",
    data : { RoomID : RoomID, UpdatedIndex : UpdatedIndex },
    dataType:"HTML",

    success : function(response) {
      console.log("서버에서 채팅 메시지를 받아오는데 성공했습니다!");
      $('#Message_Window').append(response);

      if(response != ''){
        UpdatedIndex = $('.MessageBox').length;
        ScrollToBottom();
        checkOutFooterStyle();
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log("Ajax 수신에 실패했습니다!" + jqXHR.responseText);
    }
  })
}

// 콜백함수 setInterval를 이용해 1초마다 새로 보내진 채팅 데이터를 가져옴
window.onload = function(){
  FetchMessageWithAjax();
  setInterval(FetchMessageWithAjax, 1000);
}

window.onresize = function(){
  checkOutFooterStyle();
}

function createMessageHTML(sendingMessage, senderID, roomID, profileImageFileName){
  let newMessage = {
    message: sendingMessage,
    sender: senderID,
    roomID: roomID,
    profileImageFileName: profileImageFileName
  };

  return newMessage;
}

// 이 함수는 아래 페이지에서 가져와 그대로 사용했음.
// https://systemoutofmemory.com/blogs/the-programmer-blog/javascript-getting-query-string-values
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
  // 문서 전체의 길이와 비교해 스타일을 전환한다

  // 디버깅 용
  console.log(document.body.scrollHeight);
  console.log(window.innerHeight);
  // console.log($('#Message_Writing_Box').outerHeight())
  // console.log(parseInt(($('#Message_Window').css('padding-top'))));

  //let comparator = window.outerHeight - $('#Message_Writing_Box').outerHeight() - $('#FixedNavbar').outerHeight() - parseInt(($('#Message_Window').css('padding-top')));

  // console.log(comparator);

  if(document.body.scrollHeight  > window.innerHeight){
    $('#Message_Writing_Box').addClass('stikyFooter');
  }
  else if(document.body.scrollHeight < window.innerHeight){
    $('#Message_Writing_Box').removeClass('stikyFooter');
  }
}

$(document).ready(function() {
  $("#Sending_Message_Box").keydown(function(key) {
    if (key.keyCode == 13) {
      HandlingSendEvent();
      event.preventDefault();
    }
  });
});
