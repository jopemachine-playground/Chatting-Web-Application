<?php
  require_once('C:\xampp\WebProgramming_Project\purePHP\MySQLConection.php');
  // DB 연결

  $connect_object = MySQLConnection::DB_Connect();

  // Post 방식으로 유저 데이터를 가져옴
  $ID = $_POST["ID"];
  $PW = $_POST["PW"];
  $PW_Confirm = $_POST["PW_Confirm"];
  $Address = $_POST["Address"];
  $PhoneNumber = $_POST["PhoneNumber"];

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
      echo ("<script>location.href='../SignUp.html';</script>");
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
  echo ("<script>location.href='../SignIn.html';</script>");

  mysqli_close($connect_object);
