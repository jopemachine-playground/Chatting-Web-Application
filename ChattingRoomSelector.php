<?php
require_once('C:\xampp\WebProgramming_Project\purePHP\UserModalBox.php');
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
SELECT *
FROM usersinchattingroom
INNER JOIN chattingroomtbl
ON usersinchattingroom.RoomID = chattingroomtbl.RoomID
WHERE usersinchattingroom.UserID = '$ID'
";

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

<body id="Background">
  <!-- 프로그램 창 -->
  <div class="container">
    <nav id="FixedNavbar" class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
      <div class="col-sm-11">
        <a class="navbar-brand" href="./ChattingRoomSelector.php">채팅방 목록&nbsp;&nbsp;<span class="badge badge-secondary">0</span></a>
      </div>
      <div class="col-sm-1 responsive">
        <div class="btn-group float-right">
          <button type="button" class="side_btn" data-toggle="modal" data-target="#ChattingRoomAddModal"><img src="img/plus.svg" alt="Chatting Room Add Button"></img></button>
          <button type="button" class="btn side_btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="img/menu.svg" alt="sidebar menu"></img></button>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item active" onclick="logout()" href="#">로그아웃</a>
            <a class="dropdown-item" href="#">내 정보</a>
          </div>
          <button type="button" class="side_btn" data-toggle="modal" data-target="#UserInfoModal"><img src="img/user.svg" alt="user info button"></img></button>
        </div>
      </div>
    </nav>
  </div>

  <section id="ChattingRoomSection" class="container mt-1" style="padding-top: 75px;">

    <?php
    // 채팅 기록이 있는 유저 목록을 가져옴
    $isExecuted = false;

    $ret = mysqli_query($connect_object, $searchUserChattingRoomBoxes);

    while($row = mysqli_fetch_array($ret)){
      $isExecuted = true;
      echo ChattingRoomSelectorBox::CreateChattingRoomBox($row['Title'], $row['Description'], $ID, $row['RoomID']);
    }

    if($isExecuted == false)
    {
      echo '<p id="ChattingRoomNotExistedWarning"><br>채팅방이 존재하지 않습니다. <br><br>우측 상단바의 + 버튼을 눌러 채팅방을 추가해보세요!</p>';
    }

    ?>

  </section>

  <div id="UserInfoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">

        <?php
        // 유저 프로필 사진, ID 등을 표시하는 Small Modal Box
        $searchUserID = "
        SELECT * FROM usersinfotbl WHERE ID = '$ID'
        ";

        $ret = mysqli_query($connect_object, $searchUserID);

        $row = mysqli_fetch_array($ret);

        echo UserModalBox::GenerateUserInfoModal($row['ID'], $row['SignupDate'], $row['ProfileImageFileName']);
        ?>

      </div>
    </div>
  </div>

  <div id="ChattingRoomAddModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">새 채팅방 추가</h5>
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

  <div id="FooterDiv" class="navbar bg-dark p-1 fixed-bottom" style="margin-top: 70px;">
    <footer id="Copyright" class="bg-dark mt-4 p-3 text-center"> &copy; 2019 웹프로그래밍 </footer>
  </div>


  <!-- 제이쿼리 자바스크립트 추가하기 -->
  <script src="./lib/jquery-3.2.1.min.js"></script>
  <!-- Popper 자바스크립트 추가하기 -->
  <script src="./lib/popper.min.js"></script>
  <!-- 부트스트랩 자바스크립트 추가하기 -->
  <script src="./lib/bootstrap.min.js"></script>
  <!-- MDB 라이브러리 추가하기 -->
  <script src="./lib/mdb.min.js"></script>
  <!-- 제이쿼리 쿠키 플러그인 추가하기 -->
  <script src="./lib/jquery.cookie.js"></script>
  <!-- 커스텀 자바스크립트 추가하기 -->

  <script src="./js/ChattingRoomAddButtonClickedAction.js"></script>
  <!-- 커스텀 자바스크립트 추가하기 -->
  <script src="./js/ChattingRoomSelector.js"></script>
  <!-- 커스텀 자바스크립트 추가하기 -->
  <script src="./js/Logout.js"></script>

</body>
</html>
