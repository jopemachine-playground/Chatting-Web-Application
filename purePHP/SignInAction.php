<?php

  require_once('C:\xampp\WebProgramming_Project\purePHP\MySQLConection.php');

  $connect_object = MySQLConnection::DB_Connect();

  // Post 방식으로 유저 데이터를 가져옴
  $ID = $_POST["ID"];
  $PW = $_POST["PW"];

  // DB에서 PK (ID) 를 찾음
  $searchUserID = "
    SELECT * FROM usersinfotbl WHERE ID = '$ID'
  ";

  // 1시간 동안 로그인을 쿠키를 이용해 유지함
  setcookie("connectedUserID", $ID, time() + 3600, "/");

  $ret = mysqli_query($connect_object, $searchUserID);

  $row = mysqli_fetch_array($ret);

  if(empty($row)){
    echo ("<script language=javascript>alert('존재하지 않는 계정입니다.')</script>");
    echo ("<script>location.href='../SignIn.html';</script>");
    exit();
  }

  else if($row['PW'] != $PW){
    echo ("<script language=javascript>alert('입력하신 ID의 비밀번호가 일치하지 않습니다.')</script>");
    echo ("<script>location.href='../SignIn.html';</script>");
    exit();
  }

  echo ("<script>location.href='../ChattingRoomSelector.php';</script>");