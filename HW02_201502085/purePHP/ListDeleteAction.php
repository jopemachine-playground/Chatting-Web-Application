<?php

$UserID = $_COOKIE['connectedUserID'];

$class = $_POST['classString'];
$index = $_POST['index'];

$fileSrc = '../data/listData/' . $UserID . '/' . $class . ".txt";

$data = fopen($fileSrc, "r") or die("Unable to open file!");

$buffer = '';

while(!feof($data)){
  // 한 줄 읽기
  $oneline_data = fgets($data);

  if(empty($oneline_data)){
    fclose($data);
    break;
  }

  $dataArray = explode('|', $oneline_data);

  // dataArray[3]은 index 번호

  // var_dump(intval(trim($dataArray[3])));
  // var_dump($index);
  // var_dump(intval($index));

  if(intval(trim($dataArray[3])) == intval($index)){
    // var_dump("file Index와 같음");
    $oneline_data = '';
  }
  else if(intval(trim($dataArray[3])) > intval($index)){
    // var_dump("file Index보다 작음");
    $oneline_data = $dataArray[0] . "|" . $dataArray[1] . "|" . $dataArray[2] . "|" . (intval(trim($dataArray[3])) - 1) . "\n";
  }

  $buffer .= $oneline_data;
}


$data_write = fopen($fileSrc, "w") or die("Unable to open file!");
fwrite ($data_write, $buffer);
fclose ($data_write);

echo "삭제 성공!";
