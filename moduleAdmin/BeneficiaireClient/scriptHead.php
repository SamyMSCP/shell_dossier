</script>
<script type="text/javascript" charset="utf-8">

var dataBeneficiaire = {
<?php
	$first1 = true;
	foreach ($this->beneficiaires as $key => $elm)
	{
		if (!$first1)
			echo ",\n";
		?>	"<?=$elm->id_benf?>":[
			<?php
			$first2 = true;
			foreach ($elm->getPersonnePhysique() as $key2 => $elm2)
			{
				if (!$first2)
					echo ",
					";
				?>{
				"id":"<?=$elm2->id_phs?>"
			}<?php
				$first2 = false;
			}
			?>
		
		]<?php
		$first1 = false;
	}
?>
}

var dataSituationJuridique = <?=json_encode($this->dataSituationJuridique)?>;
var dataSituationFinanciere = <?=json_encode($this->dataSituationFinanciere)?>;
var dataSituationFiscale = <?=json_encode($this->dataSituationFiscale)?>;
var dataSituationPatrimoniale = <?=json_encode($this->dataSituationPatrimoniale)?>;
var dataBeneficiaireSituation = <?=json_encode($this->tabBen)?>;

function createButtonBeneficiairePpDocument(idPp, idDoc) {
	return null;
}

</script>
<script type="text/javascript" charset="utf-8">

function setInformationSituationJuridique(datas, idSituation) {
	$('.TableauSituationJuridique .dateSituation').val(dataSituationJuridique[datas]['dateSituationJuridique']);
	$('.TableauSituationJuridique .dateFinSituation').val(dataSituationJuridique[datas]['dateFinSituationJuridique']);
	$('.TableauSituationJuridique .regimeMat').val(dataSituationJuridique[datas]['regimeMat']);
	$('.TableauSituationJuridique .NbrEnfantCharge').val(dataSituationJuridique[datas]['NbrEnfantCharge']);
	$('.TableauSituationJuridique .NbrPersonnesCharge').val(dataSituationJuridique[datas]['NbrPersonnesCharge']);
	$('.TableauSituationJuridique .idSituation').val(idSituation);
	$('.TableauSituationJuridique .idSituationJuridique').val(dataSituationJuridique[datas]['id']);
	$('.TableauSituationJuridique .submitSituationJuridique').val("Modifier");
}

function createInformationSituationJuridique(idSituation) {
	$('.TableauSituationJuridique .dateSituation').val("");
	$('.TableauSituationJuridique .dateFinSituation').val("");
	$('.TableauSituationJuridique .regimeMat').val("");
	$('.TableauSituationJuridique .NbrEnfantCharge').val("");
	$('.TableauSituationJuridique .NbrPersonnesCharge').val("");
	$('.TableauSituationJuridique .idSituation').val(idSituation);
	$('.TableauSituationJuridique .submitSituationJuridique').val("Ajouter");
}

function setInformationSituationFiscale(datas, idSituation) {
	$('.TableauSituationFiscale .dateSituation').val(dataSituationFiscale[datas]['dateSituationFiscale']);
	$('.TableauSituationFiscale .dateFinSituation').val(dataSituationFiscale[datas]['dateFinSituationFiscale']);

	if (dataSituationFiscale[datas]['residentFrance'] == 1)
		$('.TableauSituationFiscale .residentFrance').prop("checked", true);
	else
		$('.TableauSituationFiscale .residentFrance').prop("checked", false);
	$('.TableauSituationFiscale .tauxMarginalImposition').val(dataSituationFiscale[datas]['tauxMarginalImposition']);
	$('.TableauSituationFiscale .impotsAnneePrecedente').val(dataSituationFiscale[datas]['impotsAnneePrecedente']);
	$('.TableauSituationFiscale .nbrPartsFiscales').val(dataSituationFiscale[datas]['nbrPartsFiscales']);
	$('.TableauSituationFiscale .trancheIsf').val(dataSituationFiscale[datas]['trancheIsf']);
	$('.TableauSituationFiscale .montantIsf').val(dataSituationFiscale[datas]['montantIsf']);

	$('.TableauSituationFiscale .idSituation').val(idSituation);
	$('.TableauSituationFiscale .idSituationFiscale').val(dataSituationFiscale[datas]['id']);
	$('.TableauSituationFiscale .submitSituationFiscale').val("Modifier");
}

