var a1 = document.getElementById('a1');
var b1 = document.getElementById('b1');

function check(){
  if(a1.value == '' && b1.value == ''){
    alert('값을 입력해주세요');
    return false;
  }
  return true;
}
