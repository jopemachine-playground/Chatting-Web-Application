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
