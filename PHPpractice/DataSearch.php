<?php

$fileName = $_POST["a1"];
$word = $_POST["b1"];

class DataSearch{

  public static function show($_fileName, $_word){

    $resultString = "";
    $fp = fopen("data.txt", "r") or die("fail to open file");

    while(!feof($fp)){

      $oneline_data = fgets($fp);
      $dataArray = explode(' ', $oneline_data);

      if(empty($oneline_data)){
        continue;
      }

      if(empty($_fileName)){
        if((strpos($dataArray[1], $_word) !== false)){
          $resultString .= sprintf('
          <li>%s: %s</li>
          ', $dataArray[0], $dataArray[1]);
        }
      }

      else if(empty($_word)){
        if((strpos($dataArray[0], $_fileName) !== false)){
          $resultString .= sprintf('
          <li>%s: %s</li>
          ', $dataArray[0], $dataArray[1]);
        }
      }
      else{
        if((strpos($dataArray[0], $_fileName) !== false) || (strpos($dataArray[1], $_word) !== false)){
          $resultString .= sprintf('
          <li>%s: %s</li>
          ', $dataArray[0], $dataArray[1]);
        }
      }
    }
    fclose($fp);
    return $resultString;
  }
}

?>

<!DOCTYPE>
<html>
<head>
  <title> 2019 웹 프로그래밍 중간고사 : 2번 </title>
  <meta charset="utf-8"/>
  <link rel="stylesheet" type="text/css" href="WP_midterm_2(2019).css">
</head>
<body id="aa">
  <form method="post" onsubmit="return check()" style="display: inline;">
    <label for="a1">화일 이름 : </label>
    <input type="text" name="a1" id="a1"><br><br>
    <label for="b1">단어 : </label>
    <input type="text" name="b1" id="b1"><br><br>
    <input formaction="DataSearch.php" type="submit" value="검색" id ="c1">
    <input formaction="FormSubmitAction.php" type="submit" id ="d1" value="새로운 데이타 추가하기">
  </form>
  <form method="post" action="AllDataShowAction.php" style="display: inline;">
    <input type="submit" id="e1" value="전체 데이타 보기">
  </form>
  <table id="bb">

    <?php
    echo DataSearch::show($fileName, $word);
    ?>

  </table>
  <script src="WP_midterm_2(2019).js"></script>
  <body>
    </html>