function createInformationSituationFiscale(idSituation) {
	$('.TableauSituationFiscale .dateSituation').val("");
	$('.TableauSituationFiscale .dateFinSituation').val("");

	$('.TableauSituationFiscale .residentFrance').prop("checked", false);
	$('.TableauSituationFiscale .tauxMarginalImposition').val("");
	$('.TableauSituationFiscale .impotsAnneePrecedente').val("");
	$('.TableauSituationFiscale .nbrPartsFiscales').val("");
	$('.TableauSituationFiscale .trancheIsf').val("");
	$('.TableauSituationFiscale .montantIsf').val("");

	$('.TableauSituationFiscale .idSituation').val(idSituation);
	$('.TableauSituationFiscale .submitSituationFiscale').val("Ajouter");
}

function setInformationSituationFinanciere(datas, idSINANCIEREituation) {
	$('.TableauSituationFinanciere .dateSituation').val(dataSituationFinanciere[datas]['dateSituationFinanciere']);
	$('.TableauSituationFinanciere .dateFinSituation').val(dataSituationFinanciere[datas]['dateFinSituationFinanciere']);

	$('.TableauSituationFinanciere .revenuProfessionnels').val(dataSituationFinanciere[datas]['revenuProfessionnels']);
	$('.TableauSituationFinanciere .revenuImmobiliers').val(dataSituationFinanciere[datas]['revenuImmobiliers']);
	$('.TableauSituationFinanciere .revenuMobiliers').val(dataSituationFinanciere[datas]['revenuMobiliers']);
	$('.TableauSituationFinanciere .revenuAutres').val(dataSituationFinanciere[datas]['revenuAutres']);
	$('.TableauSituationFinanciere .remboursementMensuel').val(dataSituationFinanciere[datas]['remboursementMensuel']);
	$('.TableauSituationFinanciere .dureeRemboursementRestante').val(dataSituationFinanciere[datas]['dureeRemboursementRestante']);
	$('.TableauSituationFinanciere .natureAutresEmprunts').val(dataSituationFinanciere[datas]['natureAutresEmprunts']);
	$('.TableauSituationFinanciere .montantAutresEmprunts').val(dataSituationFinanciere[datas]['montantAutresEmprunts']);
	$('.TableauSituationFinanciere .dureeAutresEmprunts').val(dataSituationFinanciere[datas]['dureeAutresEmprunts']);

	$('.TableauSituationFinanciere .idSituation').val(idSituation);
	$('.TableauSituationFinanciere .idSituationFinanciere').val(dataSituationFinanciere[datas]['id']);
	$('.TableauSituationFinanciere .submitSituationFinanciere').val("Modifier");
}

function setInformationSituationPatrimoniale(datas, idSituation) {
	$('.TableauSituationPatrimoniale .dateSituation').val(dataSituationPatrimoniale[datas]['dateSituationPatrimoniale']);
	$('.TableauSituationPatrimoniale .dateFinSituation').val(dataSituationPatrimoniale[datas]['dateFinSituationPatrimoniale']);


	$('.TableauSituationPatrimoniale .fourchetteMontantPatrimoine').val(dataSituationPatrimoniale[datas]['fourchetteMontantPatrimoine']);
	$('.TableauSituationPatrimoniale .repartitionPatrimoine').val(dataSituationPatrimoniale[datas]['repartitionPatrimoine']);
	if (dataSituationPatrimoniale[datas]['futurPlacement'] == 1)
		$('.TableauSituationPatrimoniale .futurPlacement').prop("checked", true);
	else
		$('.TableauSituationPatrimoniale .futurPlacement').prop("checked", false);
	$('.TableauSituationPatrimoniale .idSituation').val(idSituation);
	$('.TableauSituationPatrimoniale .idSituationPatrimoniale').val(dataSituationPatrimoniale[datas]['id']);
	$('.TableauSituationPatrimoniale .submitSituationPatrimoniale').val("Modifier");
}

function createInformationSituationFinanciere(idSituation) {
	$('.TableauSituationFinanciere .dateSituation').val("");
	$('.TableauSituationFinanciere .dateFinSituation').val("");
	$('.TableauSituationFinanciere .idSituation').val(idSituation);
	$('.TableauSituationFinanciere .submitSituationFinanciere').val("Ajouter");
}

function createInformationSituationPatrimoniale(idSituation) {
	$('.TableauSituationPatrimoniale .dateSituation').val("");
	$('.TableauSituationPatrimoniale .dateFinSituation').val("");

	$('.TableauSituationPatrimoniale .fourchetteMontantPatrimoine').val("");
	$('.TableauSituationPatrimoniale .repartitionPatrimoine').val("");
	$('.TableauSituationPatrimoniale .futurPlacement').prop("checked", false);

	$('.TableauSituationPatrimoniale .idSituation').val(idSituation);
	$('.TableauSituationPatrimoniale .submitSituationPatrimoniale').val("Ajouter");
}


