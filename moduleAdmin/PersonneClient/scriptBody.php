</script>
<script type="text/javascript" charset="utf-8">

var documentPp = <?=json_encode($this->RequiredDocumentPp, JSON_FORCE_OBJECT)?>;

var dataPp = {
	<?php
	$first = true;
	foreach ($this->Pp as $key => $elm) {
		if (!$first)
			echo ",
			";
		?>
		"<?=$elm->id_phs?>":{
			"civilite":"<?=$elm->getCivilite()?>",
			"civiliteFormat":"<?=$elm->getCiviliteFormat()?>",
			"prenom":"<?=$elm->getFirstName()?>",
			"nom":"<?=$elm->getName()?>",
			"indicatif_telephonique":"<?=$elm->getIndicatifPhone()?>",
			"telephone":"<?=$elm->getPhone()?>",
			"mail":"<?=$elm->getMail()?>",
			"date_naissance":"<?=$elm->getDateNaissance()->format("Y-m-d")?>",
			"lieu_naissance":"<?=$elm->getLieuNaissance()?>",
			"etat_civil":"<?=$elm->getEtatCivil()?>",
			"adresse":"<?=$elm->getAdresse()?>",
			"nationalite":"<?=$elm->getNationalite()?>",

			"files":{
				<?php
				$first2 = true;
				foreach ($this->RequiredDocumentPp as $key1 => $elm1)
				{
					if (!$first2)
						echo ",
";
					?>
"<?=$elm1->id?>":{
					<?php
					$first3 = true;
					foreach ($elm->getDocuments($elm1->id) as $key2 => $elm2)
					{
						if (!$first3)
							echo ", ";
						?>
						"<?=$elm2->id?>":{
							"filename":"<?=$elm2->getFilename()?>",
							"dateExecution":"<?=$elm2->getDateExecution()->format("d/m/Y")?>",
							"dateCreation":"<?=$elm2->getDateCreation()->format("d/m/Y")?>",
							"link":"?p=DownloadDocument&idDocument=<?=$elm2->id?>",
							"id":"<?=$elm2->id?>"
						}
						<?php
						$first3 = false;
					}
					?>}<?php
					$first2 = false;
				}
				?>
			}

		}<?php
		$first = false;
	}
	?>
};

var dataPm = {
	<?php
	$first = true;
	foreach ($this->Pm as $key => $elm) {
		if (!$first)
			echo ",
			";
		?>
		"<?=$elm->id_pm?>":{
			"social":"<?=$elm->getDenominationSociale()?>",
			"date_immatri":"<?=date('Y-m-d', intval($elm->getDateimmatriculation()))?>",
			"rcs":"<?=$elm->getRcs()?>",
			"djuridique":"<?=$elm->getFormeJuridique()?>",
			"siret":"<?=$elm->getSiret()?>",
		}<?php
		$first = false;
	}
	?>
};

var isPpLocked = true;
/*
function showPersonnePhysiqueNewForm() {
	$('.personnesClient').children().hide();
	$('.personnesClientDetail').show();
}
*/

function showPersonnePhysiqueNewForm() {
	$('.messagePp').text("");
	$('.formPhysique input').val('');
	$('.formMorale input').val('');
	$('.personnesClient').children().hide();
	$('.formPhysique').show();
	$('.formPhysique .submitPersonnePhysique').val('Ajouter une personne physique');
	$('.formPhysique .idClient').val('<?=$GLOBALS['GET']['client']?>');
	$('.formPhysique .civilitePp').val('Monsieur');
	$('.formPhysique .indicatifTelephoniquePp').val('FR');
	$('.formPhysique .tokenCsrfPp').val('<?=$_SESSION['csrf'][0]?>');

	$('.formPhysique .BtnSubmit').show();
	$('.formPhysique .Locker').hide();

	$('.formPhysique :input').prop("disabled", false);
	$('.formPhysique td').removeClass("inLocked");
	$('.formPhysique .closed').show();
	$('.formPhysique .open').hide();
	isPpLocked = false;
}

