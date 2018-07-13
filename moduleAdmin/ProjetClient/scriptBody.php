</script>
<script type="text/javascript" charset="utf-8">

var dataProject = <?=json_encode($this->projectForJson)?>;
var requiredDocumentProjet = <?=json_encode($this->RequiredDocumentProject)?>;
var tableObjectifs= <?=json_encode(Projet::$_listObjectif)?>;
<?php
/*
//var documentProject = <?=json_encode($this->documentProject)?>;
*/

?>

function init_ProjetClient() {
}

function showViewProjet(id)
{
	var nom = "";
	var dataCurrent = dataBeneficiaire[dataProject[id]['idBeneficiaire']];
	for (var i = 0; i < dataCurrent.length;i++)
	{
		if (i != 0)
			nom += "<br />";
		nom += dataPp[dataCurrent[i]['id']]['civiliteFormat'];
		nom += " " + dataPp[dataCurrent[i]['id']]['prenom'];
		nom += " " + dataPp[dataCurrent[i]['id']]['nom'];
	}
	$(".nomBeneficiaire").html(nom);

	var script = `
		function goToBeneficiaire() {
			showOnglet('BENEFICIAIRES');
			eval('init_BeneficiaireClient();');
			showViewBeneficiaire('` + dataProject[id]['idBeneficiaire'] + `');
			$('.modalViewProject').off('hidden.bs.modal', goToBeneficiaire);
		};
		$('.modalViewProject').on('hidden.bs.modal', goToBeneficiaire);
		$('.modalViewProject').modal('hide');
	`;

	$(".nomBeneficiaire").attr("onclick", script);

	$('.modalViewProjectBlockDocuments').children().remove();
	var tmp = $(".modalViewProjectDocument1");
	for (var doc in requiredDocumentProjet)
	{
		var data = dataProject[id]["files"][requiredDocumentProjet[doc]["id"]];
		var nelm = tmp.clone();
		nelm.find(".projectObjectifText").html(requiredDocumentProjet[doc]["name"]);
		myScript = "showListeDeroulante({idClient:'<?=$this->dh->id_dh?>', idEntity:'<?=Entity::getByClassName("Projet")->id?>', linkEntity:" + id + ", idTypeDocument:'" + requiredDocumentProjet[doc].id + "'}," + JSON.stringify(data) + ", event);";
		if (Object.keys(data).length < 1)
		{
			nelm.find("button").addClass("notComplete");
		}
		nelm.attr("onclick", myScript);
		nelm.appendTo('.modalViewProjectBlockDocuments').show();
	}

	$('.Btn1').find('.projectObjectifText').text(tableObjectifs[dataProject[id]["objectifs"][0]]);
	$('.Btn2').find('.projectObjectifText').text(tableObjectifs[dataProject[id]["objectifs"][1]]);
	$('.Btn3').find('.projectObjectifText').text(tableObjectifs[dataProject[id]["objectifs"][2]]);

	$(".modalViewProject .modalViewProjectTitre h2").html(dataProject[id]["nom"]);
	$(".modalViewProject .ProjectDateInner .Date2").html(dataProject[id]["dateCreationStr"]);
	if (dataProject[id]["credit"])
	{
		$('.budgetBeneficiaire2 .budgetBeneficiaireBudget1 .fa').removeClass('fa-toggle-off');
		$('.budgetBeneficiaire2 .budgetBeneficiaireBudget1 .fa').addClass('fa-toggle-on');
	}
	else
	{
		$('.budgetBeneficiaire2 .budgetBeneficiaireBudget1 .fa').removeClass('fa-toggle-on');
		$('.budgetBeneficiaire2 .budgetBeneficiaireBudget1 .fa').addClass('fa-toggle-off');
	}
	if (dataProject[id]["accompagnement"])
	{
		$('.budgetBeneficiaire3 .budgetBeneficiaireBudget1 .fa').removeClass('fa-toggle-off');
		$('.budgetBeneficiaire3 .budgetBeneficiaireBudget1 .fa').addClass('fa-toggle-on');
	}
	else
	{
		$('.budgetBeneficiaire3 .budgetBeneficiaireBudget1 .fa').removeClass('fa-toggle-on');
		$('.budgetBeneficiaire3 .budgetBeneficiaireBudget1 .fa').addClass('fa-toggle-off');
	}
	$('.budgetBeneficiaire .budgetBeneficiaireBudget2').text(dataProject[id]["budget"]);
	$('.ProjectConseiller').text(dataProject[id]["conseiller"]);

	$(".modalViewProject").modal("show");
}
