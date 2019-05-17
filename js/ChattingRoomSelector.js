$('.jumbotron').each(function(){

  $(this).mouseenter(function(){
    $(this).removeClass('bg-light');
  });

  $(this).mouseleave(function(){
    $(this).addClass('bg-light');
  });
})

window.onload = function(){
  checkOutFooterStyle();
}

function checkOutFooterStyle(){
  // 문서 전체의 길이와 비교해 Footer의 스타일을 전환한다

  let comparator = window.outerHeight - $('#FooterDiv').outerHeight() - $('#FixedNavbar').outerHeight() - parseInt(($('#ChattingRoomSection').css('padding-top')));

  if(document.body.scrollHeight > comparator){
    $('#FooterDiv').addClass('stikyFooter');
  }
}
