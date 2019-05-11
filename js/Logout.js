function logout(){
  $.removeCookie('connectedUserID');
  location.href ='../SignIn.html';
}
