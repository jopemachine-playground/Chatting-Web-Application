<?php

$UserID = $_POST['ID'];
$UserPW = $_POST['PW'];

$fp = fopen("../data/person.txt", "r") or die("fail to open file");

while(!feof($fp)){
  $oneline_data = fgets($fp);
  $usersInfo = explode('|', $oneline_data);

  if($usersInfo[0] == $UserID && trim($usersInfo[1]) == $UserPW){
    setcookie('connectedUserID', $UserID);
    echo ("<script>location.href='../TodoList.php';</script>");
    exit();
  }
}

if(empty($oneline_data)){
  fclose($fp);
  echo ("<script language=javascript>alert('존재하지 않는 ID 입니다.')</script>");
  // echo ("<script>location.href='../SignIn.html';</script>");
  exit();
}
