<?php
  require_once('C:\xampp\WebProgramming_Project\purePHP\MessageWindow.php');
  require_once('C:\xampp\WebProgramming_Project\purePHP\MySQLConection.php');
  require_once('C:\xampp\WebProgramming_Project\purePHP\MessageBox.php');

  $ID = $_COOKIE["connectedUserID"];

  if($ID == null){
    echo ("<script language=javascript>alert('먼저 로그인하세요!')</script>");
    echo ("<script>location.href='SignIn.html';</script>");
  }

  $connect_object = MySQLConnection::DB_Connect();
  $messageWindow = new MessageWindow();

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

<body id="background">
  <!-- 프로그램 창 -->
  <div id="Program_Window">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
      <div class="col-sm-11">
        <a class="navbar-brand" href="./ChattingRoom.html">채팅방 제목</a>
      </div>
      <div class="col-sm-1">
        <div class="btn-group float-right">
          <button type="button" class="btn side_btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="img/menu.svg" alt="sidebar menu"></img></button>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item active" href="#">로그아웃</a>
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
    <?php
      echo $messageWindow->$MessageHTML;
    ?>
    <!--
    <div class="jumbotron userCard">
      <p>충남대학교우편취급국에서 영수증이 도착하였습니다. 충남대학교우편취급국에서 영수증이 도착하였습니다. 결제금충남대학교우편취급국에서 영수증이 도착하였습니다. 결제금충남대학교우편취급국에서 영수증이 도착하였습니다. 결제금충남대학교우편취급국에서 영수증이 도착하였습니다. 결제금충남대학교우편취급국에서 영수증이 도착하였습니다. 결제금결제금액 :800원 영수증 보기 http://epost.go.kr/r/?r=3gEvBuGj20h1VDC9CE</p>
    </div>
    <div class="jumbotron userCard">
      <p>충남대학교우편취급국에서 영수증이 도착하였습니다. 결제금액 :800원 영수증 보기 http://epost.go.kr/r/?r=3gEvBuGj20h1VDC9CE</p>
    </div>
    <div class="jumbotron userCard">
      <p>충남대학교우편취급국에서 영수증이 도착하였습니다. 충남대학교우편취급국에서 영수증이 도착하였습니다. 결제금충남대학교우편취급국에서 영수증이 도착하였습니다. 결제금충남대학교우편취급국에서 영수증이 도착하였습니다. 결제금충남대학교우편취급국에서 영수증이 도착하였습니다. 결제금충남대학교우편취급국에서 영수증이 도착하였습니다. 결제금결제금액 :800원 영수증 보기 http://epost.go.kr/r/?r=3gEvBuGj20h1VDC9CE</p>
    </div>
    <div class="jumbotron userCard">
      <p>충남대학교우편취급국에서 영수증이 도착하였습니다. 충남대학교우편취급국에서 영수증이 도착하였습니다. 결제금충남대학교우편취급국에서 영수증이 도착하였습니다. 결제금충남대학교우편취급국에서 영수증이 도착하였습니다. 결제금충남대학교우편취급국에서 영수증이 도착하였습니다. 결제금충남대학교우편취급국에서 영수증이 도착하였습니다. 결제금결제금액 :800원 영수증 보기 http://epost.go.kr/r/?r=3gEvBuGj20h1VDC9CE</p>
    </div>
    -->
  </section>

    <!-- 메시지 작성 박스 -->
    <div id="Message_Writing_Box" class="navbar bg-dark p-3 fixed-bottom">
      <div class="row">

        <div class="col-sm-10 text-right" id="Sending_Message_Box" title ="전송할 메시지를 입력하세요.">
          <form action="send_message.php">
            <textarea name="Sending_Message" rows="4" cols="400" placeholder="메시지를 입력하세요." autofocus></textarea>
          </form>
        </div>

        <div class="col-sm-2">
          <button type="submit" class="btn btn-success mb-2" onclick="Message_Send()">메시지 전송</button>
           <br>
          <button id="File_Transfer_Button" type="submit" class="btn btn-primary mb-5" title="파일을 전송하시려면 클릭하세요.">파일 전송</button>
        </div>
      </div>

      <div class="row" style="width: 100%">
        <div style="margin:0 auto">
          <footer id="Copyright" align= "center"> &copy; 2019 웹프로그래밍 </footer>
        </div>
      </div>
    </div>

  <!-- 제이쿼리 자바스크립트 추가하기 -->
  <script src="./lib/jquery-3.2.1.min.js"></script>
  <!-- Popper 자바스크립트 추가하기 -->
  <script src="./lib/popper.min.js"></script>
  <!-- 부트스트랩 자바스크립트 추가하기 -->
  <script src="./lib/bootstrap.min.js"></script>
  <!-- MDB 라이브러리 추가하기 -->
  <script src="./lib/mdb.min.js"></script>
  <!-- 커스텀 자바스크립트 파일 추가하기 -->
  <script src="./js/ChattingRoom.js"></script>

</body>
</html>