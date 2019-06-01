<?php
// 모든 데이터를 전송한다.

$UserID = $_COOKIE['connectedUserID'];

$fileSrc_family = '../data/listData/' . $UserID . '/family.txt';
$fileSrc_school = '../data/listData/' . $UserID . '/school.txt';
$fileSrc_exercise = '../data/listData/' . $UserID . '/exercise.txt';
$fileSrc_travel = '../data/listData/' . $UserID . '/travel.txt';

$data = array();
$result = array();

$data['family'] = fopen($fileSrc_family, "r") or die("Unable to open file!");
$data['School'] = fopen($fileSrc_school, "r") or die("Unable to open file!");
$data['Exercise'] = fopen($fileSrc_exercise, "r") or die("Unable to open file!");
$data['Travel'] = fopen($fileSrc_travel, "r") or die("Unable to open file!");

foreach($data as $key => $value){

  $result[$key] = '';

  $id_index = 0;

  while(!feof($data[$key])){
    // 한 줄 읽기
    $oneline_data = fgets($data[$key]);
    if(empty($oneline_data)){
      fclose($data[$key]);
      break;
    }

    // 한 줄 파싱
    $dataArray = explode('|', $oneline_data);

    if($dataArray[1] == '' && $dataArray[2] == ''){
      $result[$key] .= "<li id=". $key .'-'. $id_index++ ." ondragstart='startDrag(event)' draggable='true'>" . $dataArray[0] . "&nbsp;<span onclick='DeleteItem(parentNode.id)'>&times;</span></li>";
    }
    else{
      $result[$key] .= "<li class='withDate' id=". $key .'-'. $id_index++ ." ondragstart='startDrag(event)' draggable='true'>" . $dataArray[0] . " (" .$dataArray[1] . " ~ " .  trim($dataArray[2]) . ")&nbsp;<span onclick='DeleteItem(parentNode.id)'>&times;</span></li>";
    }
  }
}

echo json_encode(array("family" => $result['family'], "School" => $result['School'], "Exercise" => $result['Exercise'], "Travel" => $result['Travel']));
