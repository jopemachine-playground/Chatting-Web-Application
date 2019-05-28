<?php
require_once('purePHP\UserModalBox.php');
require_once('purePHP\MySQLConection.php');
require_once('purePHP\ChattingRoomSelectorBox.php');

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
  <meta name="description" content="Chatting web program ChattingRoom Selector">
  <meta name="keywords" content="Web Programming Term Project, Chatting">
  <meta name="author" content="Gyu Bong Lee">
  <!-- 반응형 웹페이지 구현을 위한 meta 데이터 -->
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" />

  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/ChattingRoomSelector.css">
</head>

<body id="Background">
  <div class="container">
    <nav id="FixedNavbar" class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">

      <!-- badge 같은 경우, Notification 수 등을 표기하는데 사용됨  -->
      <a class="navbar-brand" href="./ChattingRoomSelector.php">채팅방 목록&nbsp;&nbsp;<span class="badge badge-secondary">0</span></a>

      <!-- 창 너비에 따라 버튼이 미디어 쿼리로, 두 종류로 나뉜다. -->
      <!-- 아래의 버튼은 창이 작을 때, 핸드폰이나 태블릿 같은 환경에서 사용할 버튼 및 a 태그 들이다.-->
      <button class="navbar-toggler responsiveNone2" data-toggle="collapse" data-target="#navCollapse">
        <!-- 아이콘 같은 걸 넣을 때 span 태그를 사용함 -->
        <span class="navbar-toggler-icon"></span>
      </button>

      <div id="navCollapse" class="collapse navbar-collapse responsiveNone2">

        <!-- ml은 margin-left. -->
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" data-toggle="modal" data-target="#ChattingRoomAddModal">새 채팅방 만들기</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" onclick="logout()">로그아웃</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="modal" data-target="#UserInfoModal">내 정보</a>
          </li>
        </ul>
      </div>

      <!-- 아래의 버튼은 데스크톱에서 사용할 버튼 -->
      <div class="btn-group float-right responsiveNone">
        <button type="button" class="side_btn" data-toggle="modal" data-target="#ChattingRoomAddModal"><img src="img/plus.svg" alt="Chatting Room Add Button"></img></button>
        <button type="button" class="btn side_btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="img/menu.svg" alt="sidebar menu"></img></button>
        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item active" onclick="logout()" href="#">로그아웃</a>
          <a class="dropdown-item" href="#">내 정보</a>
        </div>
        <button type="button" class="side_btn" data-toggle="modal" data-target="#UserInfoModal"><img src="img/user.svg" alt="user info button"></img></button>
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

  <!-- 더 좋은 방법을 찾으면 아래 공백을 없애고 싶다 -->
  <div id="WhiteSpaceForResponsivePage"></div>

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
            <!-- times를 x 버튼 대신 이용함 -->
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
        </div>
      </div>
    </div>
  </div>

  <!-- 부트스트랩에서 Custom Modal Box의 기본적인 틀. prompt 대신 사용함 -->
  <div id="DeleteConfirmModal" class="modal fade" role="dialog">
     <div class="modal-dialog">
        <div class="modal-content">
           <div class="modal-body">
             <h4 class="text-center" style="font-size: 15px; margin-bottom: 20px;">채팅방에서 나가시겠습니까?<br>채팅방 로그는 없어지지 않습니다.</h4>
             <div class="text-center" style="width: 70%; margin: 0 auto">
               <a class="btn btn-sm btn-danger btn-yes btn-block" style="color:#ffffff;" onclick="DeleteChattingRoom()">네</a>
               <!-- data dismiss란 attribute를 줌으로써, 모달 박스를 닫는 이벤트를 구현할 수 있음 -->
               <a class="btn btn-sm btn-success btn-no btn-block" style="color:#ffffff;" data-dismiss="modal">아니오</a>
             </div>
           </div>
       </div>
    </div>
  </div>

  <!-- p는 padding, mt는 margin-top란 의미 (Bootstrap 4 API spacing 참고) -->
  <div id="FooterDiv" class="navbar bg-dark p-1 fixed-bottom">
    <footer id="Copyright" class="bg-dark mt-4 p-3 text-center"> &copy; 2019 웹프로그래밍 &nbsp; <em>이규봉</em> &nbsp;&nbsp; <sub>Term Project</sub> </footer>
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
