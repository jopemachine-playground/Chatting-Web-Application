<?php
require_once('purePHP\UserModalBox.php');
require_once('purePHP\MySQLConection.php');
require_once('purePHP\ChattingRoomSelectorBox.php');

$ID = $_COOKIE["connectedUserID"];

// 쿠키가 소멸되면 로그아웃 됨
// 로그아웃은 js 파일에서 쿠키를 제거하는 것으로 구현함
if(empty($ID)){
  echo ("<script language=javascript>alert('먼저 로그인하세요!')</script>");
  echo ("<script>location.href='SignIn.html';</script>");
  exit();
}

$connect_object = MySQLConnection::DB_Connect('chattingdb');

// 로그인 된 유저의 모든 채팅방 및 채팅방의 정보를 가져와야 하므로,  
// InnerJoin을 이용해 ChattingRoomTbl과 UsersInChattingRoomTbl을 합친다.
$searchUserChattingRoomBoxes = "
  SELECT *
  FROM usersinchattingroom
  INNER JOIN chattingroomtbl
  ON usersinchattingroom.RoomID = chattingroomtbl.RoomID
  WHERE usersinchattingroom.UserID = '$ID'
";

// ID 검색
$searchUserID = "
  SELECT * FROM usersinfotbl WHERE ID = '$ID'
";

$ret_userID = mysqli_query($connect_object, $searchUserID);
$row_userID = mysqli_fetch_array($ret_userID);

