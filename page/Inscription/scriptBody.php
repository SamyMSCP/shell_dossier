	
</script>
<script type="text/javascript" charset="utf-8">
/*	$(document).ready(function(){
	$('#indicatif').change(function() {
		$("#indic_res").html("+" + $('#indicatif').val());
	})
	$('#pass').keyup(function()
	{
		checkStrength($('#pass').val())
	})
	$('#nom').keyup(function(){
		if (!$('#nom').val().match(/^([A-Za-z '-éèëêâä]+)$/)){
			$('.valid1').css("display", "none");
			$('.erreur1').css("display", "initial");
			$('#nom').css("border", "2px solid #01528A");
			$('#msgimp').css("display", "block");
		}
		else{
			$('.valid1').css("display", "initial");
			$('.erreur1').css("display", "none");
			$('#nom').css("border", "2px solid #018A13");
			$('#msgimp').css("display", "none");
		}
	})
	$('#prenom').keyup(function(){
		if (!$('#prenom').val().match(/^([A-Za-z '-éèêëâä]+)$/)){
			$('.valid2').css("display", "none");
			$('.erreur2').css("display", "initial");
			$('#prenom').css("border", "2px solid #01528A");
			$('#msgimp').css("display", "block");
		}
		else{
			$('.valid2').css("display", "initial");
			$('.erreur2').css("display", "none");
			$('#prenom').css("border", "2px solid #018A13");
			$('#msgimp').css("display", "none");
		}
	})
	$('#num').keyup(function(){
		if (!$('#num').val().match(/^[1-9][0-9]+$/) || $('#num').val().length < 9){
			$('.valid3').css("display", "none");
			$('.erreur3').css("display", "initial");
			$('#num').css("border", "2px solid #01528A");
			$('#indic_res').css("border-color", "#01528A");
			$('#msgimp').css("display", "block");
		}
		else{
			$('.valid3').css("display", "initial");
			$('.erreur3').css("display", "none");
			$('#num').css("border", "2px solid #018A13");
			$('#indic_res').css("border-color", "#018A13");
			$('#msgimp').css("display", "none");
		}
	})
	$('#mail').keyup(function(){
		if (!$('#mail').val().match(/(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/)){
			$('.valid4').css("display", "none");
			$('.erreur4').css("display", "initial");
			$('#mail').css("border", "2px solid #01528A");
			$('#msgimp').css("display", "block");
		}
		else{
			$('.valid4').css("display", "initial");
			$('.erreur4').css("display", "none");
			$('#mail').css("border", "2px solid #018A13");
			$('#msgimp').css("display", "none");
		}
	})
	function checkStrength(password){
	if (!password.match(/([a-z])/g)){
		$('.pass_erreur1').css("display", "none");
		$('.pass_erreur2').css("display", "none");
		$('.pass_erreur3').css("display", "initial");
		$('.pass_erreur4').css("display", "none");
		$('.success_1').css("display", "none");
		$('#pass').css("border", "2px solid #01528A");
		$('#msgimp').css("display", "block");
	}
	else if (!password.match(/([A-Z])/g)){
		$('.pass_erreur1').css("display", "none");
		$('.pass_erreur2').css("display", "initial");
		$('.pass_erreur3').css("display", "none");
		$('.pass_erreur4').css("display", "none");
		$('.success_1').css("display", "none");
		$('#pass').css("border", "2px solid #01528A");
		$('#msgimp').css("display", "block");
	}
	else if (!password.match(/[0-9]/g)){
		$('.pass_erreur1').css("display", "none");
		$('.pass_erreur2').css("display", "none");
		$('.pass_erreur3').css("display", "none");
		$('.pass_erreur4').css("display", "initial");
		$('.success_1').css("display", "none");
		$('#pass').css("border", "2px solid #01528A");
		$('#msgimp').css("display", "block");
	}
	else if (password.length < 8){
		console.log(password);
		$('.pass_erreur1').css("display", "initial");
		$('.pass_erreur2').css("display", "none");
		$('.pass_erreur3').css("display", "none");
		$('.pass_erreur4').css("display", "none");
		$('.success_1').css("display", "none");
		$('#pass').css("border", "2px solid #01528A");
		$('#msgimp').css("display", "block");
	}
	else{
		$('.pass_erreur1').css("display", "none");
		$('.pass_erreur2').css("display", "none");
		$('.pass_erreur3').css("display", "none");
		$('.pass_erreur4').css("display", "none");
		$('.success_1').css("display", "initial");
		$('#pass').css("border", "2px solid #018A13");
		$('#msgimp').css("display", "none");
	}
	}
	$('#pass2').keyup(function(){
		if ($('#pass2').val() != $('#pass').val()){
			$('.success_2').css("display", "none");
			$('.erreur5').css("display", "initial");
			$('#pass2').css("border", "2px solid #01528A");
			$('#msgimp').css("display", "block");
		}
		else{
			$('.success_2').css("display", "initial");
			$('.erreur5').css("display", "none");
			$('#pass2').css("border", "2px solid #018A13");
			$('#msgimp').css("display", "none");
		}
	})
})*/
