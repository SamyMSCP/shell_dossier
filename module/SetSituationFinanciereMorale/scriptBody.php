</script>
<script type="text/javascript" charset="utf-8">

function changeBlockSelection(nBlock) {
	$('.blockSelected').removeClass('blockSelected');
	$('.block' + nBlock).addClass('blockSelected');

}

function checkGoToStep2() {
	var rt = true;
	$('.block1 input').each(function(key, value){
		let elm = $(value);
		if (elm.val().length <= 0)
		{

			elm.addClass("notValid");
			rt = false;
		}
		else
			elm.removeClass("notValid");
	});
	return (rt);
}

function checkGoToStep3() {
	var rt = true;
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





$('.block1 input,.block1 select').on("keyup", checkStep1);
$('.block1 label').on("change", checkStep1);

$('.block2 input,.block2 select').on("keyup", checkStep2);
$('.block2 label').on("change", checkStep2);
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

function setTotal() {
	var rt = 0;
	$('.block1 input').each(function (key, value) {
		if ($(value).prop('name') == 'nature_revenu_autres')
			return ;
		rt += Number($(value).val());
	});
	$('#totalTmp').text(rt);
}

$('.block1 input').on("keyup", setTotal);
setTotal();
