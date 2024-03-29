<?php
require_once('MySQLConection.php');

// DB 연결
$connect_object = MySQLConnection::DB_Connect('chattingdb');

// Post 방식으로 유저 데이터를 가져옴
$ID = $_POST["ID"];
$PW = $_POST["PW"];
$PW_Confirm = $_POST["PW_Confirm"];
$Address = $_POST["Address"];
$PhoneNumber = $_POST["PhoneNumber"];
$Gender = $_POST["Gender"];
$Name = $_POST["FirstName"] . ' '. $_POST["LastName"];


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

if($_FILES['ProfileImage']['size'] != 0){
  // 중복 ID가 없는 경우, 프로필 사진 업로드 처리 및 폴더에 저장
  $ProfileImageUploadDir = 'C:\xampp\WebProgramming_Project\profileImages\\';

  // 아래 코드에서 mb_stristr가 파일 확장자만 잘라 ID와 붙인다
  $ProfileImageFileName = $ID . mb_stristr($_FILES['ProfileImage']['name'], '.');
  $ProfileImageFilePath = $ProfileImageUploadDir . $ProfileImageFileName;

  // 임시 디렉터리의 tmp 파일을 위 위치로 옮김
  if(move_uploaded_file($_FILES['ProfileImage']['tmp_name'], $ProfileImageFilePath)){
    echo "프로필 이미지 파일 전송 성공";
  }
  else{
    print "프로필 이미지 파일 전송 실패!\n";
  }
}
else{
  $ProfileImageFileName = '';
}

// DB에 새 레코드 입력
$insertData = "
  Insert INTO usersinfotbl (
    ID,
    PW,
    Address,
    PhoneNumber,
    ProfileImageFileName,
    Gender,
    Name,
    SignupDate
    ) VALUES(
    '$ID',
    '$PW',
    '$Address',
    '$PhoneNumber',
    '$ProfileImageFileName',
    '$Gender',
    '$Name',
    Now()
)";

$ret = mysqli_query($connect_object, $insertData) or die("Error Occured in Inserting Message to DB");

echo ("<script language=javascript>alert('축하합니다! 회원가입이 완료되었습니다!')</script>");
echo ("<script>location.href='../SignIn.html';</script>");

mysqli_close($connect_object);
