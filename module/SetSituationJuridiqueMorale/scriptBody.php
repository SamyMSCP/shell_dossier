</script>
<script type="text/javascript" charset="utf-8">

$('#indicatif').change(function() {
	$("#indic_res").html("+" + $('#indicatif').val());
})


function checkGerant() {
	if ($('#representant').val() >= 0)
	{
		$('.qualite_de').css("display", "flex");
	}
	else
	{
		$('.qualite_de').css("display", "none");
	}
	if ($('#representant').val() == 0)
	{
		$('.representantInfos').css("display", "flex");
	}
	else
	{
		$('.representantInfos').css("display", "none");
	}
}
$('#representant').on("change", checkGerant);
checkGerant();

function checkGoToStep2() {
	var rt = true;


	if ($('#dn_sociale').val().length < 2)
	{
	rt = false;
		$("#dn_sociale").addClass('notValid');
		$("#dn_socialeValide").hide();
	}
	else
	{
		$("#dn_sociale").removeClass('notValid');
		$("#dn_socialeValide").show();
	}

	if ($('#f_juridique').val().length < 2)
	{
		rt = false;
		$("#f_juridique").addClass('notValid');
		$("#f_juridiqueValide").hide();
	}
	else
	{
		$("#f_juridique").removeClass('notValid');
		$("#f_juridiqueValide").show();
	}

	if ($('#siret').val().length < 9)
	{
		rt = false;
		$("#siret").addClass('notValid');
		$("#siretValide").hide();
	}
	else
	{
		$("#siret").removeClass('notValid');
		$("#siretValide").show();
	}

	if ($('#rcs').val().length < 2)
	{
		rt = false;
		$("#rcs").addClass('notValid');
		$("#rcsValide").hide();
	}
	else
	{
		$("#rcs").removeClass('notValid');
		$("#rcsValide").show();
	}

	if ($('#activite').val().length < 2)
	{
		rt = false;
		$("#activite").addClass('notValid');
		$("#activiteValide").hide();
	}
	else
	{
		$("#activite").removeClass('notValid');
		$("#activiteValide").show();
	}

	if ($('#siege_social').val().length < 2)
	{
		rt = false;
		$("#siege_social").addClass('notValid');
		$("#siege_socialValide").hide();
	}
	else
	{
		$("#siege_social").removeClass('notValid');
		$("#siege_socialValide").show();
	}


	if ($('#representant').val() == -1)
	{
	}
	else if ($('#representant').val() == 0)
	{
		if ($('#qualite_de').val().length < 2)
		{
			rt = false;
			$("#qualite_de").addClass('notValid');
			$("#qualite_deValide").hide();
		}
		else
		{
			$("#qualite_de").removeClass('notValid');
			$("#qualite_deValide").show();
		}
		if ($('#representantNom').val().length < 2)
		{
			rt = false;
			$("#representantNom").addClass('notValid');
			$("#representantNomValide").hide();
		}
		else
		{
			$("#representantNom").removeClass('notValid');
			$("#representantNomValide").show();
		}
		if ($('#representantPrenom').val().length < 2)
		{
			rt = false;
			$("#representantPrenom").addClass('notValid');
			$("#representantPrenomValide").hide();
		}
		else
		{
			$("#representantPrenom").removeClass('notValid');
			$("#representantPrenomValide").show();
		}
	}
	else if ($('#representant').val() > 0)
	{
		if ($('#qualite_de').val().length < 2)
		{
			rt = false;
			$("#qualite_de").addClass('notValid');
			$("#qualite_deValide").hide();
		}
		else
		{
			$("#qualite_de").removeClass('notValid');
			$("#qualite_deValide").show();
		}
	}
	return (rt);
}

function changeBlockSelection(nBlock) {
	$('.blockSelected').removeClass('blockSelected');
	$('.block' + nBlock).addClass('blockSelected');
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

$('.block1 input').on("keyup", checkStep1);
$('.block1 select').on("change", checkStep1);
$('.block1 label').on("click", checkStep1);

checkStep1();

$('.block1 .btn-next-step').on('click', function() {
	changeBlockSelection(2);
	$('.block1 .titleBlockSituation').css("background-color", "#20BF55");
	$('#tosendinfo').submit();
});
