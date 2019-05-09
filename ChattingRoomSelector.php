<?php
require_once('C:\xampp\WebProgramming_Project\purePHP\MySQLConection.php');
require_once('C:\xampp\WebProgramming_Project\purePHP\ChattingRoomSelectorBox.php');

$ID = $_COOKIE["connectedUserID"];

if($ID == null){
  echo ("<script language=javascript>alert('먼저 로그인하세요!')</script>");
  echo ("<script>location.href='SignIn.html';</script>");
  exit();
}

$connect_object = MySQLConnection::DB_Connect();

$searchUserChattingRoomBoxes = "
SELECT * FROM usersinchattingroom WHERE UserID = '$ID'
";

$ret = mysqli_query($connect_object, $searchUserChattingRoomBoxes);

$ChattingRoomIndicatingHTML = '';

while($row = mysqli_fetch_array($ret)){
    $ChattingRoomIndicatingHTML .= ChattingRoomSelectorBox::GetInstance($row['Title'], $row['Description']);
}

if(empty($ChattingRoomIndicatingHTML))
{
  $ChattingRoomIndicatingHTML .= '<p>';
  $ChattingRoomIndicatingHTML .= '채팅방이 존재하지 않습니다. 우측 상단바의 + 버튼을 눌러 채팅방을 추가해보세요!';
  $ChattingRoomIndicatingHTML .= '</p>';
}

?>

<!DOCTYPE html>
<html lang="kr">
<head>
  <title>유저 목록</title>
  <!-- meta 데이터 정의 -->
  <meta charset="utf-8">
  <meta name="description" content="Chatting web program">
  <meta name="keywords" content="Web Programming Term Project, Chatting">
  <meta name="author" content="Gyu Bong Lee">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" />

  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/ChattingRoomSelector.css">
</head>

<body id="background">
  <!-- 프로그램 창 -->
  <div id="Program_Window">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
      <div class="col-sm-11">
        <a class="navbar-brand" href="./ChattingRoomSelector.html">채팅 유저 목록<span class="badge badge-secondary">0</span></a>
      </div>
      <div class="col-sm-1">
        <div class="btn-group float-right">
          <button type="button" class="side_btn" data-toggle="modal" data-target="#modal"><img src="img/plus.svg" alt="Chatting Room Add Button"></img></button>
          <button type="button" class="btn side_btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="img/menu.svg" alt="sidebar menu"></img></button>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item active" href="#">로그아웃</a>
            <a class="dropdown-item" href="#">내 정보</a>
          </div>
          <button type="button" class="side_btn"><img src="img/user.svg" alt="user info button"></img></button>
        </div>
      </div>
    </nav>
  </div>

  <section class="container mt-1" style="padding-top: 75px;">

    <!-- 채팅 기록이 있는 유저 목록 -->
    <?php
     echo $ChattingRoomIndicatingHTML;
    ?>

    <!-- <div class="jumbotron userCard">
    <h1 class="display-4">우체국</h1>
    <hr class="my-4">
    <p>[우체국] [오전 9:28] 충남대학교우편취급국에서 영수증이 도착하였습니다. 결제금액 :800원 영수증 보기 http://epost.go.kr/r/?r=3gEvBuGj20h1VDC9CE</p>
    <p class="lead">
    <a class="btn btn-primary btn-lg" href="#" role="button">채팅방으로 이동</a>
  </p>
</div>
<div class="jumbotron userCard">
<h1 class="display-4">우체국</h1>
<hr class="my-4">
<p>[우체국] [오전 9:28] 충남대학교우편취급국에서 영수증이 도착하였습니다. 결제금액 :800원 영수증 보기 http://epost.go.kr/r/?r=3gEvBuGj20h1VDC9CE</p>
<p class="lead">
<a class="btn btn-primary btn-lg" href="#" role="button">채팅방으로 이동</a>
</p>
</div>
<div class="jumbotron userCard">
<h1 class="display-4">우체국</h1>
<hr class="my-4">
<p>[우체국] [오전 9:28] 충남대학교우편취급국에서 영수증이 도착하였습니다. 결제금액 :800원 영수증 보기 http://epost.go.kr/r/?r=3gEvBuGj20h1VDC9CE</p>
<p class="lead">
<a class="btn btn-primary btn-lg" href="#" role="button">채팅방으로 이동</a>
</p>
</div> -->
</section>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal">새 채팅방 추가</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="purePHP/ChattingRoomAddButtonClickedAction.php" onsubmit="return SubmitButtonClicked()" method="post" accept-charset="utf-8">
          <div class="form-group">
            <label for="RoomTitle">채팅방 제목</label>
            <input name="RoomTitle" type="text" class="form-control">
          </div>
          <div class="form-group">
            <label for="RoomDesc">채팅방 설명</label>
            <textarea name="RoomDesc" type="text" class="form-control" style="height: 180px;"></textarea>
          </div>
          <div class="form-group">
            <label for="OppenentID">상대방 ID</label>
            <input name="OppenentID" type="text" class="form-control">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
            <button type="submit" class="btn btn-primary">추가하기</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<footer id="Copyright" class="bg-dark mt-4 p-5 text-center"> &copy; 2019 웹프로그래밍 </footer>


<!-- 제이쿼리 자바스크립트 추가하기 -->
<script src="./lib/jquery-3.2.1.min.js"></script>
<!-- Popper 자바스크립트 추가하기 -->
<script src="./lib/popper.min.js"></script>
<!-- 부트스트랩 자바스크립트 추가하기 -->
<script src="./lib/bootstrap.min.js"></script>
<!-- MDB 라이브러리 추가하기 -->
<script src="./lib/mdb.min.js"></script>
<!-- 커스텀 자바스크립트 추가하기 -->
<script src="./js/ChattingRoomAddButtonClickedAction.js"></script>

</body>
</html>
