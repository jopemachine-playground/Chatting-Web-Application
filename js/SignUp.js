// 클라이언트 쪽에서 유효성 검사를 하고, 유효한 경우에만 넘어감
function SubmitButtonClicked(){

  // 비밀번호와 비밀번호 확인이 같은 값인지 검사
  if($('input[name="PW"]')[0].value != $('input[name="PW_Confirm"]')[0].value){
    alert('비밀번호가 비밀번호 확인과 맞지 않습니다');
    return false;
  }
  // ID와 비밀번호의 형식을 검사

  else if($('input[name="PW"]')[0].value.length < 4){
    alert('비밀번호는 4 자리 이상이어야 합니다');
    return false;
  }
  else if($('input[name="ID"]')[0].value.length < 4){
    alert('ID는 대소문자 알파벳으로 시작해야 하며, 4자리 이상이어야 합니다');
    return false;
  }

  return true;
}
