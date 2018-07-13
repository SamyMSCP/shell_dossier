</script>
<script type="text/javascript" charset="utf-8">

function checkResid() {
	var rt = $('input:radio[name="residence_france"]:checked').val();
	if (rt == 0)
	{
		$('.residDetails').show();
		$('.residDetails input').prop("required", true);
	}
	else
	{
		$('.residDetails input').prop("required", false);
		$('.residDetails').hide();
	}
}

function checkIR() {
	//irDetail
	var rt = $('input:radio[name="other_money"]:checked').val();
	if (rt == 1)
	{
		$('.irDetail').show();
		$('.irDetail input').prop("required", true);
	}
	else
	{
		$('.irDetail input').prop("required", false);
		$('.irDetail').hide();
	}
}

function checkISF() {
	//isfDetail
	var rt = $('input:radio[name="fortune"]:checked').val();
	if (rt == 1)
	{
		$('.isfDetail').show();
		$('.isfDetail input').prop("required", true);
	}
	else
	{
		$('.isfDetail input').prop("required", false);
		$('.isfDetail').hide();
	}
}



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

	if (!$('#residence_principale-0').prop('checked') &&
		!$('#residence_principale-1').prop('checked'))
	{
		return (false);
	}
	return (true);
}

function checkGoToStep3() {
	var rt = true;
	if (!$('#other_money-0').prop("checked") &&
		!$('#other_money-1').prop("checked"))
		rt = false;
	if ($('#other_money-0').prop("checked") && isNaN(parseFloat($('#impot_annee_precedente').val())) || $('#impot_annee_precedente').val() < 0)
	{
		$('#impot_annee_precedente').addClass('notValid');
		$('#impot_annee_precedenteValide').hide();
		rt = false;
	}
	else
	{
		$('#impot_annee_precedente').removeClass('notValid');
		$('#impot_annee_precedenteValide').show();
	}
	if ($('#other_money-0').prop("checked") && $('#nbr_fiscale').val() < 1)
	{
		$('#nbr_fiscale').addClass('notValid');
		$('#nbr_fiscaleValide').hide();
		rt = false;
	}
	else
	{
		$('#nbr_fiscale').removeClass('notValid');
		$('#nbr_fiscaleValide').show();
	}
	return (rt);
}

function checkGoToStep4() {
	rt = true;
	if (!$('#fortune-0').prop("checked") &&
		!$('#fortune-1').prop("checked"))
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
$('.block2 label').on("change", checkStep2);
$('.block3 input,.block3 select').on("keyup", checkStep3);
$('.block3 label').on("change", checkStep3);
checkStep1();
checkStep2();
checkStep3();

$('.block1 .btn-next-step').on('click', function() {
	changeBlockSelection(2);
	$('.block1 .titleBlockSituation').css("background-color", "#20BF55");
});

$('.block2 .btn-next-step').on('click', function() {
	changeBlockSelection(3);
	$('.block2 .titleBlockSituation').css("background-color", "#20BF55");
});

$('.block3 .btn-next-step').on('click', function() {
	changeBlockSelection(4);
	$('.block3 .titleBlockSituation').css("background-color", "#20BF55");
	$('#tosendinfo').submit();
});










$(document).ready(function() {
	checkResid();
	checkIR();
	checkISF();
});
