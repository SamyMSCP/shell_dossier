</script>
<script type="text/javascript" charset="utf-8">

var savetimer = null;
var lastCodeData = {data: []};
var lastCodeData2 = {data:[]};
var lastCodeData3 = {data:[]};
var lastCodeData4 = {data:[]};

function testNumRue(mark) {
	var re = new RegExp(/^\s*([0-9]+)\s*(.{0,8})$/);
	var tmp = $(mark).val().match(re);
	var rt = [];
	if (tmp == null)
		return (null);
	return (rt);
}

function checkAdresse(code, commune, codeList)
{
	var codeVal = $('#' + code).val().trim();
	var communeVal = $('#' + commune).val().trim();
	if (typeof codeList.data[codeVal.toLowerCase()] != 'undefined')
	{
		$("#" + code).val(codeList.data[codeVal]["Code_postal"]);
		$("#" + commune).val(codeList.data[codeVal]["Nom_commune"].toLowerCase());
		checkStep2();
		<?php if (isset($this->Pp2)) { ?>
			checkStep3();
		<?php } ?>
		return (true);
	}
	else if (typeof codeList.data[communeVal.toLowerCase()] != 'undefined')
	{
		$("#" + code).val(codeList.data[communeVal]["Code_postal"]);
		$("#" + commune).val(codeList.data[communeVal]["Nom_commune"].toLowerCase());
		checkStep2();
		<?php if (isset($this->Pp2)) { ?>
			checkStep3();
		<?php } ?>
		return (true);
	}
	else if (typeof codeList.data[communeVal.toLowerCase()  + " - " + codeVal.toLowerCase()] != 'undefined')
	{
		$("#" + code).val(codeList.data[communeVal.toLowerCase()  + " - " + codeVal.toLowerCase()]["Code_postal"]);
		$("#" + commune).val(codeList.data[communeVal.toLowerCase()  + " - " + codeVal.toLowerCase()]["Nom_commune"].toLowerCase());
		checkStep2();
		<?php if (isset($this->Pp2)) { ?>
			checkStep3();
		<?php } ?>
		return (true);
	}
	return (false);
}

function getFromCodeCommune(code, commune, adresseList, codeList) {
	return (new Promise(function(resolve, reject) { 
		var codeVal = $('#' + code).val().trim();
		var communeVal = $('#' + commune).val().trim();
		if (code < 3)
			return (reject());
		if (savetimer != null)
			clearTimeout(savetimer);
		if (checkAdresse(code, commune, codeList))
			return (reject());
		savetimer = setTimeout(function() {
			$.ajax({
				method: "POST",
				url: "index.php?p=GetCodeVille",
				data: { 
					code: codeVal,
					commune: communeVal,
					token: "<?=$_SESSION['csrf'][0]?>"
				}
			}).done(function( msg ) {
				var datas = JSON.parse(msg);
				$('#' + adresseList).html('');
				codeList.data = [];
				for (key in datas)
				{
					if (key == "token")
						continue ;
					codeList.data[datas[key]['Nom_commune'].toLowerCase() + " - " + datas[key]['Code_postal']] = datas[key];
					$('#' + adresseList).append("<option value='" + datas[key]['Nom_commune'].toLowerCase() + " - " + datas[key]['Code_postal'] + "'/>");
				}
				savetimer = null;
				resolve();
			});
		}, 300);
	}));
}

$('#indicatif').change(function() {
	$("#indic_res").html("+" + $('#indicatif').val());
})

$('#nbr_enfant').on('keyup', function () {
	//if (Number($('#nbr_enfant').val()) == NaN)
		//console.log($('#nbr_enfant').val());
});

<?php
if (!isMobile())
{
	?>
	$("#date_naissance").datepicker({
		dateFormat: 'dd/mm/yy',
		maxDate: 'd',
		changeMonth: true,
		changeYear: true,
	});
	$("#date_naissanceConjoin").datepicker({
		dateFormat: 'dd/mm/yy',
		maxDate: 'd',
		changeMonth: true,
		changeYear: true,
	})
	<?php
}
?>

