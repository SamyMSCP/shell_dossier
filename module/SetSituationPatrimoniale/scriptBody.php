</script>
<script type="text/javascript" charset="utf-8">

var isOkay = false;

(function($) {
	$.fn.goTo = function() {
		$('html, body').animate({
			scrollTop: Number($(this).offset().top - 120) + 'px'
		}, 'slow');
		return this;
	}
})(jQuery);

function changeBlockSelection(nBlock)
{
	$('.blockSelected').removeClass('blockSelected');
	$('.block' + nBlock).addClass('blockSelected');
	$('.contentSituation').goTo();
}

function checkGoToStep2() {
	if (
		!$('#fourchette_montant_patrimoine-0').prop("checked") &&
		!$('#fourchette_montant_patrimoine-1').prop("checked") &&
		!$('#fourchette_montant_patrimoine-2').prop("checked") &&
		!$('#fourchette_montant_patrimoine-3').prop("checked") &&
		!$('#fourchette_montant_patrimoine-4').prop("checked")
	)
	{
		return (false);
	}
	return (true);
}

function checkGoToStep3() {
	var rt = true;
	$.each($('.block2 input'), function (key, value) {
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
	var rt = true;
	if (
		!$("#placement-0").prop("checked") &&
		!$("#placement-1").prop("checked") &&
		!$("#placement-2").prop("checked")
	)
		rt = false;
	return (rt);
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
$('.block3 input,.block3 select').on("keyup", checkStep3);
$('.block3 label').on("change", checkStep3);
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
	else if ($('#placement-1').prop("checked") && isOkay == false)
		$('.modalPrevention2').modal('show');
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


$("#btnContinue2").on("click", function() {
	isOkay = true;
	changeBlockSelection(4);
	$('.block3 .titleBlockSituation').css("background-color", "#20BF55");
	$("#tosendinfo").submit();
});
