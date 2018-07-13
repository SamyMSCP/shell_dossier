</script>
<script type="text/javascript" charset="utf-8">
function checkAutreMontant() {
	var rt = $('input:radio[name="residence_principale"]:checked').val();
	if (rt == 1)
	{
		$('.empPrinc').show();
		$('.empPrinc input').prop("required", true);
	}
	else
	{
		$('.empPrinc input').prop("required", false);
		$('.empPrinc input').val("1");
		$('.empPrinc').hide();
	}
}

function checkAutresRev() {
	if ($('#revenu_autres').val() > 0)
	{
		$('.natAutre').show();
		$('.natAutre input').prop("required", true);
	}
	else
	{
		$('.natAutre input').removeAttr("required");
		$('.natAutre').hide();
	}
}

var secondIsShow = false;

function checkHabitation() {
	$('.reinitializeTable').show();
	$('.empOther').show();
	$('.forCreditResidencePrincipale').hide();
	$('.forLoyerResidencePrincipale').hide();
	if ($('#habitation-0').prop("checked"))
	{
		$('#loyer_montant').val(0);
		$('.forCreditResidencePrincipale').show();
	}
	else if ($('#habitation-1').prop("checked"))
	{
		$('#remboursement_mensuel').val(0);
		$('#duree_remboursement_restantee').val(0);
		$('.forLoyerResidencePrincipale').show();
	}
	if (!secondIsShow)
	{
		showChart2();
		secondIsShow = true;
	}
	setTotal2();
}


$('.radioCol').on('click', checkHabitation);

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
	if ($('#revenu_autres').val() > 0 && $('.natAutre input').val().length < 2)
	{
		$('.natAutre input').addClass("tablehaveError");
		$('.natAutre .inputForm img').hide();
		return (false);
	}
		$('.natAutre input').removeClass("tablehaveError");
	$('.natAutre .inputForm img').show();
	return (true);
}

function checkForStep3(emit, recept)
{
	if ($('#' + emit).val() != 0 && $('#' + recept).val() == 0)
	{
		$('#' + recept).addClass("tablehaveError");
		return (false);
	}
	else
		$('#' + recept).removeClass("tablehaveError");
	if ($('#' + emit).val() == 0 && $('#' + recept).val() != 0)
	{
		$('#' + emit).addClass("tablehaveError");
		return (false);
	}
	else
		$('#' + emit).removeClass("tablehaveError");
	return (true);
}

function checkGoToStep3() {
	var rt = true;
	{
		if (
			!$('#habitation-0').prop("checked") &&
			!$('#habitation-1').prop("checked") &&
			!$('#habitation-2').prop("checked")
		)
			rt = false;
		if ($('#habitation-0').prop("checked") && !checkForStep3('remboursement_mensuel', 'duree_remboursement_restante'))
			rt = false;
		if ($('#habitation-1').prop("checked") && $('#loyer_montant').val() <= 0)
		{
			$('#loyer_montant').addClass("tablehaveError");
			rt = false;
		}
		else
			$('#loyer_montant').removeClass("tablehaveError");
		if (!checkForStep3('residance_montant', 'residance_duree'))
			rt = false;
		if (!checkForStep3('locatif_montant', 'locatif_duree'))
			rt = false;
		if (!checkForStep3('scpi_montant', 'scpi_duree'))
			rt = false;
		if (!checkForStep3('consommation_montant', 'consommation_duree'))
			rt = false;
		if (!checkForStep3('autres_remboursement_montant', 'autres_remboursement_duree'))
			rt = false;
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
$('.block1 input').on("keyup", updateChart1);
$('.block1 input').on("change", updateChart1);
showChart1();
$('.block1 label').on("change", checkStep1);

$('.block2 input,.block2 select').on("keyup", checkStep2);
$('.block2 label').on("change", checkStep2);
checkStep1();
checkStep2();

$('.block1 .btn-next-step').on('click', function() {
	changeBlockSelection(2);
	$('.block1 .titleBlockSituation').css("background-color", "#20BF55");
	checkHabitation();
});

$('.block2 .btn-next-step').on('click', function() {
	changeBlockSelection(3);
	$('.block2 .titleBlockSituation').css("background-color", "#20BF55");
	$('#tosendinfo').submit();
});



$(document).ready(function() {
	checkAutreMontant();
	checkAutresRev();
});

function setTotal() {
	//$('#revenu_professionnels').html($('#revenu_professionnels').val() * 12);
	var rt = 0;
	$('.block1 input').each(function (key, value) {
		if ($(value).prop('name') == 'nature_revenu_autres')
			return ;
		var annuel = "total_" + $(value).prop('name');
		var nbr = Intl.NumberFormat("fr-FR", {style: "currency", currency: "EUR"}).format($(value).val() * 12);
		$('#' + annuel).text(nbr);
		rt += Number($(value).val());
	});
	var nbr = Intl.NumberFormat("fr-FR", {style: "currency", currency: "EUR"}).format(rt * 12);
	$('#total_revenu_annuels').text(nbr);
	$('#totalTmp').text(rt);
}

function setTotal2() {
	updateChart2();
	var rt = 0;
	if ($('#habitation-0').prop("checked"))
	{
		rt += parseInt($('#remboursement_mensuel').val());
		parseInt($('#total_remboursement_mensuel').text(
			Intl.NumberFormat("fr-FR", {style: "currency", currency: "EUR"}).format($('#remboursement_mensuel').val() * 12)
		));
	}
	if ($('#habitation-1').prop("checked"))
	{
		rt += parseInt($('#loyer_montant').val());
		parseInt($('#total_loyer_montant').text(
			Intl.NumberFormat("fr-FR", {style: "currency", currency: "EUR"}).format($('#loyer_montant').val() * 12)
		));
	}

	rt += parseInt($('#residance_montant').val());
	parseInt($('#total_residance_montant').text(
		Intl.NumberFormat("fr-FR", {style: "currency", currency: "EUR"}).format($('#residance_montant').val() * 12)
	));

	rt += parseInt($('#locatif_montant').val());
	parseInt($('#total_locatif_montant').text(
		Intl.NumberFormat("fr-FR", {style: "currency", currency: "EUR"}).format($('#locatif_montant').val() * 12)
	));

	rt += parseInt($('#scpi_montant').val());
	parseInt($('#total_scpi_montant').text(
		Intl.NumberFormat("fr-FR", {style: "currency", currency: "EUR"}).format($('#scpi_montant').val() * 12)
	));

	rt += parseInt($('#consommation_montant').val());
	parseInt($('#total_consommation_montant').text(
		Intl.NumberFormat("fr-FR", {style: "currency", currency: "EUR"}).format($('#consommation_montant').val() * 12)
	));

	rt += parseInt($('#autres_remboursement_montant').val());
	parseInt($('#total_autres_remboursement_montant').text(
		Intl.NumberFormat("fr-FR", {style: "currency", currency: "EUR"}).format($('#autres_remboursement_montant').val() * 12)
	));

    rt += parseInt($('#autres_charges').val());
    parseInt($('#total_autres_charges').text(
        Intl.NumberFormat("fr-FR", {style: "currency", currency: "EUR"}).format($('#autres_charges').val() * 12)
    ));

	$('#totalTmp1').text(rt);
	parseInt($('#total_totalTmp1').text(
		Intl.NumberFormat("fr-FR", {style: "currency", currency: "EUR"}).format(rt * 12)
	));
	return (rt);
}

$('.block1 input').on("keyup", setTotal);
$('.block2 input').on("keyup", setTotal2);
setTotal();
setTotal2();


