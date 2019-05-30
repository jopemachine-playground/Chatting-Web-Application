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

  // 아무 내용도 없는 메시지는 전송하지 않음
  if($('#Sending_Message_Box').val() == ''){
    return;
  }
  SendMessageToServer(createMessageHTML($('#Sending_Message_Box').val(), UserID, RoomID, ProfileImageFileName));
  $("#Sending_Message_Box").val("");
}

// 맨 아래로 스크롤을 내린다.
function ScrollToBottom(){
  $(document).scrollTop($(document).height());
}

function SendMessageToServer(sendingMessageJson){
  $.ajax({
    type: "POST",
    url : "../purePHP/SendMessageActionWithAjax.php",
    data: sendingMessageJson,

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
    data : {
      RoomID : RoomID,
      UpdatedIndex : UpdatedIndex
    },
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

function createMessageHTML(sendingMessage, senderID, roomID, profileImageFileName, file){
  return {
    message: sendingMessage,
    sender: senderID,
    roomID: roomID,
    profileImageFileName: profileImageFileName,
    file: file
  };
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
  // console.log(document.body.scrollHeight);
  // console.log(window.innerHeight);
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

function fileUpload(file, fileName){

  $.ajax({
    type: "POST",
    url : "../purePHP/SendMessageActionWithAjax.php",
    data : createMessageHTML(fileName, UserID, RoomID, ProfileImageFileName, file),

    success : function(response) {
      console.log("서버에 성공적으로 파일을 업로드 했습니다!");

      if(response != ''){
        UpdatedIndex = $('.MessageBox').length;
        ScrollToBottom();
        checkOutFooterStyle();
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log("Ajax 수신에 실패했습니다!" + jqXHR.responseText);
    }
  });
}

async function fileUploadByDrag(event){
  // 파일을 드래그 한 게 아닌 경우 아무 일도 하지 않음.

  event.preventDefault();

  if(event.dataTransfer.files.length > 1){
    alert('한 번에 한 파일만 전송할 수 있습니다.');
    return;
  }
  if(event.dataTransfer.files[0].size > 100000){
    alert('전송하려는 파일의 크기는 100000 바이트 미만이어야 합니다.');
    return;
  }

  let fileName = event.dataTransfer.files[0].name;

  let arrayBuffer = await new Response(event.dataTransfer.files[0]).arrayBuffer();

  // console.log(arrayBuffer); // 정상

  uint8ArrayNew  = new Uint8Array(arrayBuffer);

  // console.log(uint8ArrayNew); // 정상

  // var enc = new TextDecoder("utf-8");
  // var arr = new Uint8Array([84,104,105,115,32,105,115,32,97,32,85,105,110,116,
  //                           56,65,114,114,97,121,32,99,111,110,118,101,114,116,
  //                           101,100,32,116,111,32,97,32,115,116,114,105,110,103]);
  // console.log(enc.decode(arr));
  
  var enc = new TextDecoder("utf-16");
  
  console.log(enc.decode(uint8ArrayNew));

  fileUpload(enc.decode(uint8ArrayNew), fileName);

  $('#Sending_Message_Box').css('background-color','#ffffff');

}

function ab2str(buf) {
  return String.fromCharCode.apply(null, new Uint8Array(buf));
}

function str2ab(str) {
  var buf = new ArrayBuffer(str.length*2); // 2 bytes for each char
  var bufView = new Uint8Array(buf);
  for (var i=0, strLen=str.length; i < strLen; i++) {
    bufView[i] = str.charCodeAt(i);
  }
  return buf;
}

// 마우스가 드래그 된 상태로 위에 떠 있는 동안 색상을 변경한다.
function colorChangeByDragOver(){
  $('#Sending_Message_Box').css('background-color','#dfffd8');
}

// 마우스 드래그가 끝나거나, 드래그가 떠나거나, 색상을 되돌려 놓아야 한다.
function colorChangeByDragLeave(){
  $('#Sending_Message_Box').css('background-color','#ffffff');
}

function fileDownload(message_index){

  $.ajax({
    type: "POST",
    url : "../purePHP/FileDownloadAction.php",
    data : { 
      Index : message_index,
      roomID: RoomID
    },

    success : function(response) {
      
      console.log("서버에 파일 다운로드 요청에 성공했습니다");

      // require에 콜백을 등록해, 파일 저장에 필요한 스크립트 파일이 로드되면 다음 과정을 진행
      require(["../lib/FileSaver.js"], () => {

      // 서버에서 json_encode로 인코딩 한 파일 내용, 파일 이름을 디코딩한다.
      // JSON.parse는 제이쿼리의 메서드 라고 함
      let response_file = JSON.parse(response);

      // let a = str2ab(response_file['File']);

      // blob 객체를 생성
      //var blob = new Blob([a]);

      var enc = new TextDecoder("utf-16");

      var blob = new Blob([response_file['File']], {type: "text/plain; charset=utf-8"});
      
      // 브라우저의 다운로드 경로에 파일을 다운로드함
      saveAs(blob, response_file['FileName']);

      });

    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log("Ajax 수신에 실패했습니다!" + jqXHR.responseText);
    }
  });
}