<?php

$UserID = $_COOKIE['connectedUserID'];

$class = $_POST['class'];
$memo = $_POST['memo'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

$id_index = $_POST['index'];

$fileSrc = '../data/listData/' . $UserID . '/' . $class . ".txt";

$data = fopen($fileSrc, "a+") or die("Unable to open file!");

// 데이터 입력 순서는 아래와 같음.
$content = $memo . "|" . $start_date. "|" . $end_date . "|" . $id_index . "\n";

// 데이터 입력
fwrite($data, $content) or die("Erorr Occur");

if($start_date == '' && $end_date == ''){
  $result = "<li id=". $class .'-'. $id_index ." ondragstart='startDrag(event)' draggable='true'>" . $memo . "&nbsp;<span onclick='DeleteItem(parentNode.id)'>&times;</span></li>";
}
else{
  $result = "<li class='withDate' id=". $class .'-'. $id_index ." ondragstart='startDrag(event)' draggable='true'>" . $memo . " (" . $start_date . " ~ " .  trim($end_date) . ")&nbsp;<span onclick='DeleteItem(parentNode.id)'>&times;</span></li>";
}

// 새로 입력한 부분만 데이터를 가져가 갖다 붙인다.
echo json_encode(array($class => $result));