function showViewBeneficiaireSituationJuridique(datas)
{
	var St = datas['SituationJuridique']
	$('.ListeSituationJuridique ul').empty();
	if (St.length >= 1 && !(St.length == 1 && St[0] == null))
	{
		for (var data in St)
		{
			var nli = $("<li>").html(dataSituationJuridique[St[data]]['dateSituationJuridiqueEu'] + " - " + dataSituationJuridique[St[data]]['dateFinSituationJuridiqueEu']);
			nli.attr("onclick", "setInformationSituationJuridique(" + St[data] + ", " + datas["idSituation"]+ ")");
			$('.ListeSituationJuridique ul').append(nli);
		}
	}
	var nli = $("<li>").html("Ajouter");
	nli.attr("onclick", "createInformationSituationJuridique(" + datas["idSituation"] + ")");
	$('.ListeSituationJuridique ul').append(nli);
}

function showViewBeneficiaireSituationFinanciere(datas)
{
	var St = datas['SituationFinanciere'];
	$('.ListeSituationFinanciere ul').empty();
	if (St.length >= 1 && !(St.length == 1 && St[0] == null))
	{
		for (var data in St)
		{
			var nli = $("<li>").html(dataSituationFinanciere[St[data]]['dateSituationFinanciereEu'] + " - " + dataSituationFinanciere[St[data]]['dateFinSituationFinanciereEu']);
			nli.attr("onclick", "setInformationSituationFinanciere(" + St[data] + ", " + datas["idSituation"]+ ")");
			$('.ListeSituationFinanciere ul').append(nli);
		}
	}
	var nli = $("<li>").html("Ajouter");
	nli.attr("onclick", "createInformationSituationFinanciere(" + datas["idSituation"] + ")");
	$('.ListeSituationFinanciere ul').append(nli);
}

function showViewBeneficiaireSituationFiscale(datas)
{
	var St = datas['SituationFiscale'];
	$('.ListeSituationFiscale ul').empty();
	if (St.length >= 1 && !(St.length == 1 && St[0] == null))
	{
		for (var data in St)
		{
			var nli = $("<li>").html(dataSituationFiscale[St[data]]['dateSituationFiscaleEu'] + " - " + dataSituationFiscale[St[data]]['dateFinSituationFiscaleEu']);
			nli.attr("onclick", "setInformationSituationFiscale(" + St[data] + ", " + datas["idSituation"]+ ")");
			$('.ListeSituationFiscale ul').append(nli);
		}
	}
	var nli = $("<li>").html("Ajouter");
	nli.attr("onclick", "createInformationSituationFiscale(" + datas["idSituation"] + ")");
	$('.ListeSituationFiscale ul').append(nli);
}

function showViewBeneficiaireSituationPatrimoniale(datas)
{
	var St = datas['SituationPatrimoniale'];
	$('.ListeSituationPatrimoniale ul').empty();
	if (St.length >= 1 && !(St.length == 1 && St[0] == null))
	{
		for (var data in St)
		{
			var nli = $("<li>").html(dataSituationPatrimoniale[St[data]]['dateSituationPatrimonialeEu'] + " - " + dataSituationPatrimoniale[St[data]]['dateFinSituationPatrimonialeEu']);
			nli.attr("onclick", "setInformationSituationPatrimoniale(" + St[data] + ", " + datas["idSituation"]+ ")");
			$('.ListeSituationPatrimoniale ul').append(nli);
		}
	}
	var nli = $("<li>").html("Ajouter");
	nli.attr("onclick", "createInformationSituationPatrimoniale(" + datas["idSituation"] + ")");
	$('.ListeSituationPatrimoniale ul').append(nli);
}

</script>
<script type="text/javascript" charset="utf-8">

