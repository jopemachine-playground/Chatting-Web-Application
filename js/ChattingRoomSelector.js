var DeleteingRoomID;

// 모든 jumbotron을 each로 순회하며 이벤트를 추가한다
$('.jumbotron').each(function(){
  $(this).mouseenter(function(){
    $(this).removeClass('bg-light');
  });

  $(this).mouseleave(function(){
    $(this).addClass('bg-light');
  });
})

// 아래의 상황에서 Footer Style을 점검
window.onload = function(){
  checkOutFooterStyle();
}

window.onresize = function(){
  checkOutFooterStyle();
}

function checkOutFooterStyle(){
  // 문서 전체의 길이와 비교해 Footer의 스타일을 전환한다

  if(document.body.scrollHeight > window.innerHeight){
    $('#FooterDiv').addClass('stikyFooter');
  }
  else if(document.body.scrollHeight < window.innerHeight){
    $('#FooterDiv').removeClass('stikyFooter');
  }
}

// Delete 버튼이 눌러졌을 때 Ajax를 이용해 데이터를 전송한 후
// DB에서 삭제에 성공하면
function DeleteChattingRoom(){

  $('DeleteConfirmModal').show();

  $.ajax({
    type: "POST",
    url : "../purePHP/ChattingRoomDeleteAction.php",
    data : {
      DeleteingRoomID : DeleteingRoomID,
      DeleteingUserID : $.cookie('connectedUserID');  
    },

    success : function(response) {
      console.log("채팅방에서 나가는 데 성공했습니다");
      checkOutFooterStyle();

    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log("Ajax 수신에 실패했습니다!" + jqXHR.responseText);
    }
  })
}

function setIndexToDeleteRoom(index){
  DeleteingRoomID = index;
}
