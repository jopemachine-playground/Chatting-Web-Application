var button = document.getElementById("press_button");

var result_BMI = document.getElementById("Result_BMI");
var final_Result = document.getElementById("Final_Result");

function click_handler(){

  var height_input = parseInt(document.getElementById("height_input").value) / 100;
  var weight_input = parseInt(document.getElementById("weight_input").value);

  var resultBMI = (weight_input/(height_input*height_input));

  result_BMI.innerHTML = Math.round(resultBMI);

  try {
    if(result_BMI.innerHTML < 18.5){
      final_Result.innerHTML = "underweight";
    }
    else if(result_BMI.innerHTML >= 18.5 && result_BMI.innerHTML < 23){
      final_Result.innerHTML = "normal";
    }
    else if(result_BMI.innerHTML >= 23 && result_BMI.innerHTML < 25){
      final_Result.innerHTML = "overweight";
    }
    else if(result_BMI.innerHTML >= 25 && result_BMI.innerHTML < 30){
      final_Result.innerHTML = "obesity";
    }
    else if(result_BMI.innerHTML >= 30){
      final_Result.innerHTML = "very overweight";
    }
  }
  catch(e){
    console.log(e);
  }
}
