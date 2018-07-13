</script>
<script type="text/javascript" charset="utf-8">

function init_BeneficiaireClient() {
	$('.newBeneficiaire').hide();
	$('.listBeneficiaire').show();
	$('.messageBeneficiaire').text("");
}

function showBeneficiaireList() {
	init_BeneficiaireClient();
}

function showBeneficiaireNewForm() {
	$('.messageBeneficiaire').text("");
	$('.newBeneficiaire').show();
	$('.listBeneficiaire').hide();
	redrawBeneficiaireNewForm();
}

function redrawBeneficiaireNewForm() {
	var type = $('.formTypeBeneficiaire');
	if (type.val() === "Pp")
	{
		$('.forPmBeneficiaire').hide();
		$('.forPpBeneficiaire').show();
		var type = $('.formBeneficiairePp');
		if (type.val() === "seul")
		{
			$('.forBeneficiaireSeule').show();
			$('.forBeneficiaireCouple').hide();
			var type = $('.formTypeBeneficiairePpSeul');
			if (type.val() === "new")
				$('.newPpSeul').show();
			else
				$('.newPpSeul').hide();
			$('.newPpCouple1').hide();
			$('.newPpCouple2').hide();
		}
		else if (type.val() === "couple")
		{
			$('.forBeneficiaireSeule').hide();
			$('.forBeneficiaireCouple').show();
			var type = $('.formTypeBeneficiairePpCouple1');
			if (type.val() === "new") {
				$('.newPpCouple1').show();
			}
			else
				$('.newPpCouple1').hide();
			var type = $('.formTypeBeneficiairePpCouple2');
			if (type.val() === "new")
				$('.newPpCouple2').show();
			else
				$('.newPpCouple2').hide();
			$('.newPpSeul').hide();
		}
	}
	else
	{
		$('.forPpBeneficiaire').hide();
		$('.forPmBeneficiaire').show();
		var type = $('.formBeneficiairePm');
		if (type.val() === "new")
		{
			$('.forBeneficiaireMoraleNew').show();
		}
		else
		{
			$('.forPmBeneficiaireNew').hide();
		}
	}
	//console.log("call");
}

function showInOnglet2(what) {
	$(".onglets2").hide();
	$(".onglets2Btn").removeClass('selected');
	$(".Btn" + what).addClass('selected');
	$(".Block" + what).show();
}
