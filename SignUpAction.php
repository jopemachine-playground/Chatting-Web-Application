<?php
  // DB 연결
  $database_host = "localhost";
  $database_user = "root";
  $database_password = "ttdance4902";
  $database_name = "";

  $connect_object = mysqli_connect($database_host, $database_user, $database_password, $database_name);
  if(mysqli_connect_error($connect_object)){
    echo "MySQL 접속 오류";
    echo "오류 원인 : ", mysqli_connect_error();
    exit();
  }

  // Post 방식으로 유저 데이터를 가져옴
  $ID = $_POST["ID"];
  $PW = $_POST["PW"];
  $PW_Confirm = $_POST["PW_Confirm"];
  $Address = $_POST["Address"];
  $PhoneNumber = $_POST["PhoneNumber"];

  $useDB = "
    USE chattingdb;
  ";

  $ret = mysqli_query($connect_object, $useDB);

  // DB에서 PK (ID) 중복 검사
  $searchUserID = "
    SELECT * FROM usersinfotbl
  ";

  $ret = mysqli_query($connect_object, $searchUserID);

  /////////////////////////////////////////////
  /////////////// For Dubugging ///////////////
  /////////////////////////////////////////////

  // if($ret){
  //   echo mysqli_num_rows($ret), "건이 조회됨.<br><br>";
  // }
  // else{
  //   echo "실패 원인: " .mysqli_error($connect_object);
  //   exit();
  // }

  // 중복 ID가 존재하는 경우 에러처리
  while($row = mysqli_fetch_array($ret)){
    if($ID == $row['ID']){
      echo ("<script language=javascript>alert('중복된 ID가 있습니다.')</script>");
      echo ("<script>location.href='SignUp.php';</script>");
      break;
    }
  }

  $insertData = "
    Insert INTO usersinfotbl (
        ID,
        PW,
        Address,
        PhoneNumber,
        SignupDate
      ) VALUES(
        '$ID',
        '$PW',
        '$Address',
        '$PhoneNumber',
        Now()
      )";

  $ret = mysqli_query($connect_object, $insertData);

  /////////////////////////////////////////////
  /////////////// For Dubugging ///////////////
  /////////////////////////////////////////////

  // if($ret){
  //   echo "성공";
  // }
  // else{
  //   echo "실패 원인: " .mysqli_error($connect_object);
  //   exit();
  // }
  echo ("<script language=javascript>alert('축하합니다! 회원가입이 완료되었습니다!')</script>");
  echo ("<script>location.href='SignUp.php';</script>");

  mysqli_close($connect_object);

?>
