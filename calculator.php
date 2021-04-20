<?php
require_once dirname(__FILE__).'/connect.php';
# подключаем файл connect.php

session_start();
# начинаем сессия для того что бы запомнить залогинился пользователь или нет
# иначе просьба войти на сайт будет появлятся после обновления страницы
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Школьный сайт по алгебре. Курсовая Э.Ниязов</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
	<?php include 'header.php'; ?>
	

	<script type="text/javascript" src="libs/math.js"></script>
	<div class="wrapper">
 		<!-- блок слева -->
 		<?php include 'wrapper_left_block.php'; ?>
		<div id="wrapper_right_block">
			<div id="calculators_handler">
				
				<div class="btn_container">
					<button class="tab_button" id="normal_calc" onclick="changeTab(CALC_TAB.NORMAL)">Обычный калькулятор</button> 
					<button class="tab_button" id="proizv_calc" onclick="changeTab(CALC_TAB.DERIVATIVE)">Калькулятор производной функции</button><br><br><br>
				</div>
				<div id="normal_calculator">
					<div class="normal_calculator__container">
						<input type="text" id="calc_first_num" value="1000" />
						<span id="calc_symbol">+</span>
						<input type="text" id="calc_second_num" value="1000" />
					
						<span id="answer_label"> =  ? </span>
					
					</div>
				

					<button class="calculator_button" onclick = "normalCalculate(CALC_ACTION.PLUS)">+</button>
					<button class="calculator_button" onclick = "normalCalculate(CALC_ACTION.MINUS)">-</button>
					<button class="calculator_button" onclick = "normalCalculate(CALC_ACTION.MULTIPLY)">×</button>
					<button class="calculator_button" onclick = "normalCalculate(CALC_ACTION.DIVISION)">÷</button>
				</div>

				<div id="derivative_calculator" style="display: none;">
					
						<span><b>F(x)</b> = </span> <input type="text" id="calc_der_f" value="x^2" /> <span>Примеры: sin(2x) | 2*x | x^2</span><br><br>
						<span>Дифф. переменная : </span> <input type="text" id="calc_der_x" value="x" style="width: 30px;" /><br><br>
						
						<input type="checkbox" id="checkbox_d_evaluate"/> <span>Выразить численно</span>
						<input type="checkbox" id="checkbox_d_simplify" checked/> <span>Упростить</span>

						<button class="calculator_button_proizv" onclick = "calculateDerivative()">Решить</button>

					
						<h2 id="answer_d_label" style="margin-left: 20px;"> Ответ: ?</h2>
					
				</div>
				
			</div>
		</div>
	</div>
	<script type="text/javascript">
		const CALC_TAB = {
			NORMAL : 1,
			DERIVATIVE : 2
		}

		const CALC_ACTION = {
			PLUS : 1,
			MINUS : 2,
			MULTIPLY : 3,
			DIVISION : 4
		}

		// меняет вкладку с калькулятом
		function changeTab(calcTab) {
			let curTab = calcTab;

			let normalCalculatorDiv = document.getElementById("normal_calculator");
			let derivativeCalculatorDiv = document.getElementById("derivative_calculator");
			let styleButton = document.getElementById("normal_calc");
			let styleButtonTwo = document.getElementById("proizv_calc");

			// обычный калькулятор
			if (curTab == CALC_TAB.NORMAL) {
				normalCalculatorDiv.style.display = "block";
				derivativeCalculatorDiv.style.display = "none";
				styleButton.classList.add("active_calc");
				styleButtonTwo.classList.remove("active_calc");
			// калькулятор производной
			} else if (curTab == CALC_TAB.DERIVATIVE) {
				normalCalculatorDiv.style.display = "none";
				derivativeCalculatorDiv.style.display = "block";
				styleButtonTwo.classList.add("active_calc");
				styleButton.classList.remove("active_calc");
				
			} else {
				return;
			}
		}

		// считает обычные математические действия
		function normalCalculate(calcAction) {
			let curAction = calcAction;
			let curActionSymbol = "?";

			let num1 = Number(document.getElementById("calc_first_num").value);
			let num2 = Number(document.getElementById("calc_second_num").value);
			let calcSymbolEl = document.getElementById("calc_symbol");
			let answerEl = document.getElementById("answer_label");

			let answer = 0;

			if (curAction == CALC_ACTION.PLUS) {
				answer = num1 + num2;
				curActionSymbol = "+";
			} else if (curAction == CALC_ACTION.MINUS) {
				answer = num1 - num2;
				curActionSymbol = "-";
			} else if (curAction == CALC_ACTION.MULTIPLY) {
				answer = num1 * num2;
				curActionSymbol = "×";
			} else if (curAction == CALC_ACTION.DIVISION) {
				// проверяем деление на ноль
				if (num2 == 0) {
					alert("Делить на ноль нельзя!");
					return;
				} else {
					answer = num1 / num2;
					curActionSymbol = "÷";
				}
			} else {
				return;
			}

			calcSymbolEl.innerHTML = curActionSymbol;
			answerEl.innerHTML = " =  " +  String(answer);
		}

		// ищет значение производной
		function calculateDerivative() {
			let derF = document.getElementById('calc_der_f').value;
			let derX = document.getElementById('calc_der_x').value;

			// проверяем чекбоксы с доп. условиями
			let isNeedEvaluate = document.getElementById('checkbox_d_evaluate').checked;
			let isNeedSimplify = document.getElementById('checkbox_d_simplify').checked;

			let result = "";
			
			if (isNeedEvaluate) {
				derX = Number(derX);
				// если введено не число выводим ошибку и остнавливаем функцию
				if (isNaN(parseFloat(derX))) {
					alert("Введите число в поле для переменной!");
					return;
				}
				console.log(derX);
				result = math.derivative(derF, 'x', {simplify: isNeedSimplify}).evaluate({x: derX});
				
			} else {
				result = math.derivative(derF, derX, {simplify: isNeedSimplify});
			}

			// выводим ответ
			document.getElementById("answer_d_label").innerHTML = " Ответ: " + String(result);
		}

	</script>
	
</body
</html>