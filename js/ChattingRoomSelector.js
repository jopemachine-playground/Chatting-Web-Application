$('.jumbotron').each(function(){

  $(this).mouseenter(function(){
    $(this).removeClass('bg-light');
  });
  
  $(this).mouseleave(function(){
    $(this).addClass('bg-light');
  });
})
