<?php

$UserID = $_COOKIE['connectedUserID'];

$prev_classString = $_POST['prev_classString'];
$after_classString = $_POST['after_classString'];
$prev_Index = $_POST['prev_Index'];

$memo = $_POST['memo'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$id_index = $_POST['index'];

$prev_fileSrc = '../data/listData/' . $UserID . '/' . $prev_classString . ".txt";
$after_fileSrc = '../data/listData/' . $UserID . '/' . $after_classString . ".txt";

$prev_file = fopen($prev_fileSrc, "r") or die("Unable to open file!");
$after_file = fopen($after_fileSrc, "a+") or die("Unable to open file!");

$buffer = '';

while(!feof($prev_file)){
  // 한 줄 읽기
  $oneline_data = fgets($prev_file);

  if(empty($oneline_data)){
    fclose($prev_file);
    break;
  }

  $dataArray = explode('|', $oneline_data);

  if(intval(trim($dataArray[3])) == intval($prev_Index)){
    // var_dump("file Index와 같음");
    $oneline_data = '';
  }
  else if(intval(trim($dataArray[3])) > intval($prev_Index)){
    // var_dump("file Index보다 작음");
    $oneline_data = $dataArray[0] . "|" . $dataArray[1] . "|" . $dataArray[2] . "|" . (intval(trim($dataArray[3])) - 1) . "\n";
  }

  $buffer .= $oneline_data;
}

$data_delete = fopen($prev_fileSrc, "w") or die("Unable to open file!");
fwrite ($data_delete, $buffer);
fclose ($data_delete);


$content = $memo . "|" . $start_date. "|" . $end_date . "|" . $id_index . "\n";

fwrite($after_file, $content) or die("Erorr Occur");

echo "인덱스 변경 작업 성공";
