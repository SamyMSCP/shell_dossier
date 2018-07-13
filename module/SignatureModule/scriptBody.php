</script>
<script type="text/javascript" charset="utf-8">

(function($) {
	$.fn.goTo = function() {
		$('html, body').animate({
			scrollTop: Number($(this).offset().top - 120) + 'px'
		}, 'slow');
		console.log($(this).offset().top);
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
		!$('#duree-0').prop("checked") &&
		!$('#duree-1').prop("checked")
	)
	{
		return (false);
	}
	return (true);
}

function checkGoToStep3() {
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





$('.block1 input').on("click", checkStep1);

checkStep1();
checkStep2();

$('.block1 .btn-next-step').on('click', function() {
	changeBlockSelection(2);
	$('.block1 .titleBlockSituation').css("background-color", "#20BF55");
});

$('.block2 .btn-next-step').on('click', function() {
	changeBlockSelection(3);
	$('.block2 .titleBlockSituation').css("background-color", "#20BF55");
	$('#tosendinfo').submit();
});


