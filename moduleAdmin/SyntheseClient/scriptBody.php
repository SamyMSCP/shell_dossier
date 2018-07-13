</script>
<script type="text/javascript" charset="utf-8">
function init_SyntheseClient() {
}
var vueInstance = new Vue({
	el: "#appPortefeuille",
	store: store
});

function deleteTransaction (id_trans) {
	var f = document.createElement("form");
	f.setAttribute('method',"post");
	f.setAttribute('action',"?p=<?=$GLOBALS['GET']['p']?>&client=<?=$GLOBALS['GET']['client']?>");

	var i = document.createElement("input"); //input element, text
	i.setAttribute('type',"hidden");
	i.setAttribute('name',"token");
	i.setAttribute('value',"<?=$_SESSION['csrf'][0]?>");

	var s = document.createElement("input"); //input element, Submit button
	s.setAttribute('type',"hidden");
	s.setAttribute('name',"action");
	s.setAttribute('value',"Supprimer la transaction");


	var id = document.createElement("input"); //input element, Submit button
	id.setAttribute('type',"hidden");
	id.setAttribute('name',"id_transaction");
	id.setAttribute('value', id_trans);

	f.appendChild(i);
	f.appendChild(s);
	f.appendChild(id);

	document.getElementsByTagName('body')[0].appendChild(f);

	f.submit();
}

function showDeleteTransaction(id) {
	msgBox.show("Etes vous sur de vouloir supprimer cette transaction ? Toutes les transactions de ventes éventuelles liées a cette transaction seront également supprimées ! Cette action est irrémédiable",[
		{
			text: "Je suis sur !",
			action: function() { 
				deleteTransaction(id);
			}
		},
		{
			text: "Non",
			action: function() {
			}
		},
	]);
}

function showDeleteTransactionSell(id) {
	msgBox.show("Etes vous sur de vouloir supprimer cette transaction ? Cette action est irrémédiable",[
		{
			text: "Je suis sur !",
			action: function() { 
				deleteTransaction(id);
			}
		},
		{
			text: "Non",
			action: function() {
			}
		},
	]);
}



function editTransaction(id, data)
{
	
	<?php
	foreach ($this->RequiredDocumentTransaction as $key => $elm)
	{
		?>
		$('.transactionTypeDoc_<?=$elm->id?>').attr("onclick", "showListeDeroulante({idClient:'<?=$this->dh->id_dh?>', idEntity:'<?=Entity::getByClassName("Transaction")->id?>', linkEntity:'" + id + "', idTypeDocument:'<?=$elm->id?>'}, dataTransaction[" + id + "][<?=$elm->id?>]  , event);");
		if (Object.keys(dataTransaction[id][<?=$elm->id?>]).length == 0)
		{
			$('.transactionTypeDoc_<?=$elm->id?>').addClass("isEmpty");
		}
		else
		{
			$('.transactionTypeDoc_<?=$elm->id?>').removeClass("isEmpty");
		}
		<?php
	}
	?>
	$('#jouissanceIn').text(data.entreeJouissance);
	$('#demembrementOut').text(data.sortieJouissance);

	$('#signatureBs').text(data.date_bs);
	$('#enr_date').val(data.enr_date);
	
	$('#editNameScpi').text(data.name);
	$('#editNbrPart').val(data.nbrPart);
	$('#editType').val(data.typePro);
	$('#editMarche').val(data.marche);
	if (data.typePro == "Pleine propriété")
		$('.forNoPleine').hide();
	else
		$('.forNoPleine').show();
	$('#editCle').val(data.cle);
	$('#editDuree').val(data.duree);
	$('#editPrixPart').val(data.prixPart);
	$('#editIdTransaction').val(data.id_transaction);
	$('#editTransactinBeneficiaire').val(data.id_ben);
	$('#editMontantTotal').text(parseFloat($('#editNbrPart').val().replace(',','.')) * parseFloat($('#editPrixPart').val().replace(',','.')));

	$('#editNbrPart').on("change", function() {
		$('#editMontantTotal').text(parseFloat($('#editNbrPart').val().replace(',','.')) * parseFloat($('#editPrixPart').val().replace(',','.')));
	});
	$('#editPrixPart').on("change", function() {
		$('#editMontantTotal').text(parseFloat($('#editNbrPart').val().replace(',','.') * parseFloat($('#editPrixPart').val().replace(',','.'))));
	});
	$('#textCommentaire').val(data.commentaire);
	changeTransactionStatusNo();
	if (data.status_trans != null)
	{
		realPosition = data.status_trans;
		//ProgressBlockMove(data.status_trans);
	}
	else
	{
		realPosition = 0;
	}
	setProgressReal();
	
	function closeMdl1() {
		function closeMdl2() {
			$('.modal_editionTransaction').off('hidden.bs.modal', closeMdl2);
			$('.' + data.link).modal('show');
		}
		$('.modal_editionTransaction').on('hidden.bs.modal', closeMdl2);
		$('.modal_editionTransaction').modal('show');
		$('.modalEditTrans').off('hidden.bs.modal', closeMdl1);
	}

	$('.modalEditTrans').on('hidden.bs.modal', closeMdl1);
	$('.modalEditTrans').modal('hide');
	$('.id_transactionUpdateStatusTrans').val(id);
	$('#actionUpdateTransactionCommentaire').hide();
}

