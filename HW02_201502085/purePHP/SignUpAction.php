<?php

$UserID = $_POST['ID'];
$UserPW = $_POST['PW'];

if(!file_exists('../data/person.txt')){
	$myFile = fopen("../data/person.txt", "x+") or die("Unable to make file!");
}
else{
  $myFile = fopen("../data/person.txt", "r") or die("Unable to open file!");
}

while(!feof($myFile)){
  $oneline_data = fgets($myFile);
  $usersInfo = explode('|', $oneline_data);

  if($usersInfo[0] == $UserID){
    echo ("<script language=javascript>alert('이미 존재하는 ID 입니다!')</script>");
    echo ("<script>location.href='../SignUp.html';</script>");
    exit();
  }
}

$myFile = fopen("../data/person.txt", "a+") or die("Unable to open file!");

$content = $UserID . "|" . "$UserPW". "\n";

// 계정 생성
fwrite($myFile, $content);

// 계정에 대응되는 데이터 폴더 생성
mkdir("../data/listData/" . $UserID);

// 계정에 대한 정보 생성
fopen("../data/listData/" . $UserID . "/family.txt", "x+");
fopen("../data/listData/" . $UserID . "/school.txt", "x+");
fopen("../data/listData/" . $UserID . "/travel.txt", "x+");
fopen("../data/listData/" . $UserID . "/exercise.txt", "x+");

echo ("<script>location.href='../SignIn.html';</script>");