function showViewBeneficiaire(id)
{
	var titre = "";
	for (var elm in dataBeneficiaire[id])
	{
		if (dataPp[dataBeneficiaire[id][elm].id].civilite === "Monsieur")
			titre += "M. ";
		else
			titre += "Mme ";
		titre += dataPp[dataBeneficiaire[id][elm].id].prenom + " ";
		titre += dataPp[dataBeneficiaire[id][elm].id].nom + " <br />";
	}
	$(".modalViewBeneficiaire .modalViewBeneficiaireTitre h2").html(titre);
	$(".modalViewBeneficiaire .modalViewBeneficiaireTitre img").attr("src", "<?=$this->getPath()?>img/Gender_F-H.png");
	$(".modalViewBeneficiaireBlockPp").children().remove();
	var blkPpBeneficiaire = $('.modalViewBeneficiairePp1');
	for (var elm in dataBeneficiaire[id])
	{
		var titre = "";
		var tmp = blkPpBeneficiaire.clone();
		if (dataPp[dataBeneficiaire[id][elm].id].civilite === "Monsieur")
		{
			tmp.find(".nomPp img").attr("src", "<?=$this->getPath()?>img/Gender_Homme.png");
			titre += "M. ";
		}
		else
		{
			tmp.find(".nomPp img").attr("src", "<?=$this->getPath()?>img/Gender_Femme.png");
			titre += "Mme ";
		}
		titre += dataPp[dataBeneficiaire[id][elm].id].prenom + " ";
		titre += dataPp[dataBeneficiaire[id][elm].id].nom;
		tmp.find(".nomPp h3").html(titre);
		tmp.find(".benNationalite span").html(dataPp[dataBeneficiaire[id][elm].id].nationalite);
		tmp.find(".benTel span").html(dataPp[dataBeneficiaire[id][elm].id].telephone);
		tmp.find(".benMail span").html(dataPp[dataBeneficiaire[id][elm].id].mail);
		//cible.empty();
		for (doc in documentPp)
		{
			var data = dataPp[dataBeneficiaire[id][elm].id]["files"][documentPp[doc]["id"]];
			var ndiv = $("<div>").addClass('beneficiaireViewBtn');
			var nbutton = $("<button type='submit'>" + documentPp[doc]["name"] + "</button>");
			if (Object.keys(data).length < 1)
			{
				nbutton.addClass("notComplete");
			}
			myScript = "showListeDeroulante({idClient:'<?=$this->dh->id_dh?>', idEntity:'<?=Entity::getByClassName("Pp")->id?>', linkEntity:" + dataBeneficiaire[id][elm].id + ", idTypeDocument:'" + documentPp[doc].id + "'}," + JSON.stringify(data) + ", event);";
			nbutton.attr("onclick", myScript);
			ndiv.append(nbutton);
			tmp.find(".blkRight").append(ndiv);
		}
		tmp.appendTo(".modalViewBeneficiaireBlockPp").show();
	}
	$(".modalViewBeneficiaireBlockProjets").children().remove();
	var tmp2 = $(".modalViewBeneficiaireBlockProjetsIn1");
	var Project = dataBeneficiaireSituation[id]["Projects"];
	for (var elm in Project)
	{
		proj = dataProject[Project[elm]];
		var nelm = tmp2.clone();
		nelm.find(".projectName").html(proj['nom']);
		if (proj['etatProjet'] >= 8)
		{
			nelm.find(".projectStatus").html("FINALISE");
			tmp.find(".projectImg").attr("src", "<?=$this->getPath()?>img/Dossiers-blanc_closed.png");
		}
		else
		{
			nelm.find(".projectStatus").html("EN COURS");
			nelm.find(".projectImg").attr("src", "<?=$this->getPath()?>img/Dossiers-blanc_open.png");
		}

		var script = `
			function goToProject () {
				showOnglet('PROJETS');
				eval('init_ProjetClient();');
				showViewProjet('` + proj['id'] + `');
				$('.modalViewBeneficiaire').off('hidden.bs.modal', goToProject);
			};
			$('.modalViewBeneficiaire').on('hidden.bs.modal', goToProject);
			$('.modalViewBeneficiaire').modal('hide');
		`;
		nelm.attr("onclick", script);
		nelm.appendTo(".modalViewBeneficiaireBlockProjets").show();
	}
	var nelm = $(".modalViewBeneficiaireBlockProjetsIn1New").clone();
	nelm.appendTo(".modalViewBeneficiaireBlockProjets").show();
	showViewBeneficiaireSituationJuridique(dataBeneficiaireSituation[id]);
	showViewBeneficiaireSituationFinanciere(dataBeneficiaireSituation[id]);
	showViewBeneficiaireSituationFiscale(dataBeneficiaireSituation[id]);
	showViewBeneficiaireSituationPatrimoniale(dataBeneficiaireSituation[id]);
	showInOnglet2('Projet');
	$(".modalViewBeneficiaire").modal("show");
}