function showTableData(id) {
	$('.tableData').hide();
	if (id == 0)
	{
		$('.tableDataTotal').show();
		$('.BtnTransactionBeneficiaireSelected').removeClass('BtnTransactionBeneficiaireSelected');
		$('.BtnTransactionBeneficiaire_0').addClass('BtnTransactionBeneficiaireSelected');
	}
	else
	{
		$('.tableData_' + id).show();
		$('.BtnTransactionBeneficiaireSelected').removeClass('BtnTransactionBeneficiaireSelected');
		$('.BtnTransactionBeneficiaire_' + id).addClass('BtnTransactionBeneficiaireSelected');
	}
}

$(".modal").on("shown", function() {
	document.activeElement.blur()
	$(this).find(".modal-body :input:visible:first").focus();
});
$(document).ready(function() {
	<?php
	if (!isMobile())
	{
		?>
		$("#enr_date").datepicker({
			dateFormat: 'dd/mm/yy',
			maxDate: 'd',
			changeMonth: true,
			changeYear: true,
		}),
		$("#date").datepicker({
			dateFormat: 'dd/mm/yy',
			maxDate: 'd',
			changeMonth: true,
			changeYear: true,
		}),
		$("#dateSelling").datepicker({
			dateFormat: 'dd/mm/yy',
			maxDate: 'd',
			changeMonth: true,
			changeYear: true,
		}),
		<?php
	}
	?>
	$('#propriete').on('change', function (){
		if ($("#propriete").val() != "Pleine propriété" && $("#propriete").val() != "-")
		{
			$("#moredtl").css('display', "block");
			$('#cle').attr('required', '1');
			if ($('#type_demembrement').val() === "temporaire") {
				$('#demembrement').show();
				$('#demembrement input').attr('required', '1');
			} else {
				$('#demembrement input').val('0');
				$('#demembrement input').removeAttr('required');
				$('#demembrement').hide();
			}
		}
		else
		{
			$("#moredtl").css('display', "none");
			$('#cle').val('1');
			$('#cle').removeAttr('required');
			$('#demembrement input').val('1');
			$('#demembrement input').removeAttr('required');
			$('#demembrement').hide();
		}
	}),
	$('#date').change(function(){
		let date = $('#date').val();
		if (date.match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/))
		{
			$('.valid9').css("display", "block");
			$('.erreur9').css("display", "none");
			$('#date').css("border", "2px solid #01528A");
		}
		else
		{
			$('.valid9').css("display", "none");
			$('.erreur9').css("display", "block");
			$('#date').css("border", "2px solid #018A13");
		}
	}),
	$('#date').keyup(function(){
		let date = $('#date').val();
		if (date.match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/))
		{
			$('.valid9').css("display", "block");
			$('.erreur9').css("display", "none");
			$('#date').css("border", "2px solid #01528A");
		}
		else
		{
			$('.valid9').css("display", "none");
			$('.erreur9').css("display", "block");
			$('#date').css("border", "2px solid #018A13");
		}
	}),
	$('#cle').keyup(function(){
	if (!$('#cle').val().match(/^\d{1,2}((\.|,)(\d{1,5}))?$/) && parseFloat($('#cle').val().replace(',','.')) > 0){
		$('.valid1').css("display", "none");
		$('.erreur1').css("display", "block");
		$('#cle').css("border", "2px solid #01528A");
	}
	else{
		$('.valid1').css("display", "block");
		$('.erreur1').css("display", "none");
		$('#cle').css("border", "2px solid #018A13");
	}
	}),
	$('#part').keyup(function(){
		if (!$('#part').val().match(/^\d+((\.|,)(\d{1,5}))?$/) && parseFloat($('#part').val().replace(',','.')) > 0){
			$('.valid2').css("display", "none");
			$('.erreur2').css("display", "block");
			$('#part').css("border", "2px solid #01528A");
		}
		else{
			$('.valid2').css("display", "block");
			$('.erreur2').css("display", "none");
			$('#part').css("border", "2px solid #018A13");
		}
	}),
	$('#prix').keyup(function(){
		if (!($('#prix').val().match(/^([0-9]+)$/) || $('#prix').val().match(/^([0-9]+[.,][0-9][0-9])$/) || $('#prix').val().match(/^([0-9]+[.,][0-9])$/))){
			$('.valid8').css("display", "none");
			$('.erreur8').css("display", "block");
			$('#prix').css("border", "2px solid #01528A");
		}
		else{
			$('.valid8').css("display", "block");
			$('.erreur8').css("display", "none");
			$('#prix').css("border", "2px solid #018A13");
		}
	}),
	$('#duree').keyup(function (){
		if ($("#duree").val().match(/^([0-9]+)$/)){
			$('.valid6').css("display", "block");
			$('.erreur6').css("display", "none");
			$("#duree").css('border', "2px solid #018A13");
		}
		else{
			$('.valid6').css("display", "none");
			$('.erreur6').css("display", "block");
			$("#duree").css('border', "2px solid #01528A");
		}
	}),
	$('#marche').on('change', function (){
		if ($("#marche").val() != "-"){
			$("#marche").css('border', "2px solid #018A13");
			$('.valid3').css("display", "block");
			$('.erreur3').css("display", "none");
		}
		else{
			$('.valid3').css("display", "none");
			$('.erreur3').css("display", "block");
			$("#marche").css('border', "2px solid #01528A");
		}
	}),
	$('#transaction').on('change', function (){
		if ($("#transaction").val() != "-"){
			$('.valid4').css("display", "block");
			$('.erreur4').css("display", "none");
			$("#transaction").css('border', "2px solid #018A13");
			$(".more_info").css("display", "block");
		}
		else{
			$('.valid4').css("display", "none");
			$('.erreur4').css("display", "block");
			$("#transaction").css('border', "2px solid #01528A");
			$(".more_info").css("display", "none");
		}
	}),
	$('#informations').keyup(function (){
		if ($("#informations").val() != ""){
			$('.valid7').css("display", "block");
			$('.erreur7').css("display", "none");
			$("#informations").css('border', "2px solid #018A13");
		}
		else{
			$('.valid7').css("display", "none");
			$('.erreur7').css("display", "block");
			$("#informations").css('border', "2px solid #01528A");
		}
	}),
	$('#propriete').on('change', function (){
		if ($("#propriete").val() != "Pleine propriété" && $("#propriete").val() != "-"){
			document.getElementById('marche').value = "Primaire";
				document.getElementById("marche").setAttribute("disabled", "1");
			$('#marche').change();
		}
		else {
				document.getElementById("marche").removeAttribute("disabled");
		}
		if ($("#propriete").val() != "-"){
			$('.valid5').css("display", "block");
			$('.erreur5').css("display", "none");
			$('.erreur5').css("display", "none");
		}
		else{
			$('.valid5').css("display", "none");
			$('.erreur5').css("display", "block");
			$("#propriete").css('border', "2px solid #01528A");
		}
	}),
	$('#type_demembrement').on('change', function (){
		if ($('#type_demembrement').val() === "temporaire") {
			$('#demembrement').show();
			$('#demembrement input').attr('required', '1');
		} else {
			$('#demembrement input').val('1');
			$('#demembrement input').removeAttr('required');
			$('#demembrement').hide();
		}
	})
});