function checkNbrChild() {
	if ($('#enfant-0').prop("checked"))
	{
		$('.nbrChild input').prop("required", true);
		$('.nbrChild').show();
	}
	else
	{
		$('.nbrChild input').removeAttr("required");
		$('.nbrChild').hide();
	}
}

function checkNbrOther() {
	if ($('#autres_charge-0').prop("checked"))
	{
		$('.nbrAutres input').prop("required", true);
		$('.nbrAutres').show();
	}
	else
	{
		$('.nbrAutres input').removeAttr("required");
		$('.nbrAutres').hide();
	}
}
function checkNomJeuneFille () {
	if ($('#civilite').val() == "Monsieur")
	{
		$('.nomJeuneFille input').removeAttr("required");
		$('.nomJeuneFille').hide();
	}
	else
	{
		$('.nomJeuneFille input').prop("required", true);
		$('.nomJeuneFille').show();
	}
}

function checkNomJeuneFilleConjoin () {
	if ($('#civiliteConjoin').val() == "Monsieur")
	{
		$('.nomJeuneFilleConjoin input').removeAttr("required");
		$('.nomJeuneFilleConjoin').hide();
	}
	else
	{
		$('.nomJeuneFilleConjoin input').prop("required", true);
		$('.nomJeuneFilleConjoin').show();
	}
}

function checkRegMatri() {
	if($('#etat_civil').val() == "marie" || $('#etat_civil').val() == 'pacse')
		$('.regMatri').show();
	else
		$('.regMatri').hide();
}

$('#etat_civil').on("change", checkRegMatri);

$('.inputEnfant').on("change", checkNbrChild);
$('.inputOther').on("change", checkNbrOther);

$('#civilite').on("change", checkNomJeuneFille);
$('#civiliteConjoin').on("change", checkNomJeuneFilleConjoin);


checkNomJeuneFille();
checkNomJeuneFilleConjoin();
checkNbrChild();
checkNbrOther();
checkRegMatri();

</script>
<script type="text/javascript" charset="utf-8">

function checkGoToStep2() {
	var rt = true;
	if (
		!$("#enfant-0").prop("checked") &&
		!$("#enfant-1").prop("checked")
	)
	{
		rt = false;
	}
	if (
		!$("#autres_charge-0").prop("checked") &&
		!$("#autres_charge-1").prop("checked")
	)
	{
		rt = false;
	}
	
	if ($("#enfant-0").prop("checked") && (isNaN(parseInt($('#nbr_enfant').val())) || parseInt($('#nbr_enfant').val()) < 0))
	{
		$('#nbr_enfantValide').hide();
		rt = false;
	}
	else
	{
		$('#nbr_enfantValide').show();
	}
	if ($("#autres_charge-0").prop("checked") && (isNaN(parseInt($('#nbr_autres').val())) || parseInt($('#nbr_autres').val()) < 1))
	{
		$("#nbr_autres").parent().addClass('notValid');
		$('#nbr_autresValide').hide();
		rt = false;
	}
	else
	{
		$("#nbr_autres").parent().removeClass('notValid');
		$('#nbr_autresValide').show();
	}
	return (rt);
}

