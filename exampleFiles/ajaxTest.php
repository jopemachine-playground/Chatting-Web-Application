<?php
header("Content-Type: application/json");

function phptest(){
  return "console.log('짜잔!')";
}


?>

<!DOCTYPE html>
<html lang="kr" dir="ltr">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
  <input type="button" value="fetch API" onclick="ajaxMethod()">

  <button id="target" type="button" onclick="ajaxMethod()" name="button">나와랏</button>

  <p id="text"></p>
  <script>

  function test(){
    var t = document.getElementById("target").innerHTML;

    <?php
    echo phptest();
    ?>
  }

  function fetch1(){

    fetch('ajaxFile').then(function(response){
      response.text().then(function(text){
        alert(text);
      })
    })
  }

  function ajaxMethod(param){
    $.ajax({
      url: "ajaxTest.php",
      data: {message: "홍길동씨가 보낸 문자"},
      type: "POST",
      data: "json"
    })
    // HTTP 요청이 성공하면 요청한 데이터가 done() 메소드로 전달됨.

    .done(function(json) {

      $("<h1>").text(json.title).appendTo("body");

      $("<div class=\"content\">").html(json.html).appendTo("body");

    })

    // HTTP 요청이 실패하면 오류와 상태에 관한 정보가 fail() 메소드로 전달됨.

    .fail(function(xhr, status, errorThrown) {

      $("#text").html("오류가 발생했습니다.<br>")

      .append("오류명: " + errorThrown + "<br>")

      .append("상태: " + status);

    })

    // HTTP 요청이 성공하거나 실패하는 것에 상관없이 언제나 always() 메소드가 실행됨.

    .always(function(xhr, status) {

      $("#text").html("요청이 완료되었습니다!");

    });

  }



  </script>
  <!-- 제이쿼리 자바스크립트 추가하기 -->
  <script src="./lib/jquery-3.2.1.min.js"></script>
</body>
</html>
