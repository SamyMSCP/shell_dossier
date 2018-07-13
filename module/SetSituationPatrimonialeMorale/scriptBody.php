</script>
<script type="text/javascript" charset="utf-8">

var isOkay = false;


function changeBlockSelection(nBlock) {
	$('.blockSelected').removeClass('blockSelected');
	$('.block' + nBlock).addClass('blockSelected');
}

function checkGoToStep2() {
	return (true);
}

function checkGoToStep3() {
	var rt = true;
	$.each($('.block2 input'), (key, value) => {
		if ($(value).val() < 0)
		{
			$(value).addClass("haveError");
			rt = false;
		}
		else
		{
			$(value).removeClass("haveError");
		}
	});
	return (rt);
}

function checkGoToStep4() {
	return (true);
}

function checkStep1() {
	if (checkGoToStep2())
	{
		$(".block1 .btn-next-step").css("display", "flex");
		$(".block1 .btn-next-inactive").css("display", "none");
	}
	else
	{
		$(".block1 .btn-next-step").css("display", "none");
		$(".block1 .btn-next-inactive").css("display", "flex");
	}
}

function checkStep2() {
	if (checkGoToStep3())
	{
		$(".block2 .btn-next-step").css("display", "flex");
		$(".block2 .btn-next-inactive").css("display", "none");
	}
	else
	{
		$(".block2 .btn-next-step").css("display", "none");
		$(".block2 .btn-next-inactive").css("display", "flex");
	}
}


function checkStep3() {
	if (checkGoToStep4())
	{
		$(".block3 .btn-next-step").css("display", "flex");
		$(".block3 .btn-next-inactive").css("display", "none");
	}
	else
	{
		$(".block3 .btn-next-step").css("display", "none");
		$(".block3 .btn-next-inactive").css("display", "flex");
	}
}

$('.block1 input,.block1 select').on("keyup", checkStep1);
$('.block1 label').on("change", checkStep1);

$('.block2 input,.block2 select').on("keyup", checkStep2);
$('.block2 input').on("keyup", updateChart);
$('.block2 label').on("change", checkStep2);
$('.block3 input,.block3 select').on("keyup", checkStep2);
$('.block3 label').on("change", checkStep2);
checkStep1();
checkStep2();
checkStep3();

$('.block1 .btn-next-step').on('click', function() {
	changeBlockSelection(2);
	$('.block1 .titleBlockSituation').css("background-color", "#20BF55");
	showChart();
});

$('.block2 .btn-next-step').on('click', function() {
	changeBlockSelection(3);
	$('.block2 .titleBlockSituation').css("background-color", "#20BF55");
});

$('.block3 .btn-next-step').on('click', function() {
	if ($('#placement-2').prop("checked") && isOkay == false)
		$('.modalPrevention').modal('show');
	else
	{
		changeBlockSelection(4);
		$('.block3 .titleBlockSituation').css("background-color", "#20BF55");
		$('#tosendinfo').submit();
	}
});

$("#btnContinue").on("click", function() {
	isOkay = true;
	changeBlockSelection(4);
	$('.block3 .titleBlockSituation').css("background-color", "#20BF55");
	$("#tosendinfo").submit();
});