function showPersonneMoraleNewForm() {
	$('.personnesClient').children().hide();
	$('.formMorale input').val('');
	$('.formMorale input').val('');
	
	$('.date_immatri').val("<?=date("Y-m-d")?>");
	$('.formMorale :input').prop("disabled", false);
	$('.formMorale .tokenCsrfPm').val('<?=$_SESSION['csrf'][0]?>');
	$('.formMorale .idClient').val('<?=$GLOBALS['GET']['client']?>');
	$('.formMorale .submitPersonneMorale').val('Ajouter une personne morale');
	$('.formMorale .BtnSubmit').show();
	$('.formMorale .Locker').hide();
	
	$('.formMorale td').removeClass("inLocked");
	$('.formMorale .closed').show();
	$('.formMorale .open').hide();
	$('.formMorale').show();
	isPpLocked = false;
}

function showPersonneTable() {
	$('.personnesClient').children().hide();
	$('.personnesClientTable').show();
}

function init_PersonneClient() {
	$('.personnesClient').children().hide();
	$('.personnesClientTable').show();
	$('.messagePp').text("");
}


function showPpDocument(idPp) {
	for (doc in documentPp)
	{
		console.log();
		var cible = $(".filesPp" + documentPp[doc].id);
		cible.empty();
		for (elm in dataPp[idPp]["files"][documentPp[doc]["id"]])
		{
			var li = $('<li>');
			li.html("<a href='?p=DownloadDocument&idDocument=" + dataPp[idPp]["files"][documentPp[doc]["id"]][elm]["id"] + "&token=sdafl' target='_blank'>" + dataPp[idPp]["files"][documentPp[doc]["id"]][elm]["dateExecution"] + "</a>");
			cible.append(li);
		}
	}
}

function showPersonneMoraleUpdateForm(idPm) {
	$('.messagePp').text("");
	$('.formMorale input').val('');
	$('.personnesClient').children().hide();
	$('.formMorale').show();
	$('.formMorale .idClient').val(idPm);
	$('.formMorale .idPersonnePhysique').val(idPm);

	$('.formMorale :input').prop("disabled", true);
	$('.formMorale .social').val(dataPm[idPm].social);
	$('.formMorale .date_immatri').val(dataPm[idPm].date_immatri);
	$('.formMorale .rcs').val(dataPm[idPm].rcs);
	$('.formMorale .juridique').val(dataPm[idPm].djuridique);
	$('.formMorale .siret').val(dataPm[idPm].siret);
	$('.formMorale .submitPersonneMorale').val('Modifier cette personne morale');
	$('.formMorale .tokenCsrfPm').val('<?=$_SESSION['csrf'][0]?>');

	$('.formMorale .BtnSubmit').hide();
	$('.formMorale .Locker').show();
	console.log("here");
	isPpLocked = true;
	$('.formMorale td').attr("disabled", true);
	$('.formMorale td').addClass("inLocked");
	$('.formMorale .closed').show();
	$('.formMorale .open').hide();
}

