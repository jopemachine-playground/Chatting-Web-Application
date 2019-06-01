<?php

?>

<!DOCTYPE html>
<html lang="kr" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>HW02 List HomePage</title>
  <link rel="stylesheet" href="./css/List.css">
</head>
<body>
  <section>
    <button type="button" name="button" onclick="show(ListAddModalBox)">추가</button>
    <button type="button" name="button" onclick="show(ListSearchModalBox)">검색</button>
    <br><br>
    <table>
      <thead>
        <tr>
          <th id="family">가족</th>
          <th id="school">학교</th>
        </tr>
      </thead>

      <tbody>
        <tr>
          <td id="TodoList_family" ondragover="allowDrop(event)" ondrop="ItemDrop(event)"></td>
          <td id="TodoList_School" ondragover="allowDrop(event)" ondrop="ItemDrop(event)"></td>
        </tr>
      </tbody>

      <thead>
        <tr>
          <th id="travel">여행</th>
          <th id="exercise">운동</th>
        </tr>
      </thead>

      <tbody>
        <tr>
          <td id="TodoList_Travel" ondragover="allowDrop(event)" ondrop="ItemDrop(event)"></td>
          <td id="TodoList_Exercise" ondragover="allowDrop(event)" ondrop="ItemDrop(event)"></td>
        </tr>
      </tbody>

    </table>
  </section>

  <section>
    <p>검색 결과</p>
    <div id="searchResult">

    </div>
  </section>

  <!-- 할 일 추가 모달 박스 -->
  <div class="disappearing" id="ListAddModalBox">
    <p id="addModalBox_Title">할 일 추가</p>

    <form>

      <label for="class">할 일 분류:</label>
      <select id="class" name="class">
        <option value="family">가족</option>
        <option value="School">학교</option>
        <option value="Travel">여행</option>
        <option value="Exercise">운동</option>
      </select><br>

      <label for="memo">메모: </label>
      <input type="text" id="memo"><br>

      <label for="start_date">시작 날짜:</label>
      <input id="start_date" type="date" name="start_date"><br>
      <label for="end_date">끝나는 날짜:</label>
      <input id="end_date" type="date" name="end_date">

      <div>
        <button type="button" onclick="ListAdd()">Submit</button>
        <button type="button" onclick="hide(ListAddModalBox)">Cancel</button>
      </div>
    </form>
  </div>

  <!-- 할 일 검색 모달 박스 -->
  <div class="disappearing" id="ListSearchModalBox">
    <p id="addModalBox_Title">할 일 검색</p>

    <form>

      <label for="keyword">메모 키워드: </label>
      <input id="keyword" type="text" name="keyword"><br>

      <label for="search_start_date">시작 날짜:</label>
      <input id="search_start_date" type="date" name="search_start_date"><br>
      <label for="search_end_date">끝나는 날짜:</label>
      <input id="search_end_date" type="date" name="search_end_date"><br>

      <label for="sortCriteria">정렬 기준:</label>
      <select id="sortCriteria" name="sortCriteria">
        <option value="sortBy_keyword">메모 키워드</option>
        <option value="sortBy_startDate">시작 날짜</option>
        <option value="sortBy_endDate">끝나는 날짜</option>
      </select><br>

      <label for="sortOrder"></label>
      <input type="radio" name="sortOrder" value="descending" checked/>내림차순
      <input type="radio" name="sortOrder" value="ascending" />오름차순

      <div>
        <button type="button" onclick="searchList()">Submit</button>
        <button type="button" onclick="hide(ListSearchModalBox)">Cancel</button>
      </div>

    </form>
  </div>

  <script src="./js/List.js"></script>
  <script src="./lib/jquery.js"></script>
</body>
</html>
