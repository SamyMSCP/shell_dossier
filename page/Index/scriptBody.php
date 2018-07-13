</script>
<script type="text/javascript" charset="utf-8">

$(window).load(function()
{
	$('.modal_push_tel').modal('show');
	$('.modal_push_info').modal('show');
	$('.modal_ie').modal('show');
	setTimeout(function(){
		$('.modal_push_info').modal('hide');
	}, 3000);
});

$(document).ready(

	function()
	{
		$('#oklmmmm').modal('show');
			var myVar;
			myVar = setTimeout(showPage, 5000);
	},

	$('#cpass').keyup(function()
	{
		checkStrength($('#cpass').val())
	}),

	$('#cpass2').keyup(function()
	{
		if ($('#cpass2').val() != $('#cpass').val()){
			$('.success_2').css("display", "none");
			$('.erreur5').css("display", "initial");
			$('#cpass2').css("border", "2px solid #01528A");
			canSend2 = false;
		}
		else
		{
			$('.success_2').css("display", "initial");
			$('.erreur5').css("display", "none");
			$('#pass2').css("border", "2px solid #018A13");
			canSend2 = true;
		}
	 })

);

var canSend = false;
var canSend2 = false;

function showPage()
{
	document.getElementById("loader").style.display = "none";
	document.getElementById("infoid").style.display = "initial";
}

function checkStrength(password){
	if (!password.match(/([a-z])/g))
	{
		$('.pass_erreur1').css("display", "none");
		$('.pass_erreur2').css("display", "none");
		$('.pass_erreur3').css("display", "initial");
		$('.pass_erreur4').css("display", "none");
		$('.success_1').css("display", "none");
		$('#cpass').css("border", "2px solid #01528A");
		canSend = false;
	}
	else if (!password.match(/([A-Z])/g))
	{
		$('.pass_erreur1').css("display", "none");
		$('.pass_erreur2').css("display", "initial");
		$('.pass_erreur3').css("display", "none");
		$('.pass_erreur4').css("display", "none");
		$('.success_1').css("display", "none");
		$('#cpass').css("border", "2px solid #01528A");
		canSend = false;
	}
	else if (!password.match(/[0-9]/g))
	{
		$('.pass_erreur1').css("display", "none");
		$('.pass_erreur2').css("display", "none");
		$('.pass_erreur3').css("display", "none");
		$('.pass_erreur4').css("display", "initial");
		$('.success_1').css("display", "none");
		$('#cpass').css("border", "2px solid #01528A");
		canSend = false;
	}
	else if (password.length < 8)
	{
		console.log(password);
		$('.pass_erreur1').css("display", "initial");
		$('.pass_erreur2').css("display", "none");
		$('.pass_erreur3').css("display", "none");
		$('.pass_erreur4').css("display", "none");
		$('.success_1').css("display", "none");
		$('#cpass').css("border", "2px solid #01528A");
		canSend = false;
	}
	else
	{
		$('.pass_erreur1').css("display", "none");
		$('.pass_erreur2').css("display", "none");
		$('.pass_erreur3').css("display", "none");
		$('.pass_erreur4').css("display", "none");
		$('.success_1').css("display", "initial");
		$('#cpass').css("border", "2px solid #018A13");
		canSend = true;
	}
}
