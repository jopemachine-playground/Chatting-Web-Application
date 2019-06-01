<?php

$UserID = $_COOKIE['connectedUserID'];

$Keyword = $_POST['Keyword'];
$Start_date = $_POST['Start_date'];
$End_date = $_POST['End_date'];
$SortCriteria = $_POST['SortCriteria'];
$SortOrder = $_POST['SortOrder'];

$fileSrc_family = '../data/listData/' . $UserID . '/family.txt';
$fileSrc_school = '../data/listData/' . $UserID . '/school.txt';
$fileSrc_exercise = '../data/listData/' . $UserID . '/exercise.txt';
$fileSrc_travel = '../data/listData/' . $UserID . '/travel.txt';

$data = array();
// 서치 결과를 담을 array.
$search_result = array();


$data['family'] = fopen($fileSrc_family, "r") or die("Unable to open file!");
$data['school'] = fopen($fileSrc_school, "r") or die("Unable to open file!");
$data['exercise'] = fopen($fileSrc_exercise, "r") or die("Unable to open file!");
$data['travel'] = fopen($fileSrc_travel, "r") or die("Unable to open file!");

$criteria = 0;
$order = 0;

// usort에서 사용하는 함수. 전역변수로 criteria, order를 사용한다
// criteria에 따라, 0이면 keyword, 1이면 start_date, 2면 end_date로 정렬한다
// order가 1이면 오름차순, -1이면 내림차순으로 정렬한다.
function user_compare_data_byIndex($record_a, $record_b){
  global $criteria;
  global $order;

  $a_data = explode('|', $record_a);
  $b_data = explode('|', $record_b);

  if ($a_data[$criteria] == $b_data[$criteria]) {
    return 0;
  }
  return ($a_data[$criteria] < $b_data[$criteria]) ? (-1 * $order) : (1 * $order);
}

foreach($data as $key => $value){

  while(!feof($data[$key])){

    $isInArray = false;

    // 한 줄 읽기
    $oneline_data = fgets($data[$key]);
    if(empty($oneline_data)){
      fclose($data[$key]);
      break;
    }

    // 한 줄 파싱
    $dataArray = explode('|', $oneline_data);

    if(!empty($Keyword) && !empty($dataArray[0])){
      if((mb_strpos($dataArray[0], $Keyword) !== false)){
        $isInArray = true;
      }
      else{
        continue;
      }
    }

    // 시작 날짜가 있고 끝 날짜는 비게 입력한 경우
    if(!empty($Start_date) && empty($End_date)){

      // 레코드에 시작날짜가 기입되어 있지 않다면 false
      if(empty($dataArray[1])){
        continue;
      }

      $thisRecordDate = explode('-', $dataArray[1]);
      $searchingStartDate = explode('-', $Start_date);

      // year 비교
      if($thisRecordDate[0] > $searchingStartDate[0]){
        $isInArray = true;
      }
      // month 비교
      else if(($thisRecordDate[0] == $searchingStartDate[0]) && $thisRecordDate[1] > $searchingStartDate[1]){
        $isInArray = true;
      }
      // day 비교
      else if(($thisRecordDate[0] == $searchingStartDate[0]) && ($thisRecordDate[1] == $searchingStartDate[1]) && ($thisRecordDate[2] >= $searchingStartDate[2])){
        $isInArray = true;
      }
      else{
        $isInArray = false;
      }
    }

    else if(!empty($End_date) && empty($Start_date)){

      if(empty($dataArray[2])){
        continue;
      }

      $thisRecordDate = explode('-', $dataArray[2]);
      $searchingEndDate = explode('-', $End_date);

      // year 비교
      if($thisRecordDate[0] < $searchingEndDate[0]){
        $isInArray = true;
      }
      // month 비교
      else if(($thisRecordDate[0] == $searchingEndDate[0]) && $thisRecordDate[1] < $searchingEndDate[1]){
        $isInArray = true;
      }
      // day 비교
      else if(($thisRecordDate[0] == $searchingEndDate[0]) && ($thisRecordDate[1] == $searchingEndDate[1]) && ($thisRecordDate[2] <= $searchingEndDate[2])){
        $isInArray = true;
      }
      else{
        $isInArray = false;
      }
    }

    // StartDate와 End Date가 모두 들어가 있다면 And 조건으로 검사한다
    else if(!empty($End_date) && !empty($Start_date)){

      if(empty($dataArray[1]) || empty($dataArray[2])){
        continue;
      }

      $searchingStartDate = explode('-', $Start_date);
      $thisStartRecordDate = explode('-', $dataArray[1]);
      $searchingEndDate = explode('-', $End_date);
      $thisEndRecordDate = explode('-', $dataArray[2]);

      // year 비교
      if(($thisEndRecordDate[0] < $searchingEndDate[0]) &&
       ($thisStartRecordDate[0] > $searchingStartDate[0])){
        $isInArray = true;
      }
      // month 비교
      else if(($thisEndRecordDate[0] == $searchingEndDate[0]) && ($thisEndRecordDate[1] < $searchingEndDate[1]) &&
      ($thisStartRecordDate[0] == $searchingStartDate[0]) && ($thisStartRecordDate[1] > $searchingStartDate[1]))
      {
        $isInArray = true;
      }
      // day 비교
      else if(($thisEndRecordDate[0] == $searchingEndDate[0]) && ($thisEndRecordDate[1] == $searchingEndDate[1]) && ($thisEndRecordDate[2] <= $searchingEndDate[2])
      && ($thisStartRecordDate[0] == $searchingStartDate[0]) && ($thisStartRecordDate[1] == $searchingStartDate[1]) && ($thisStartRecordDate[2] >= $searchingStartDate[2]))
      {
        $isInArray = true;
      }
      else{
        $isInArray = false;
      }
    }

    if($isInArray == true){
      array_push($search_result, $oneline_data);
    }

  }
}

// SortOrder나 SortCriteria가 비어 있지 않다면 정렬을 해서 줘야함
if(!empty($SortCriteria)){

  if($SortCriteria == 'sortBy_keyword'){
    $criteria = 0;
  }
  else if($SortCriteria == 'sortBy_startDate'){
    $criteria = 1;
  }
  else if($SortCriteria == 'sortBy_endDate'){
    $criteria = 2;
  }
  else {
    $criteria = 0;
  }

  if(empty($SortOrder)){
    $order = 1;
  }
  else if($SortOrder == 'descending'){
    $order = -1;
  }
  else if($SortOrder == 'ascending'){
    $order = 1;
  }
  else {
    $order = 1;
  }
  usort($search_result , 'user_compare_data_byIndex');
}


echo json_encode($search_result);