function checkGoToStep3() {

	<?php
	if (!isMobile())
	{
		?>
		var dtRegex = new RegExp(/\b\d{1,2}[/]\d{1,2}[/]\d{4}\b/);
		<?php
	}
	else
	{
		?>
		var dtRegex = new RegExp(/\b\d{4}[-]\d{1,2}[-]\d{1,2}\b/);
		<?php
	}
	?>
	var mailRegex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

	var rt = true;
	if ($('#civilite').val() != "Monsieur" && $('#civilite').val() != "Madame")
	{
		$("#civilite").addClass('notValid');
		$("#civiliteValide").hide();
		rt = false;
	}
	else
	{
		$("#civilite").removeClass('notValid');
		$("#civiliteValide").show();
	}

	if ($("#NomSJ").val().length < 2)
	{
		rt = false;
		$("#NomSJ").addClass('notValid');
		$("#nomValide").hide();
	}
	else
	{
		$("#NomSJ").removeClass('notValid');
		$("#nomValide").show();
	}

	if ($('#civilite').val() == "Madame" && $('#nom_jeune_fille').val().length < 2)
	{
		rt = false;
		$("#nom_jeune_fille").addClass('notValid');
		$("#nom_jeune_filleValide").hide();
	}
	else
	{
		$("#nom_jeune_fille").removeClass('notValid');
		$("#nom_jeune_filleValide").show();
	}
	if ($("#prenomSJ").val().length < 2)
	{
		rt = false;
		$("#prenomSJ").addClass('notValid');
		$("#prenomValide").hide();
	}
	else
	{
		$("#prenomSJ").removeClass('notValid');
		$("#prenomValide").show();
	}


	if ($("#status_pro").val() == 0)
	{
		rt = false;
		$("#status_pro").addClass('notValid');
		$("#status_proValide").hide();
		$(".for_cat_pro").hide();
		$(".for_profession").hide();
		$(".for_retraite").hide(); // Masquer retraite
		$(".for_contrat_travail").hide();
		$(".forTypeContrat").hide();
	}
	else if ($("#status_pro").val() == 1 || $("#status_pro").val() == 2 || $("#status_pro").val() == 3)
	{
		$(".for_retraite").show(); // Masquer retraite
		$("#depart_retraite").removeClass('notValid');
		$("#depart_retraiteValide").show();
		if ($("#status_pro").val() == 1)
		{
			$(".for_contrat_travail").show();
			if ($("#contrat_travail").val() == -1) // checker type contrat
			{
				rt = false;
				$("#contrat_travail").addClass('notValid');
				$("#contrat_travailValide").hide();
				$('.forTypeContrat').hide();
			}
			else if ($("#contrat_travail").val() == 0)
			{
				$('.forTypeContrat').show();
				$("#contrat_travail").removeClass('notValid');
				if ($("#autre_contrat_travail").val().length < 2)
				{
					rt = false;
					$("#autre_contrat_travail").addClass('notValid');
					$("#autre_contrat_travailValide").hide();
					$("#contrat_travailValide").hide();
				}
				else
				{
					$("#autre_contrat_travail").removeClass('notValid');
					$("#autre_contrat_travailValide").show();
					$("#contrat_travailValide").show();
				}
			}
			else
			{
				$('.forTypeContrat').hide();
				$('.forTypeContrat').hide();
				$("#contrat_travail").removeClass('notValid');
				$("#contrat_travailValide").show();
			}

		}
		else
		{
			$(".forTypeContrat").hide();
			$(".for_contrat_travail").hide();
		}

		$(".for_profession").show();
		if ($("#work").val().length < 2) // : Check profession (work)
		{
			rt = false;
			$("#work").addClass('notValid');
			$("#workValide").hide();
		}
		else
		{
			$("#work").removeClass('notValid');
			$("#workValide").show();
		}
		$("#status_pro").removeClass('notValid');
		$("#status_proValide").show();
		$(".for_cat_pro").show();

		
		if ($("#cat_pro").val() == 0) // Check cat pro
		{
			$("#cat_pro").addClass('notValid');
			$("#cat_proValide").hide();
			rt = false
		}
		else
		{
			$("#cat_pro").removeClass('notValid');
			$("#cat_proValide").show();
		}
		if (parseInt($("#depart_retraite").val()) < 9999 && parseInt($("#depart_retraite").val()) >= <?=date("Y")?>)
		{
			$("#depart_retraite").removeClass('notValid');
			$("#depart_retraiteValide").show();
		}
		else
		{
			rt = false;
			$("#depart_retraite").addClass('notValid');
			$("#depart_retraiteValide").hide();
		}
	}
	else if ($("#status_pro").val() == 4)
	{
		$("#status_pro").removeClass('notValid');
		$("#status_proValide").show();
		$(".for_cat_pro").hide();
		$(".for_profession").hide();
		$(".for_contrat_travail").hide();
		$(".forTypeContrat").hide();
		$(".for_retraite").hide();
	}
	else
		rt = false;

    $('.arrSelect').removeClass('arrSelectNotValid');
    $('.arrSelect:has(> select.notValid)').addClass('arrSelectNotValid');
	if ($("#Nationalite").val().length < 2)
	{
		rt = false;
		$("#Nationalite").addClass('notValid');
		$("#nationaliteValide").hide();
	}
	else
	{
		$("#Nationalite").removeClass('notValid');
		$("#nationaliteValide").show();
	}

	if (!dtRegex.test($("#date_naissance").val()))
	{
		rt = false;
		$("#date_naissance").addClass('notValid');
		$("#date_naissanceValide").hide();
	}
	else
	{
		$("#date_naissance").removeClass('notValid');
		$("#date_naissanceValide").show();
	}

	//if ($("#lieu_naissance").val().length < 2)
	if (typeof lastCodeData3.data[$("#lieu_naissance").val().toLowerCase()  + " - " + $("#codeNaissance").val().toLowerCase()] == 'undefined')
	{
		rt = false;
		$("#lieu_naissance").addClass('notValid');
		$("#codeNaissance").addClass('notValid');
		$("#lieu_naissanceValide").hide();
	}
	else
	{
		$("#lieu_naissance").removeClass('notValid');
		$("#codeNaissance").removeClass('notValid');
		$("#lieu_naissanceValide").show();
	}

	if ($("#pays_de_naissance").val().length < 2)
	{
		rt = false;
		$("#pays_de_naissance").addClass('notValid');
		$("#pays_de_naissanceValide").hide();
	}
	else
	{
		$("#pays_de_naissance").removeClass('notValid');
		$("#pays_de_naissanceValide").show();
	}

	var numValide = testNumRue('#numeroRue');
	if (numValide == null)
		$("#numeroRue").addClass('notValid');
	else
		$("#numeroRue").removeClass('notValid');

	if ($("#voie").val().length < 2)
		$("#voie").addClass('notValid');
	else
		$("#voie").removeClass('notValid');

	if (numValide == null ||
		$("#voie").val().length < 2)
	{
		$("#adresseValide").hide();
		rt = false;
	}
	else
		$("#adresseValide").show();

	
	if (typeof lastCodeData.data[$("#ville").val().toLowerCase()  + " - " + $("#codePostal").val().toLowerCase()] == 'undefined')
	{
		$("#codePostal").addClass('notValid');
		$("#ville").addClass('notValid');
		$("#codeValide").hide();
		rt = false;
	}
	else
	{
		$("#codePostal").removeClass('notValid');
		$("#ville").removeClass('notValid');
		$("#codeValide").show();
	}

	if ($("#pays").val().length < 2)
	{
		rt = false;
		$("#pays").addClass('notValid');
		$("#paysValide").hide();
	}
	else
	{
		$("#pays").removeClass('notValid');
		$("#paysValide").show();
	}

	<?php
	if ($this->Pp->id_phs != $this->dh->lien_phy)
	{
		?>
		if (!mailRegex.test($("#mailSJ").val()))
		{
			rt = false;
			$("#mailSJ").addClass('notValid');
			$("#mailValide").hide();
		}
		else
		{
			$("#mailSJ").removeClass('notValid');
			$("#mailValide").show();
		}
		<?php
	}
	?>
	///////////////////////// Check conditionnels

	<?php
	if ($this->Pp->id_phs != $this->dh->lien_phy)
	{
		?>
		if ($("#countries_phone2").val().length < 2)
		{
			$("#countries_phone2").addClass('notValid');
			$("#countries_phone2Valide").hide();
			rt = false;
		}
		else
		{
			$("#countries_phone2").removeClass('notValid');
			$("#countries_phone2Valide").show();
		}
		if ($("#countries_phone2").val() == "FR")
		{
			if ($("#num").val().length < 17)
			{
				$("#num").addClass('notValid');
				$("#numValide").hide();
				rt = false;
			}
			else
			{
				$("#num").removeClass('notValid');
				$("#numValide").show();
			}
		}
		else
		{
			if ($("#num").val().length < 10)
			{
				$("#num").addClass('notValid');
				$("#numValide").hide();
				rt = false;
			}
			else
			{
				$("#num").removeClass('notValid');
				$("#numValide").show();
			}
		}
		<?php
	}
	?>
	return (rt);
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

function checkStep1()
{
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

function checkStep2()
{
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

$('.block1 select, .block1 input').on("input", checkStep1);
$('.block1 select').on("change", checkStep1);
$('.block1 label').on("click", checkStep1);

$('.block2 input, .block2 select').on("keyup", checkStep2);
$('.block2 input, .block2 select').on("change", checkStep2);



$('.block1 .btn-next-step').on('click', function() {
	changeBlockSelection(2);
	$('.block1 .titleBlockSituation').css("background-color", "#20BF55");
});

$('.block2 .btn-next-step').on('click', function() {
	<?php
	if (isset($this->Pp2))
	{
		?>
		$('.block2 .titleBlockSituation').css("background-color", "#20BF55");
		changeBlockSelection(3);
		<?php
	}
	else
	{
		// on soummet le formulaire
		?>
		$("#tosendinfo").submit();
		$('.block2 .titleBlockSituation').css("background-color", "#20BF55");
		changeBlockSelection(3);
		<?php
	}
	?>
});


function checkConjoinHaveAddr() {
	if ($('#haveAddrConjoin-1Conjoin').prop("checked"))
		$(".forConjoinAddr").css("display", "flex");
	else
		$(".forConjoinAddr").css("display", "none");
}

$('#haveAddrConjoin-0Conjoin').on("click", checkConjoinHaveAddr);
$('#haveAddrConjoin-0Conjoin').on("change", checkConjoinHaveAddr);
$('#haveAddrConjoin-1Conjoin').on("click", checkConjoinHaveAddr);
$('#haveAddrConjoin-1Conjoin').on("change", checkConjoinHaveAddr);

checkConjoinHaveAddr();

	
</script>
<script type="text/javascript" charset="utf-8">

<?php
if (isset($this->Pp2))
{
	////// Code pour verifier les information du conjoint
	?>
	function checkGoToStep4() {
		var rt = true;
		<?php
		if (!isMobile())
		{
			?>
			var dtRegex = new RegExp(/\b\d{1,2}[/]\d{1,2}[/]\d{4}\b/);
			<?php
		}
		else
		{
			?>
			var dtRegex = new RegExp(/\b\d{4}[-]\d{1,2}[-]\d{1,2}\b/);
			<?php
		}
		?>
		var mailRegex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

		if ($('#civiliteConjoin').val() != "Monsieur" && $('#civiliteConjoin').val() != "Madame")
			rt = (false);

		if ($('#civiliteConjoin').val() == "Madame" && $('#nom_jeune_filleConjoin').val().length < 2)
		{
			rt = false;
			$("#nom_jeune_filleConjoin").addClass('notValid');
			$("#nom_jeune_filleConjoinValide").hide();
		}
		else
		{
			$("#nom_jeune_filleConjoin").removeClass('notValid');
			$("#nom_jeune_filleConjoinValide").show();
		}

		if ($("#NomConjoin").val().length < 2)
		{
			rt = (false);
			$('#NomConjoin').addClass('notValid');
			$('#NomConjoinValide').hide();
		}
		else
		{
			$("#NomConjoin").removeClass('notValid');
			$('#NomConjoinValide').show();
		}

		if ($('#civiliteConjoin').val() == "Madame" && $('#nom_jeune_filleConjoin').val().length < 2)
		{
			rt = (false);
		}
		if ($("#prenomConjoin").val().length < 2)
		{
			rt = (false);
			$('#prenomConjoin').addClass('notValid');
			$('#prenomConjoinValide').hide();
		}
		else
		{
			$("#prenomConjoin").removeClass('notValid');
			$('#prenomConjoinValide').show();
		}

/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
		if ($("#status_proConjoin").val() == 0)
		{
			rt = false;
			$("#status_proConjoin").addClass('notValid');
			$("#status_proConjoinValide").hide();
			$(".for_cat_proConjoin").hide();
			$(".for_professionConjoin").hide();
			$(".for_retraiteConjoin").hide();
			$(".for_contrat_travailConjoin").hide();
			$(".forTypeContratConjoin").hide();
		}
		else if ($("#status_proConjoin").val() == 1 || $("#status_proConjoin").val() == 2  || $("#status_proConjoin").val() == 3)
		{
			$(".for_retraiteConjoin").show();
			$("#depart_retraiteConjoin").removeClass('notValid');
			$("#depart_retraiteConjoinValide").show();
			if ($("#status_proConjoin").val() == 1)
			{
				$(".for_contrat_travailConjoin").show();
				$(".for_professionConjoin").show();
				if ($("#contrat_travailConjoin").val() == -1)
				{
					rt = false;
					$("#contrat_travailConjoin").addClass('notValid');
					$("#contrat_travailConjoinValide").hide();
					$('.forTypeContratConjoin').hide();
				}
				else if ($("#contrat_travailConjoin").val() == 0)
				{
					$('.forTypeContratConjoin').show();
					$("#contrat_travailConjoin").removeClass('notValid');
					if ($("#autre_contrat_travailConjoin").val().length < 2)
					{
						rt = false;
						$("#autre_contrat_travailConjoin").addClass('notValid');
						$("#autre_contrat_travailConjoinValide").hide();
						$("#contrat_travailConjoinValide").hide();
					}
					else
					{
						$("#autre_contrat_travailConjoin").removeClass('notValid');
						$("#autre_contrat_travailConjoinValide").show();
						$("#contrat_travailConjoinValide").show();
					}
				}
				else
				{
					$('.forTypeContratConjoin').hide();
					$('.forTypeContratConjoin').hide();
					$("#contrat_travailConjoin").removeClass('notValid');
					$("#contrat_travailConjoinValide").show();
				}

			}
			else
			{
				$(".forTypeContratConjoin").hide();
				$(".for_contrat_travailConjoin").hide();
			}
			$(".for_professionConjoin").show();
			if ($("#workConjoin").val().length < 2)
			{
				rt = false;
				$("#workConjoin").addClass('notValid');
				$("#workConjoinValide").hide();
			}
			else
			{
				$("#workConjoin").removeClass('notValid');
				$("#workConjoinValide").show();
			}
			$("#status_proConjoin").removeClass('notValid');
			$("#status_proConjoinValide").show();
			$(".for_cat_proConjoin").show();

			if ($("#cat_proConjoin").val() == 0)
			{
				$("#cat_proConjoin").addClass('notValid');
				$("#cat_proConjoinValide").hide();
				rt = false
			}
			else
			{
				$("#cat_proConjoin").removeClass('notValid');
				$("#cat_proConjoinValide").show();
			}
			if (parseInt($("#depart_retraiteConjoin").val()) < 9999 && parseInt($("#depart_retraiteConjoin").val()) >= <?=date("Y")?>)
			{
				$("#depart_retraiteConjoin").removeClass('notValid');
				$("#depart_retraiteConjoinValide").show();
			}
			else
			{
				rt = false;
				$("#depart_retraiteConjoin").addClass('notValid');
				$("#depart_retraiteConjoinValide").hide();
			}
		}
		else if ($("#status_proConjoin").val() == 4)
		{
			$("#status_proConjoin").removeClass('notValid');
			$("#status_proConjoinValide").show();
			$(".for_cat_proConjoin").hide();
			$(".for_professionConjoin").hide();
			$(".for_contrat_travailConjoin").hide();
			$(".forTypeContratConjoin").hide();
			$(".for_retraiteConjoin").hide();
		}
		else
			rt = false;
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////


        $('.arrSelect').removeClass('arrSelectNotValid');
        $('.arrSelect:has(> select.notValid)').addClass('arrSelectNotValid');
		if ($("#NationaliteConjoin").val().length < 2)
		{
			rt = (false);
			$('#NationaliteConjoin').addClass('notValid');
			$('#NationaliteConjoinValide').hide();
		}
		else
		{
			$("#NationaliteConjoin").removeClass('notValid');
			$('#NationaliteConjoinValide').show();
		}

		if (!dtRegex.test($("#date_naissanceConjoin").val()))
		{
			rt = (false);
			$('#date_naissanceConjoin').addClass('notValid');
			$('#date_naissanceConjoinValide').hide();
		}
		else
		{
			$("#date_naissanceConjoin").removeClass('notValid');
			$('#date_naissanceConjoinValide').show();
		}

		if (typeof lastCodeData4.data[$("#lieu_naissanceConjoin").val().toLowerCase()  + " - " + $("#codeNaissanceConjoin").val().toLowerCase()] == 'undefined')
		{
			rt = false;
			$("#lieu_naissanceConjoin").addClass('notValid');
			$("#codeNaissanceConjoin").addClass('notValid');
			$("#lieu_naissanceConjoinValide").hide();
		}
		else
		{
			$("#lieu_naissanceConjoin").removeClass('notValid');
			$("#codeNaissanceConjoin").removeClass('notValid');
			$("#lieu_naissanceConjoinValide").show();
		}

		/*
		if ($("#lieu_naissanceConjoin").val().length < 2)
		{
			rt = (false);
			$('#lieu_naissanceConjoin').addClass('notValid');
			$('#lieu_naissanceConjoinValide').hide();
		}
		else
		{
			$("#lieu_naissanceConjoin").removeClass('notValid');
			$('#lieu_naissanceConjoinValide').show();
		}
		*/

		if ($("#pays_de_naissanceConjoin").val().length < 2)
		{
			rt = (false);
			$('#pays_de_naissanceConjoin').addClass('notValid');
			$('#pays_de_naissanceConjoinValide').hide();
		}
		else
		{
			$("#pays_de_naissanceConjoin").removeClass('notValid');
			$('#pays_de_naissanceConjoinValide').show();
		}


		if ($('#haveAddrConjoin-1Conjoin').prop('checked'))
		{
			// Seulement si adrese differente
			var numValide = testNumRue('#numeroRueConjoin');
			//if (isNaN(parseInt($("#numeroRueConjoin").val())) || parseInt($("#numeroRueConjoin").val()) < 1 ||
			if (numValide == null ||
				$("#voieConjoin").val().length < 2)
			{
				rt = (false);
				$('#adresseConjoinValide').hide();
			}
			else
				$('#adresseConjoinValide').show();

			//if (isNaN(parseInt($("#numeroRueConjoin").val())) || parseInt($("#numeroRueConjoin").val()) < 1)
			if (numValide == null)
				$('#numeroRueConjoin').addClass('notValid');
			else
				$('#numeroRueConjoin').removeClass('notValid');
			if ($("#voieConjoin").val().length < 2)
				$('#voieConjoin').addClass('notValid');
			else
				$('#voieConjoin').removeClass('notValid');

			if (typeof lastCodeData2.data[$("#villeConjoin").val().toLowerCase()  + " - " + $("#codePostalConjoin").val().toLowerCase()] == 'undefined')
			{
				$("#codePostalConjoin").addClass('notValid');
				$("#villeConjoin").addClass('notValid');
				$("#codeConjoinValide").hide();
				rt = false;
			}
			else
			{
				$("#codePostalConjoin").removeClass('notValid');
				$("#villeConjoin").removeClass('notValid');
				$("#codeConjoinValide").show();
			}

/*
			if ($("#codePostalConjoin").val().length < 2 ||
				$("#villeConjoin").val().length < 2
			)
			{
				rt = (false);
				$('#codeConjoinValide').hide();
			}
			else
				$('#codeConjoinValide').show();
			if ($("#codePostalConjoin").val().length < 2)
				$('#codePostalConjoin').addClass('notValid');
			else
				$('#codePostalConjoin').removeClass('notValid');
			if ($("#villeConjoin").val().length < 2)
				$('#villeConjoin').addClass('notValid');
			else
				$('#villeConjoin').removeClass('notValid');

			if ($("#villeConjoin").val().length < 2)
			{
				rt = (false);
			}
*/

			if ($("#paysConjoin").val().length < 2)
			{
				rt = (false);
			}
		}

		///////////////////////// Check conditionnels

	if ($("#countries_phone2Conjoin").val().length < 2)
	{
		$("#countries_phone2Conjoin").addClass('notValid');
		$("#countries_phone2ConjoinValide").hide();
		rt = false;
	}
	else
	{
		$("#countries_phone2Conjoin").removeClass('notValid');
		$("#countries_phone2ConjoinValide").show();
	}
	if ($("#countries_phone2Conjoin").val() == "FR")
	{
		if ($("#numConjoin").val().length < 17)
		{
			$("#numConjoin").addClass('notValid');
			$("#numConjoinValide").hide();
			rt = false;
		}
		else
		{
			$("#numConjoin").removeClass('notValid');
			$("#numConjoinValide").show();
		}
	}
	else
	{
		if ($("#numConjoin").val().length < 10)
		{
			$("#numConjoin").addClass('notValid');
			$("#numConjoinValide").hide();
			rt = false;
		}
		else
		{
			$("#numConjoin").removeClass('notValid');
			$("#numConjoinValide").show();
		}
	}
	/*
		if ($("#countries_phone2Conjoin").val().length < 2)
		{
			rt = (false);
		}
		if ($("#numConjoin").val().length < 2)
		{
			rt = (false);
			$('#numConjoin').addClass('notValid');
			$('#numConjoinValide').hide();
		}
		else
		{
			$("#numConjoin").removeClass('notValid');
			$('#numConjoinValide').show();
		}
*/
		if (!mailRegex.test($("#mailConjoin").val()))
		{
			rt = (false);
			$('#mailConjoin').addClass('notValid');
			$('#mailConjoinValide').hide();
		}
		else
		{
			$("#mailConjoin").removeClass('notValid');
			$('#mailConjoinValide').show();
		}

		return (rt);
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
	$('.block3 input, .block3 select').on("keyup", checkStep3);
	$('.block3 input, .block3 select').on("change", checkStep3);

	$('.block3 .btn-next-step').on('click', function() {
		$("#tosendinfo").submit();
		changeBlockSelection(4);
		$('.block3 .titleBlockSituation').css("background-color", "#20BF55");
	});
	<?php
}
?>
	
</script>
<script type="text/javascript" charset="utf-8">

$( document ).ready(function() {
	checkStep1();
	getFromCodeCommune('codePostal', 'ville', 'adresseList', lastCodeData).then(
		function() {
			getFromCodeCommune('codeNaissance', 'lieu_naissance', 'adresseListNaissance', lastCodeData3).then(
				function() {
					<?php
					if (isset($this->Pp2))
					{
						////// Code pour verifier les information du conjoint
						?>
						getFromCodeCommune('codeNaissanceConjoin', 'lieu_naissanceConjoin', 'adresseListNaissance2', lastCodeData4).then(
							function() {
								getFromCodeCommune('codePostalConjoin', 'villeConjoin', 'adresseList2', lastCodeData2).then(
									function() {
										checkStep3();
									}
								).catch(
									function() {
										checkStep3();
									}
								);
								//checkStep3();
							}
						).catch(
							function() {
								checkStep3();
							}
						);
						<?php
					}
					?>
					checkStep2();
				}
			).catch(
				function () {
					checkStep2();
				}
			);
			//checkStep2();
		}
	).catch(
		function () {
			checkStep2();
		}
	);
});
