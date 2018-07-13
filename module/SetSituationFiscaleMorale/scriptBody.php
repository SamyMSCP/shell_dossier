</script>
<script type="text/javascript" charset="utf-8">


function changeBlockSelection(nBlock) {
	$('.blockSelected').removeClass('blockSelected');
	$('.block' + nBlock).addClass('blockSelected');

}

function checkGoToStep2() {
	var rt = true;
	if (
		!$('#regime_imposition-0').prop('checked') &&
		!$('#regime_imposition-1').prop('checked') &&
		!$('#regime_imposition-2').prop('checked') &&
		!$('#regime_imposition-3').prop('checked')
	)
		rt = false;
	if (
		$('#frottement_regime').val() <= 0 ||
		$('#frottement_regime').val() > 100
	)
	{
		$('#frottement_regime').addClass('notValid');
		$('#frottement_regimeValide').hide();
		rt = false;
	}
	else
	{
		$('#frottement_regime').removeClass('notValid');
		$('#frottement_regimeValide').show();
	}


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

$('.block1 input,.block1 select').on("keyup", checkStep1);
$('.block1 label').on("change", checkStep1);

checkStep1();

$('.block1 .btn-next-step').on('click', function() {
	changeBlockSelection(2);
	$('.block1 .titleBlockSituation').css("background-color", "#20BF55");
	$('#tosendinfo').submit();
});
