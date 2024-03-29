<?php
require_once('purePHP\UserModalBox.php');
require_once('purePHP\MessageWindow.php');
require_once('purePHP\MySQLConection.php');

$UserID = $_COOKIE["connectedUserID"];
$RoomID = $_GET["RoomID"];

// 쿠키가 없는 상태는, 로그인 되지 않은 상태로 간주하고 접속을 거부함
if(empty($UserID)){
  echo ("<script language=javascript>alert('먼저 로그인하세요!')</script>");
  echo ("<script>location.href='SignIn.html';</script>");
}

$connect_object = MySQLConnection::DB_Connect('chattingdb');

// RoomID 및 UserID가 일치하는 채팅방을 검색함
// 해당 레코드가 존재하지 않는다면 잘못된 접근으로 간주함
$searchThisUserBeInThisChattingRoom = "
  SELECT * FROM usersinchattingroom WHERE RoomID = '$RoomID' AND UserID = '$UserID'
";

$ret = mysqli_query($connect_object, $searchThisUserBeInThisChattingRoom);

if(empty($ret)){
  echo ("<script language=javascript>alert(".$UserID."님은 이 채팅방에 등록되어 있지 않습니다.\n방장에게 문의하세요.')</script>");
  echo ("<script>location.href='ChattingRoomSelector.php';</script>");
  exit();
}

// chattingroomtbl에서 해당 방의 정보 (제목) 를 가져옴
$searchChattingRoomTitle = "
  SELECT * FROM chattingroomtbl WHERE RoomID = '$RoomID'
";

$ret_title = mysqli_query($connect_object, $searchChattingRoomTitle);

$row = mysqli_fetch_array($ret_title);

$RoomTitle = $row['Title'];

?>

<!DOCTYPE html>
<html lang="kr">
<head>
  <title><?php echo $RoomTitle;?></title>
  <!-- meta 데이터 정의 -->
  <meta charset="utf-8">
  <meta name="description" content="Chatting web page">
  <meta name="keywords" content="Web Programming Term Project, Chatting, chatting Program">
  <meta name="author" content="Gyu Bong Lee">
  <!-- 반응형 웹페이지 구현을 위한 meta 데이터 -->
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" />

  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/ChattingRoom.css">
  <!-- Favicon 적용 -->
  <link rel="shortcut icon" size="16x16" href="./img/favicon.ico" />
</head>