function showPersonnePhysiqueUpdateForm(idPp) {
	$('.messagePp').text("");
	$('.formPhysique input').val('');
	$('.personnesClient').children().hide();
	$('.formPhysique').show();
	$('.formPhysique .idClient').val('<?=$GLOBALS['GET']['client']?>');
	$('.formPhysique .idPersonnePhysique').val(idPp);


	$('.formPhysique :input').prop("disabled", true);
	$('.formPhysique .civilitePp').val(dataPp[idPp].civilite);
	$('.formPhysique .prenomPp').val(dataPp[idPp].prenom);
	$('.formPhysique .nomPp').val(dataPp[idPp].nom);
	$('.formPhysique .indicatifTelephoniquePp').val(dataPp[idPp].indicatif_telephonique);
	$('.formPhysique .telephonePp').val(dataPp[idPp].telephone);
	$('.formPhysique .mailPp').val(dataPp[idPp].mail);
	$('.formPhysique .dateNaissancePp').val(dataPp[idPp].date_naissance);
	$('.formPhysique .lieuNaissancePp').val(dataPp[idPp].lieu_naissance);
	$('.formPhysique .etatCivilPp').val(dataPp[idPp].etat_civil);
	$('.formPhysique .nationalitePp').val(dataPp[idPp].nationalite);
	$('.formPhysique .adressePp').val(dataPp[idPp].adresse);
	$('.formPhysique .submitPersonnePhysique').val('Modifier cette personne physique');
	$('.formPhysique .tokenCsrfPp').val('<?=$_SESSION['csrf'][0]?>');

	$('.formPhysique .BtnSubmit').hide();
	$('.formPhysique .Locker').show();
	isPpLocked = true;
	$('.formPhysique td').attr("disabled", true);
	$('.formPhysique td').addClass("inLocked");
	$('.formPhysique .closed').show();
	$('.formPhysique .open').hide();
	showPpDocument(idPp);
}

function enabledPersonneMoralModification() {
	$('.formMorale :input').prop("disabled", false);
	$('.formMorale td').removeClass("inLocked");
	$('.formMorale .closed').hide();
	$('.formMorale .open').show();
	$('.formMorale .BtnSubmit').show();
	$('.formMorale .Locker').hide();
	isPpLocked = false;

}
function enabledPersonnePhysiqueModification() {
	$('.formPhysique :input').prop("disabled", false);
	$('.formPhysique td').removeClass("inLocked");
	$('.formPhysique .closed').hide();
	$('.formPhysique .open').show();
	$('.formPhysique .BtnSubmit').show();
	$('.formPhysique .Locker').hide();
	isPpLocked = false;

}

$('.mailPp').change(function(){
	if (!$('.mailPp').val().match(/(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/)){
		$('.mailPp').addClass("notOkay");
	}
	else{
		$('.mailPp').removeClass("notOkay");
	}
})

$('.nomPp').change(function(){
	if (!$('.nomPp').val().match(/^([A-Za-z '-éèëêâä]+)$/))
	{
		$('.nomPp').addClass("notOkay");
	}
	else
	{
		$('.nomPp').removeClass("notOkay");
	}
});

$('.prenomPp').change(function(){
	if (!$('.prenomPp').val().match(/^([A-Za-z '-éèëêâä]+)$/))
	{
		$('.prenomPp').addClass("notOkay");
	}
	else
	{
		$('.prenomPp').removeClass("notOkay");
	}
});

$('.telephonePp').change(function(){
	if (!$('.telephonePp').val().match(/^[0-9 +]+$/) || $('.telephonePp').val().length < 9)
	{
		$('.telephonePp').addClass("notOkay");
	}
	else
	{
		$('.telephonePp').removeClass("notOkay");
	}
});

function checkPpDatas(){
	if (
		!$('.telephonePp').val().match(/^[0-9 +]+$/) || $('.telephonePp').val().length < 9 ||
		//!$('.prenomPp').val().match(/^([A-Za-z '-éèëêâä]+)$/) ||
		//!$('.nomPp').val().match(/^([A-Za-z '-éèëêâä]+)$/) ||
		!$('.mailPp').val().match(/(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/))
	{
		$('.messagePp').text("Tous les champs ne sont pas correctement remplis");
		return false;
	}
	else{
		if ($('.nationalitePp').val().length <= 0)
			$('.nationalitePp').val("-");
		if ($('.etatCivilPp').val().length <= 0)
			$('.etatCivilPp').val("-");
		if ($('.lieuNaissancePp').val().length <= 0)
			$('.lieuNaissancePp').val("-");
		if ($('.dateNaissancePp').val().length <= 0)
			$('.dateNaissancePp').val("-");
		if ($('.adressePp').val().length <= 0)
			$('.adressePp').val("-");
		return true;
	}
}
$('.formPhysique form').submit(function(e){
	return checkPpDatas();
});
