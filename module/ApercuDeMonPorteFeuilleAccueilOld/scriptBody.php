</script>
<script>

function demandeContact(msg, id) {
	$.ajax({
		url: "ajax_request_client.php",
		method: "POST",
		data: {
			"token": "<?=$_SESSION['csrf'][0]?>",
			"req": "AjaxContact",
			"data": { 'demande':msg,
				'id': id
			},
			"dataType": "json"
		}
	}).done(function(res) {
		if (typeof res.response != "undefined")
			msgBox.show(res.response);
		else
			msgBox.show("Votre conseiller prendra contact avec vous prochainement.");
	}).fail(function(res) {
		msgBox.show("Une erreur s'est produite, la demande de contact n'a pas pu aboutir. Veuillez nous en excuser.");
	});
}

function defineMaxMontentEmprunt()
{
	if ($('#prix').val() * $('#part').val() > 0)
		$('#montant_credit').attr('max', $('#prix').val() * $('#part').val());
	else
		$('#montant_credit').attr('max', '');
}

function showFormRemove(id) {
	//$(".formToRemove_" + id).css("display", "table-row");
	//$(".formToRemove_" + id).toggle();
}
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
function prepareSellPart(id, name, dateMin, actualValue, id_modal) {

	$(".modal_id_sell").val(id);
	$(".modal_title_sell").html(name);
	$(".prix_part_sell").attr("value", Intl.NumberFormat("en-EN", {maximumFractionDigits: 5}).format(actualValue));

	<?php
	if (!isMobile())
	{
		?>
		$( "#dateSelling").datepicker( "option", "minDate", dateMin);
		<?php
	}
	else
	{
		?>
		$(".dateenr").attr("min", dateMin);
		$(".dateenr").attr("max", "<?=date("Y-m-d")?>");
		<?php
	}
	?>
	$(".modal_to_open").val(id_modal);
}

function align_tt () {
	var i = 0;
	var tt = document.getElementById("tbl_tt");
	var th = document.getElementById("tbl_th");
	if (!tt || !th)
		return ;
	th = th.firstElementChild;
	tt = tt.firstElementChild;
	while (tt != null && i < 16) {
		while(tt != null && window.getComputedStyle(tt).getPropertyValue('display') == "none") {
			tt = tt.nextElementSibling;
		}
		while(th != null && window.getComputedStyle(th).getPropertyValue('display') == "none") {
			th = th.nextElementSibling;
		}
		$(tt).width($(th).width());
		if (tt == null || th == null)
			break ;
		tt = tt.nextElementSibling;
		th = th.nextElementSibling;
	}
}

window.addEventListener('load', function() {
	align_tt();
	$(".modalSellMsg").css("display", "none");
	redrawBlockContour();
});
window.addEventListener('resize', function() {
	align_tt();
	redrawBlockContour();
});

$('.mdl').on('shown.bs.modal', function () {
	redrawBlockContour();
});
$('.mdl').on('hidden.bs.modal', function () {
	$(".modalSellMsg").css("display", "none");
});

$('.mdlNew').on('hidden.bs.modal', function () {
	var scpi = document.getElementById("SCPI");
	var tp = document.getElementById("propriete");
	scpi.selectedIndex = 0;
	tp.selectedIndex = 0;
	$("#SCPI").removeAttr('disabled');
	$("#propriete").removeAttr('disabled');
	$("#propriete").trigger("change");
});


function setModalNewFixed(id_scpi, type_pro) {
	var i = 0;
	var j = 0;
	$("#SCPI > option").each(function() {
		if (id_scpi == this.value) {
			var scpi = document.getElementById("SCPI");
			scpi.selectedIndex = i;
//			$(scpi).attr('disabled', '');
		}
		i++;
	});
	$("#propriete > option").each(function() {
		if (type_pro == this.value) {
			var tp = document.getElementById("propriete");
			tp.selectedIndex = j;
			$("#propriete").trigger("change");
//			$(tp).attr('disabled', '');
		}
		j++;
	});
}

$(document).on('hidden.bs.modal', '.modal', function () {
    $('.modal:visible').length && $(document.body).addClass('modal-open');
});


var counter = 0;

setInterval(function() {
		counter += 0.5;
		var position = (Math.sin(counter) * 5) - 53;
		$('.flechAide').css("margin-top", position + "px");
	},
	100
);

$(document).ready(function() {
	$('#prix').on('change', function(){ defineMaxMontentEmprunt() });
	$('#part').on('change', function(){ defineMaxMontentEmprunt() });
	<?php
	if (!isMobile())
	{
		?>
		$("#date").datepicker({
			dateFormat: 'dd/mm/yy',
			maxDate: 'd',
			changeMonth: true,
			changeYear: true,
		}),
		$("#date_debut_credit").datepicker({
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
			if ($('#type_demembrement').val() === "Temporaire") {
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
	$('#date').change(function(){
		var date = $('#date').val();
		if (date.match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/))
		{
			$('.valid9').css("display", "block");
			$('.erreur9').css("display", "none");
			$('#date').css("border", "2px solid #018A13");
		}
		else
		{
			$('.valid9').css("display", "none");
			$('.erreur9').css("display", "block");
			$('#date').css("border", "1px solid #ccc");
		}
	}),
	$('#date').keyup(function(){
		var date = $('#date').val();
		if (date.match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/))
		{
			$('.valid9').css("display", "block");
			$('.erreur9').css("display", "none");
			$('#date').css("border", "2px solid #018A13");
		}
		else
		{
			$('.valid9').css("display", "none");
			$('.erreur9').css("display", "block");
			$('#date').css("border", "1px solid #ccc");
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
		if ($('#type_demembrement').val() === "Temporaire") {
			$('#demembrement').show();
			$('#demembrement input').attr('required', '1');
		} else {
			$('#demembrement input').val('1');
			$('#demembrement input').removeAttr('required');
			$('#demembrement').hide();
		}
	})
});
