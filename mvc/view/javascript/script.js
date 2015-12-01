function init_input() {
	$("#input_value").click(function() {
		$("#input_value").select();
	});
}

function showResult() {
	if ($("#output_value").val() != "") {
		$("#result").addClass("display");
	}	
}

function checkInversion() {
	$("#inversionBt").click(function() {
		var temp = $("#base_currency").val();
		$("#base_currency").val($("#target_currency").val());
		$("#target_currency").val(temp);
		$("#submit").click();	
	});
}

function addBootstrap() {
	$("input").addClass("form-control");
	$("select").addClass("form-control");
	$("button").addClass("form-control");	
}



$(document).ready(function () {
	//initialise input onclick
	init_input();
	//if there is an output, show #result div
	showResult();
	//inversion between base and target currency
	checkInversion();
	//add Bootstrap style to some elements
	addBootstrap();
});







