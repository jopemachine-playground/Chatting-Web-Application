<?php
  require_once('C:\xampp\WebProgramming_Project\purePHP\MessageWindow.php');
  require_once('C:\xampp\WebProgramming_Project\purePHP\MySQLConection.php');

  $UserID = $_COOKIE["connectedUserID"];
  $RoomID = $_GET["RoomID"];

  if(empty($UserID)){
    echo ("<script language=javascript>alert('먼저 로그인하세요!')</script>");
    echo ("<script>location.href='SignIn.html';</script>");
  }

  $connect_object = MySQLConnection::DB_Connect();

  $searchThisUserBeInThisChattingRoom = "
    SELECT * FROM usersinchattingroom WHERE RoomID = '$RoomID'
  ";

  $ret = mysqli_query($connect_object, $searchThisUserBeInThisChattingRoom);

  if(empty($ret)){
    echo ("<script language=javascript>alert({$UserID} + '님은 이 채팅방에 등록되어 있지 않습니다.\n방장에게 문의하세요.')</script>");
    echo ("<script>location.href='ChattingRoomSelector.php';</script>");
    exit();
  }
?>

<!DOCTYPE html>
<html lang="kr">
<head>
  <title>채팅 프로그램</title>
  <!-- meta 데이터 정의 -->
  <meta charset="utf-8">
  <meta name="description" content="Chatting web program">
  <meta name="keywords" content="Web Programming Term Project, Chatting">
  <meta name="author" content="Gyu Bong Lee">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" />

  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/ChattingRoom.css">
</head>

<body id="Background">
  <!-- 프로그램 창 -->
  <div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
      <div class="col-sm-11">
        <a id="ChattingRoomTitle" class="navbar-brand" href="./ChattingRoom.html">채팅방 제목</a>
      </div>
      <div class="col-sm-1">
        <div class="btn-group float-right responsive">
          <button type="button" class="side_btn"><img src="img/arrow-left.svg" alt="return chatting room" onclick="ToChattingRoom();"></img></button>
          <button type="button" class="btn side_btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="img/menu.svg" alt="sidebar menu"></img></button>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item active" onclick="logout()" href="#">로그아웃</a>
            <a class="dropdown-item" href="#">채팅방 선택화면</a>
            <a class="dropdown-item" href="#">내 정보</a>
          </div>
          <button type="button" class="side_btn"><img src="img/user.svg" alt="user info button"></img></button>
        </div>
      </div>
    </nav>
  </div>

  <!-- 메시지 표시 -->
  <section class="container" style="padding-top:100px;" id="Message_Window">
  </section>

    <!-- 메시지 작성 박스 -->
    <footer id="Message_Writing_Box" class="navbar bg-dark p-2 fixed-bottom">
      <div class="row">

        <div class="col-sm-1"></div>

        <div class="col-sm-9 text-right" style="margin-top:10px;" title="전송할 메시지를 입력하세요.">
          <form>
            <textarea id="Sending_Message_Box" name="message" rows="4" cols="400" placeholder="메시지를 입력하세요." autofocus></textarea>
          </form>
        </div>

        <div class="col-sm-1.5 responsive">
          <button id="Message_Send_Button" type="submit" class="btn btn-block btn-success" title="메시지를 전송합니다." onclick="HandlingSendEvent()">메시지 전송</button>
          <button id="File_Transfer_Button" type="submit" class="btn btn-block btn-primary" title="파일을 전송하시려면 클릭하세요.">파일 전송</button>
        </div>
      </div>

      <div class="row" style="width: 100%">
        <div style="margin:0 auto">
          <div id="Copyright" style="margin-bottom: 12px;"> &copy; 2019 웹프로그래밍 </div>
        </div>
      </div>
    </footer>

  <!-- 제이쿼리 자바스크립트 추가하기 -->
  <script src="./lib/jquery-3.2.1.min.js"></script>
  <!-- Popper 자바스크립트 추가하기 -->
  <script src="./lib/popper.min.js"></script>
  <!-- 부트스트랩 자바스크립트 추가하기 -->
  <script src="./lib/bootstrap.min.js"></script>
  <!-- MDB 라이브러리 추가하기 -->
  <script src="./lib/mdb.min.js"></script>
  <!-- 제이쿼리 쿠키 자바스크립트 파일 추가하기 -->
  <script src="./lib/jquery.cookie.js"></script>
  <!-- 커스텀 자바스크립트 추가하기 -->
  <script src="./js/ChattingRoom.js"></script>
  <!-- 커스텀 자바스크립트 추가하기 -->
  <script src="./js/Logout.js"></script>


</body>
</html>
