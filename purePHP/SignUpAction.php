<!-- 파일 전송에 관한 부분은 오른쪽 페이지 참고함 https://opentutorials.org/course/62/5136 -->
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

// 중복 ID가 존재하는 경우 에러처리
while($row = mysqli_fetch_array($ret)){
  if($ID == $row['ID']){
    echo ("<script language=javascript>alert('중복된 ID가 있습니다.')</script>");
    echo ("<script>location.href='../SignUp.html';</script>");
    exit();
  }
}

// 중복 ID가 없는 경우, 프로필 사진 업로드 처리 및 폴더에 저장
$ProfileImageUploadDir = 'C:\xampp\WebProgramming_Project\profileImages\\';
$ProfileImageFileName = $ID . mb_stristr($_FILES['ProfileImage']['name'], '.');
$ProfileImageFilePath = $ProfileImageUploadDir . $ProfileImageFileName;

// 임시 디렉터리의 tmp 파일을 위 위치로 옮김
if(move_uploaded_file($_FILES['ProfileImage']['tmp_name'], $ProfileImageFilePath)){
  echo "프로필 이미지 파일 전송 성공";
}
else{
  print "프로필 이미지 파일 전송 실패!\n";
}

// DB에 새 레코드 입력
$insertData = "
Insert INTO usersinfotbl (
  ID,
  PW,
  Address,
  PhoneNumber,
  ProfileImageFileName,
  SignupDate
  ) VALUES(
    '$ID',
    '$PW',
    '$Address',
    '$PhoneNumber',
    '$ProfileImageFileName',
    Now()
    )";

    $ret = mysqli_query($connect_object, $insertData);

    echo ("<script language=javascript>alert('축하합니다! 회원가입이 완료되었습니다!')</script>");
    echo ("<script>location.href='../SignIn.html';</script>");

    mysqli_close($connect_object);
