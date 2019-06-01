var ID_input = document.getElementById('ID_input');
var PW_input = document.getElementById('PW_input');

function checkValidality(){

  if(ID_input.value == '' || PW_input.value == ''){
    return false;
  }
  else{
    return true;
  }

  return false;
}