// 존재하는 아이디인지, 자바스크립트로 점검했더라도 서버 쪽에서 다시 점검한다.
// 서버 쪽 부하가 커질 것 같으면, 아래 문장을 빼고 가입입을 캐시로 넣자
if(mysqli_num_rows($ret_userID) < 1){
  echo ("<script language=javascript>alert('존재하지 않는 ID입니다!')</script>");
  echo ("<script>location.href='SignIn.html';</script>");
  exit ();
}

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
    <!-- Favicon 적용 -->
    <link rel="shortcut icon" size="16x16" href="./img/favicon.ico" />
  </head>

  <body id="Background">
    <div class="container">
      <!-- 인라인으로 스타일을 준 것은, bootstrap.css에서 색상 속성이 !important로 선언되어 있기 때문임. boostrap 파일을 변경하기보단, 인라인으로 새 속성을 주었음 -->
      <nav id="FixedNavbar" class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #2c65c1 !important">

        <a class="navbar-brand" href="./ChattingRoomSelector.php"><img src="img/message-square.svg" style="margin-right: 10px;">채팅방 목록</a>

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

        <!-- 아래의 버튼들은 데스크톱에서 사용할 버튼 -->

        <!-- 텍스트를 중간에 배치하기 위해 버튼들을 absoulte로 놓고 오른쪽엔 div로 따로 공간을 두었음 -->
        <!-- sizeUpOnHover가 들어간 엘리먼트는 hover 하면 크기가 커짐 -->
        <div class="btn-group float-right responsiveNone">
          <button type="button" class="side_btn sizeUpOnHover" data-toggle="modal" data-target="#ChattingRoomAddModal"><img src="img/plus.svg" alt="Chatting Room Add Button"></button>
          <button type="button" class="btn-sm side_btn dropdown-toggle sizeUpOnHover" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="img/menu.svg" alt="sidebar menu"></button>
          <div class="dropdown-menu dropdown-menu-right">
            <!-- 로그아웃: 쿠키 제거 -->
            <a class="dropdown-item active" onclick="logout()" href="#">로그아웃</a>
            <a class="dropdown-item" href="#">내 정보</a>
          </div>
          <button type="button" class="side_btn sizeUpOnHover" data-toggle="modal" data-target="#UserInfoModal"><img src="img/user.svg" alt="user info button"></button>
        </div>
      
      </nav>
    </div>

    <section id="ChattingRoomSection" class="container mt-1" style="padding-top: 75px;">

      <?php

        // 서버의 DB에서 채팅 기록이 있는 유저와의 채팅방들을 가져옴
        // 검색된 채팅방이 없는 경우, 채팅방이 없다는 알림창을 띄움
        $ret_chattingRooms = mysqli_query($connect_object, $searchUserChattingRoomBoxes);
        
        if(mysqli_num_rows($ret_chattingRooms) < 1)
        {
          echo ChattingRoomSelectorBox::WarnNoChattingRoomsToShow();
        }

        while($row = mysqli_fetch_array($ret_chattingRooms)){
          echo ChattingRoomSelectorBox::CreateChattingRoomBox($row['Title'], $row['Description'], $row['RoomID']);
        }

      ?>

    </section>

    <!-- 더 좋은 방법을 찾으면 아래 공백을 없애고 싶다 -->
    <div id="WhiteSpaceForResponsivePage"></div>
    
    <!-- fade 클래스를 이용해 애니메이션을 줌 -->
    <!-- tabindex에 대해선 오른쪽 참고 https://developers.google.com/web/fundamentals/accessibility/focus/using-tabindex?hl=ko -->
    <div id="UserInfoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <!-- modal-sm, modal-md, modal-lg는 modal 창 크기에 대한 부트스트랩 속성임 -->
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <?php
            echo UserModalBox::GenerateUserInfoModal($row_userID['ID'], $row_userID['SignupDate'], $row_userID['ProfileImageFileName']);
          ?>
        </div>
      </div>
    </div>

    <!-- 채팅방을 추가하기 위한 Modal box. -->
    <div id="ChattingRoomAddModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">새 채팅방 추가</h5>
            <!-- data-dismiss 속성을 통해, 취소 버튼을 누르면 모달 박스가 없어지는 것을 구현 -->
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <!-- times를 x 버튼 대신 이용함 -->
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="purePHP/ChattingRoomAddButtonClickedAction.php" onsubmit="return AddChattingRoomButtonClicked()" method="post" accept-charset="utf-8">
              <div class="form-group">
                <label for="RoomTitle">채팅방 제목</label>
                <input id="newChattingRoom_Title" name="RoomTitle" type="text" class="form-control">
              </div>
              <div class="form-group">
                <label for="RoomDesc">채팅방 설명</label>
                <textarea id="newChattingRoom_Desc" name="RoomDesc" type="text" class="form-control" style="height: 180px;"></textarea>
              </div>
              <div class="form-group">
                <label for="OppenentID">상대방 ID</label>
                <input id="OppenentID" name="OppenentID" type="text" class="form-control">
              </div>
              <div class="modal-footer">
                <!-- data-dismiss 속성을 통해, 취소 버튼을 누르면 모달 박스가 없어지는 것을 구현 -->
                <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                <button type="submit" class="btn btn-primary">추가하기</button>
              </div>
          </div>
        </div>
      </div>
    </div>

    <!-- 부트스트랩에서 Custom Modal Box의 기본적인 틀. prompt 대신 사용함 -->
    <!-- 채팅방에서 나갈 것인지 확인하기 위해 띄우는 모달 박스 -->
    <!-- btn-sm, btn-md, btn-lg는 버튼 크기에 대한 부트스트랩 속성임 -->
    <div id="DeleteConfirmModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
              <h4 class="text-center" style="font-size: 15px; margin-bottom: 20px;">채팅방에서 나가시겠습니까?<br>채팅방 로그는 없어지지 않습니다.</h4>
              <div class="text-center" style="width: 70%; margin: 0 auto">
                <a class="btn btn-sm btn-danger btn-yes btn-block" style="color:#ffffff;" data-dismiss="modal" onclick="DeleteChattingRoom()">네</a>
                <!-- data dismiss란 attribute를 줌으로써, 모달 박스를 닫는 이벤트를 구현할 수 있음 -->
                <a class="btn btn-sm btn-success btn-no btn-block" style="color:#ffffff;" data-dismiss="modal">아니오</a>
              </div>
            </div>
        </div>
      </div>
    </div>

    <!-- p는 padding, mt는 margin-top란 의미 (Bootstrap 4 API spacing 참고) -->
    <div id="FooterDiv" class="navbar p-1 fixed-bottom" style="background-color: #2c65c1 !important">
      <footer id="Copyright" class="p-3 text-center"> &copy; 2019 웹프로그래밍 &nbsp; <em>이규봉</em> &nbsp;&nbsp; <sub>Term Project</sub> </footer>
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
    <script src="./js/ChattingRoomSelector.js"></script>
    <!-- 커스텀 자바스크립트 추가하기 -->
    <script src="./js/Logout.js"></script>

  </body>
</html>