<body id="Background">
  <div class="container">
      <nav id="FixedNavbar" class="navbar navbar-dark fixed-top" style="background-color: #2c65c1 !important">

        <!-- ChattingRoom 페이지는 다른 페이지들보다 제목의 중요성을 생각해, 제목이 중앙에 오게 배치했음 -->
        <img src="img/message-square.svg" style="margin-right: 10px;">
        <a id="ChattingRoomTitle" class="navbar-brand" href="./ChattingRoom.html"><?php echo $RoomTitle;?></a>

        <!-- 창 너비에 따라 버튼이 미디어 쿼리로, 두 종류로 나뉜다. -->
        <!-- 아래의 버튼은 창이 작을 때, 핸드폰이나 태블릿 같은 환경에서 사용할 버튼 및 a 태그 들이다.-->
        <button class="navbar-toggler responsiveNone2" data-toggle="collapse" data-target="#navCollapse">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div id="navCollapse" class="collapse navbar-collapse responsiveNone2">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" onclick="ToChattingRoom();">채팅방 선택화면</a>
            </li>
            <li class="nav-item">
              <a class="nav-link">내 정보</a>
            </li>
            <li class="nav-item">
              <a onclick="logout()" class="nav-link">로그아웃</a>
            </li>
            <li class="nav-item">
              <a class="nav-link">정보수정</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="modal" data-target="#UserInviteBox">초대하기</a>
            </li>
          </ul>
        </div>

        <!-- 아래의 버튼들은 데스크톱에서 사용할 이미지 버튼 및 dropdown-menu 이다. -->
        <div class="btn-group float-right responsiveNone" style="position: absolute; right: 15px;">
          <button type="button" class="side_btn sizeUpOnHover"><img src="img/arrow-left.svg" alt="return chatting room" onclick="ToChattingRoom();"></button>

          <!-- aria-haspopup은 스마트폰 등의 기기에서 터치로 조작할 수 있는지의 여부, aria-expanded는 기본 활성화 여부를 나타낸다. -->
          <button type="button" class="btn-sm side_btn dropdown-toggle sizeUpOnHover" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="img/menu.svg" alt="sidebar menu"></img></button>
          <div class="dropdown-menu dropdown-menu-right">
            <!-- dropdown-item들은 dropdown-menu에 들어가는 각각의 요소 -->
            <a class="dropdown-item active" onclick="logout()">로그아웃</a>
            <a class="dropdown-item" onclick="ToChattingRoom();">채팅방 선택화면</a>
            <a class="dropdown-item" href="#">내 정보</a>
          </div>
          <button type="button" class="side_btn sizeUpOnHover" data-toggle="modal" data-target="#UserInfoModal"><img src="img/user.svg" alt="user info button"></button>
          <button type="button" class="side_btn sizeUpOnHover" data-toggle="modal" data-target="#UserInviteBox"><img src="img/user-plus.svg" alt="other user Invite button"></button>
        </div>

        <div class="responsiveNone" style="width: 60px;"></div>

    </nav>
  </div>

  <!-- Ajax로 가져온 메시지가 아래에 표시됨 -->
  <section id="Message_Window" class="container" style="padding-top:100px;"></section>

  <!-- aria-hidden은 기본 hidden 설정 값 -->
  <div id="UserInfoModal" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">

        <?php
        // 유저 프로필 사진, ID 등을 표시하는 Small Modal Box
        $searchUserID = "
          SELECT * FROM usersinfotbl WHERE ID = '$UserID'
        ";

        $ret = mysqli_query($connect_object, $searchUserID);

        $row = mysqli_fetch_array($ret);

        echo UserModalBox::GenerateUserInfoModal($row['ID'], $row['SignupDate'], $row['ProfileImageFileName']);
        ?>

      </div>
    </div>
  </div>

  <!-- 유저를 초대하기 위한 Modal box. -->
  <!-- fade 클래스를 이용해 애니메이션을 줌 -->
  <!-- tabindex에 대해선 오른쪽 참고 https://developers.google.com/web/fundamentals/accessibility/focus/using-tabindex?hl=ko -->

  <div id="UserInviteBox" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">유저 초대</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <!-- times를 x 버튼 대신 이용함 -->
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="InvitedUserID">상대방 ID</label>
                <input id="InvitedUserID" name="InvitedUserID" type="text" class="form-control">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="otherUserInvite();">추가하기</button>
              </div>
          </div>
        </div>
      </div>
    </div>

  <!-- 아래 보다 나은 방법은 아직 못 찾았음. 적당히 heigtht를 줘서 반응형으로 기능할 수 있게 했지만, 페이지 아래쪽에 공백이 생긴다.  -->
  <div id="WhiteSpaceForResponsivePage"></div>

  <!-- 메시지 작성 박스 + Footer. -->
  <footer id="Message_Writing_Box" class="container-fluid navbar p-2 fixed-bottom" style="background-color: #2c65c1 !important">
    <div class="row">

      <!-- 왼쪽에 어느 정도 공백을 줘야 여유가 있어 보여 이렇게 했다. -->
      <div class="col-sm-1"></div>

      <div class="col-sm-9 text-right" style="margin-top:10px;" title="전송할 메시지를 입력하세요.">
        <form>
          <textarea id="Sending_Message_Box" name="message" rows="4" cols="400" ondrop="fileUploadByDrag(event)" ondragover="colorChangeByDragOver()" ondragleave="colorChangeByDragLeave()" placeholder="여기에 메시지를 입력하거나, 파일을 드래그 해 전송하세요." autofocus></textarea>
          <input id="fileSelector" style="display: none;" type="file"></button>
          <img style="position: absolute; bottom: 25px; right: 32px;" class="responsiveNone2" src="./img/file.svg" onclick="document.getElementById('fileSelector').click();">
        </form>
      </div>

      <div class="col-sm-1.5 responsiveNone">
        <button id="Message_Send_Button" type="submit" class="btn btn-block btn-success" title="메시지를 전송합니다." onclick="HandlingSendEvent()">전송</button>
      </div><br>
    </div>

    <div class="row" style="width: 100%">
      <div style="margin:0 auto">
        <div id="Copyright"> &copy; 2019 웹프로그래밍 &nbsp; <em>이규봉</em> &nbsp;&nbsp; <sub>Term Project</sub></div>
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
  <!-- 자바스크립트 종속성 관리를 위한 라이브러리 추가하기 -->
  <script src="./lib/require.js"></script>
  <!-- 파일 다운로드를 위한 라이브러리 추가하기 -->
  <script src="./lib/FileSaver.js"></script>
  <!-- 커스텀 자바스크립트 추가하기 -->
  <script src="./js/ChattingRoom.js"></script>
  <!-- 커스텀 자바스크립트 추가하기 -->
  <script src="./js/Logout.js"></script>

</body>
</html>
