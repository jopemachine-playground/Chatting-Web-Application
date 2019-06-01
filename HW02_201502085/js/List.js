var ListAddModalBox = document.getElementById('ListAddModalBox');
var ListSearchModalBox = document.getElementById('ListSearchModalBox');

// Add Modal box의 Input 엘리먼트들
var AddModalBox_class = document.getElementById('class');
var AddModalBox_memo = document.getElementById('memo');
var AddModalBox_start_date = document.getElementById('start_date');
var AddModalBox_end_date = document.getElementById('end_date');

// td 태그들
var TodoList_family = document.getElementById('TodoList_family');
var TodoList_School = document.getElementById('TodoList_School');
var TodoList_Travel = document.getElementById('TodoList_Travel');
var TodoList_Exercise = document.getElementById('TodoList_Exercise');

window.onload = function(){
  FecthAllList();
}

function show(object){
  object.setAttribute('class', '');
}

function hide(object){
  object.setAttribute('class', 'disappearing');
}

function ListAdd(){

  if($('#memo').val() == ''){
    alert('할 일을 입력해주세요!');
    return;
  }

  $.ajax({
    type: "POST",
    url : "purePHP/ListAddAction.php",
    data: {
      class : AddModalBox_class.value,
      memo : AddModalBox_memo.value,
      start_date : AddModalBox_start_date.value,
      end_date : AddModalBox_end_date.value,
      // 인덱스가 0에서 시작하므로 1을 더하지 않고 그대로 전송하는게 맞다.
      index : $('#TodoList_' + AddModalBox_class.value).children().length
    },

    success : function(response) {
      console.log(response);
      let response_data = JSON.parse(response);
      console.log(response_data);
      FetchList(AddModalBox_class.value, response_data[AddModalBox_class.value]);
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log("Ajax 전송에 실패했습니다!" + jqXHR.responseText);
    }
  });

  hide(ListAddModalBox);
}


function FetchList(key, value){
  $('#TodoList_' + key).append(value);
}

function FecthAllList(){
  $.ajax({
    type: "POST",
    url : "purePHP/ListFetchAction.php",

    success : function(response) {
      console.log(response);
      let response_data = JSON.parse(response);
      // 아래 반복문은 4번 실행됨
      for(let i = 0; i< 4; i++){
        let key = Object.keys(response_data)[i];
        FetchList(key, response_data[key]);
      }
    },

    error: function(jqXHR, textStatus, errorThrown) {
      console.log("Ajax 전송에 실패했습니다!" + jqXHR.responseText);
    }
  });
}

function DeleteItem(id){

  let indexWithClass = id.split('-');

  let index = indexWithClass[1];
  let classString = indexWithClass[0];

  console.log(index);
  console.log(classString);

  $.ajax({
    type: "POST",
    url : "purePHP/ListDeleteAction.php",
    data: {
      classString : classString,
      index : index
    },

    success : function(response) {
      console.log(response);
      $('#' + classString + '-' + index).remove();
      indexUpdate(classString);
    },

    error: function(jqXHR, textStatus, errorThrown) {
      console.log("Ajax 전송에 실패했습니다!" + jqXHR.responseText);
    }
  });

}

function indexUpdate(classString){

  let object = $('#TodoList_' + classString);

  for (let i = 0; i< object.children().length; i++){
    object.children().eq(i).attr('id', classString + '-' + i);
  }
}


function allowDrop(ev){
  ev.preventDefault();
}

async function ItemDrop(ev){

  ev.preventDefault();
  // 제이쿼리를 사용해 이벤트 전파 버그를 막아보자
  ev.stopPropagation();
  let data = ev.dataTransfer.getData("text");

  let prev_classString = data.split('-')[0];
  let prev_Index = data.split('-')[1];
  let after_classString = ev.target.id.split('_')[1];

  // 출발지와 목적지가 같으면 아무 처리도 하지 않음. (할 필요 없음)
  if(prev_classString == after_classString){
    return;
  }

  // 서버 파일의 인덱스 업데이트.
  await ServerFileIndexUpdate(prev_classString, after_classString, prev_Index);

  // 엘리먼트를 옮김
  ev.target.appendChild(document.getElementById(data));

  // 드래그가 시작된 곳과 끝난 곳의 클라이언트 인덱스를 업데이트
  indexUpdate(prev_classString);
  indexUpdate(after_classString);

}

function startDrag(ev){
  ev.dataTransfer.setData("text", ev.target.id);
}

function ServerFileIndexUpdate(prev_classString, after_classString, prev_Index){
  console.log(prev_classString);
  console.log(after_classString);

  let object = $('#TodoList_' + prev_classString).find('#' + prev_classString + '-' + prev_Index);

  let withoutSpan = (object.html()).split('&')[0];

  // 문자열 파싱
  let message = withoutSpan.split('(')[0];
  let start_date = '';
  let end_date = '';

  if(withoutSpan.split('(')[1] !== undefined){
    start_date = (withoutSpan.split('(')[1]).split('~')[0];
    end_date = ((withoutSpan.split('(')[1]).split('~')[1]).split(')')[0];
  }

  $.ajax({
    type: "POST",
    url : "purePHP/ListChangeAction.php",
    data: {
      prev_classString : prev_classString,
      after_classString : after_classString,
      prev_Index: prev_Index,
      memo : message,
      start_date : start_date,
      end_date : end_date,
      // 인덱스가 0에서 시작하므로 1을 더하지 않고 그대로 전송하는게 맞다.
      index : $('#TodoList_' + after_classString).children().length
    },

    success : function(response) {
      console.log(response);
    },

    error: function(jqXHR, textStatus, errorThrown) {
      console.log("Ajax 전송에 실패했습니다!" + jqXHR.responseText);
    }
  });
}

function searchList(){

  $.ajax({
    type: "POST",
    url : "purePHP/ListSearchAction.php",
    data: {
      Keyword: $('#keyword').val(),
      Start_date: $('#search_start_date').val(),
      End_date: $('#search_end_date').val(),
      SortCriteria: $('#sortCriteria').val(),
      SortOrder: $("input[name='sortOrder']:checked").val()
    },

    success : function(response) {
      let response_data = JSON.parse(response);
      makeSearchList(response_data);
    },

    error: function(jqXHR, textStatus, errorThrown) {
      console.log("Ajax 전송에 실패했습니다!" + jqXHR.responseText);
    }
  });
}

function makeSearchList(response){

  let buffer = '';
  for(let index = 0; index < response.length; index++){
    console.log(response[index]);
    let one_dataArray = response[index].split('|');
    buffer += '<li>' + one_dataArray[0] + ' ( ' + one_dataArray[1] + ' ~ '+  one_dataArray[2] + ' )</li>';
  }
  $('#searchResult').html(buffer);
}
