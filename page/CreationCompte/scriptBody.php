</script>
<script type="text/javascript" charset="utf-8">

	var readFIL = false; //Modal
	var readCGU  = false; //Modal 2

	function showModal1OneTime() {
		if (!readFIL)
		{
			$('#__check').prop("checked");
			checkFormValide();
			readFIL = true;
			$('#myModal').modal('show');
		}
	}

	function showModal2OneTime() {
		if (!readCGU)
		{
			$('#__check2').prop("checked");
			checkFormValide();
			readCGU = true;
			$('#myModal2').modal('show');
		}
	}

	(function($) {
		$.fn.goTo = function() {
			$('html, body').animate({
				scrollTop: Number($(this).offset().top - 120) + 'px'
			}, 'slow');
			return this;
		}
	})(jQuery);

	var disp = 0;
	function check_read(e){

		$('#formNewUser').submit();
		<?php
		/*
		if (!forCheckFormValide())
		{
			e.preventDefault();
			return ;
		}
		if (!readFIL)
		{
			e.preventDefault();
			readFIL = true;
			document.getElementById('pushmodal').click();
			$('#myModal').on('hidden.bs.modal', function () {
				check_read(e);
			})
		}
		else if (!readCGU)
		{
			e.preventDefault();
			readCGU = true;
			document.getElementById('pushmodal2').click();
			$('#myModal2').on('hidden.bs.modal', function () {
				check_read(e);
			})
		}
		else
		{
			$('#formNewUser').submit();
		}
		*/
		?>
	}
	function mydisplaymodal(){
		$('#__check').attr("checked", true);
		checkFormValide();
		readFIL = true;
	}
	function mydisplaymodal2(){
		$('#__check2').attr("checked", true);
		checkFormValide();
		readCGU = true;
	}

	var passChange = false;
	var passChange2 = false;
	$('#pass').on('keyup', function () { passChange = true;});
	$('#pass2').on('keyup', function () { passChange2 = true;});

	function checkIndication(){
		document.getElementById("selectInd").style.border = "2px solid #018A13";
		document.getElementById("indicatifValide").style.display = "block"
	}

	function checkCiviliter()
	{
		document.getElementById("selectCiv").style.border = "2px solid #018A13";
		document.getElementById("civiliteValide").style.display = "block"
	}

	function forCheckFormValide() {
		var rt = true;

		if (!$('#nom').val().match(/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/))
		{
			$("#nom").addClass('notValid');
			rt = false;
		}
		else
			$("#nom").removeClass('notValid');

		if (!$('#prenom').val().match(/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/))
		{
			$("#prenom").addClass('notValid');
			rt = false;
		}
		else
			$("#prenom").removeClass('notValid');

		if (!$('#num').val().match(/^[0-9 +-]{10,}$/))
		{
			$('#num').addClass('notValid');
			rt = false;
		}
		else if (
			$('#countries_phone1').val() == "FR" &&
			(
				(
					$('#num').val()[4] != "7" &&
					$('#num').val()[4] != "6" 
				) ||
				$('#num').val().length != 17
			)
		)
		{
			$('#num').addClass('notValid');
			rt = false;
		}
		else
			$('#num').removeClass('notValid');

		if (!$('#mail').val().match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/))
		{
			$("#mail").addClass('notValid');
			rt = false;
		}
		else{
			$("#mail").removeClass('notValid');
		}

		var password = $('#pass').val();

		$('#pass').addClass('notValid');
		$('#pass2').addClass('notValid');
		if ( $('#pass').val() != $('#pass2').val() ||
			$('#pass').val().length == 0 ||
			$('#pass2').val().length == 0
		)
			rt = false;
		if (passChange)
		{
			$('#pass').removeClass('notValid');
			$('.msgErr').show();
			if (!password.match(/([a-z])/g)){
				$('#pass').addClass('notValid');
				$('.pass_erreur3').removeClass("errorOkay");
				rt = false;
			}
			else
				$('.pass_erreur3').addClass("errorOkay");

			if (!password.match(/([A-Z])/g)){
				$('.msgErr').show();
				$('#pass').addClass('notValid');
				$('.pass_erreur2').removeClass("errorOkay");
				rt = false;
			}
			else
				$('.pass_erreur2').addClass("errorOkay");
			if (!password.match(/[0-9]/g)){
				$('.msgErr').show();
				$('#pass').addClass('notValid');
				$('.pass_erreur4').removeClass("errorOkay");
				rt = false;
			}
			else
				$('.pass_erreur4').addClass("errorOkay");

			if (password.length < 8){
				$('.msgErr').show();
				$('#pass').addClass('notValid');
				$('.pass_erreur1').removeClass("errorOkay");
				rt = false;
			}
			else
				$('.pass_erreur1').addClass("errorOkay");

			if (passChange2)
			{
				$('#pass2').removeClass('notValid');
				$('.msgErr2').show();
				$('#pass2').removeClass('notValid');
				if ($('#pass2').val() != $('#pass').val()){
					$('#pass2').addClass('notValid');
					$('.erreur5').removeClass("errorOkay");
					//$('#msgimp').css("display", "block");
					rt = false;
				}
				else
					$('.erreur5').addClass("errorOkay");
			}
			else
				rt = false;
			if (rt && activeScroll)
				$('#firstValidation').goTo();
		}

		
		if (!$('#__check').prop('checked'))
			rt = false;
		if (!$('#__check2').prop('checked'))
			rt = false;

		return (rt);
	}

	function checkFormValide() {
		activeScroll = false;
		if (forCheckFormValide())
		{
			$('#sendForm').show();
			$('#sendFormInactive').hide();
			// affiche le bouton;
		}
		else
		{
			$('#sendForm').hide();
			$('#sendFormInactive').show();
			// on masque le bouton;
		}
	}

	var activeScroll = false;
	function checkFormValideScroll() {
		activeScroll = true;
		if (forCheckFormValide())
		{
			$('#sendForm').show();
			$('#sendFormInactive').hide();
			$('#sendForm').goTo();
			// affiche le bouton;
		}
		else
		{
			$('#sendForm').hide();
			$('#sendFormInactive').show();
			// on masque le bouton;
		}
	}

$('.contentBlockSituation input').on("change", checkFormValideScroll);
$('.contentBlockSituation input').on("keyup", checkFormValide);
$('.contentBlockSituation select').on("change", checkFormValide);
$('.contentBlockSituation input[type=checkbox]').on("click", checkFormValide);

checkFormValide();











	//$(document).ready(function(){
	$('#pass').keyup(function()
	{
		//checkStrength($('#pass').val())
	})
	/*
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
	*/
//})
