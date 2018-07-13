</script>
<script type="text/javascript" charset="utf-8">

$('.btn-next-step-1').on('click', function() {
	if ($("#risque-1").prop("checked"))
	{
		$('#modalAucunRisque').modal('show');
	}
	else
	{
		$('.mod_1').hide();
		$('.mod_2').show();
		$("#el_1").css("background-color", "#039841");
		$("#el_1").css("border-color", "#039841");
		$("#el_1").removeClass("title_selected");
		$("#el_2").addClass("title_selected");
		$('.btn-next-inactive').css("display", "flex");
	}
});

$('.btn-next-step-2').on('click', function() {
	$('.mod_2').hide();
	$('.mod_3').css("display", "flex");
	$("#el_2").css("background-color", "#039841");
	$("#el_2").css("border-color", "#039841");
	$("#el_2").removeClass("title_selected");
	$("#el_3").addClass("title_selected");
	$('.btn-next-inactive').css("display", "flex");
});


$('.btn-next-step-3').on('click', function() {
	$('.mod_3').hide();
	$('.mod_4').css("display", "flex");
	$("#el_3").css("background-color", "#039841");
	$("#el_3").css("border-color", "#039841");
	$("#el_3").removeClass("title_selected");
	$("#el_4").addClass("title_selected");
	$('.btn-next-inactive').css("display", "flex");
});

$('.btn-next-step-4').on('click', function() {
	/*
	$('.mod_4').hide();
	$('.mod_5').css("display", "flex");
	$('#el_5').show();
	$("#el_4").css("background-color", "#039841");
	$("#el_4").css("border-color", "#039841");
	$("#el_4").removeClass("title_selected");
	$("#el_5").addClass("title_selected");
	$('.btn-next-inactive').css("display", "flex");
	*/
	$('.mod_4').hide();
	$('.mod_6').css("display", "flex");
	$("#el_4").css("background-color", "#039841");
	$("#el_4").css("border-color", "#039841");
	$("#el_4").removeClass("title_selected");
	$("#el_6").addClass("title_selected");
	$('.btn-next-inactive').css("display", "flex");
});

$('.btn-next-step-5').on('click', function() {
/*
	$('.mod_5').hide();
	$('.mod_6').css("display", "flex");
	$("#el_5").css("background-color", "#039841");
	$("#el_5").css("border-color", "#039841");
	$("#el_5").removeClass("title_selected");
	$("#el_6").addClass("title_selected");
	$('.btn-next-inactive').css("display", "flex");
	*/
	$('.mod_5').hide();
	$('.mod_9').css("display", "flex");
	$("#el_5").css("background-color", "#039841");
	$("#el_5").css("border-color", "#039841");
	$("#el_5").removeClass("title_selected");
	$("#el_9").addClass("title_selected");
	$('.btn-next-inactive').css("display", "flex");
});

$('.btn-next-step-6').on('click', function() {
	if (
		$('#dispose_actions').prop('checked') ||
		$('#dispose_fcpi_fip_fcpr').prop('checked') ||
		$('#dispose_opcvm').prop('checked') ||
		$('#dispose_assurance_vie').prop('checked') ||
		$('#dispose_obligations').prop('checked') ||
		$('#dispose_scpi').prop('checked') ||
		$('#dispose_opci').prop('checked') ||
		$('#dispose_liquidite').prop('checked') ||
		$('#dispose_pea').prop('checked') ||
		$('#dispose_immobilier_direct').prop('checked') ||
		$('#dispose_crowdfunding').prop('checked')
	)
	{
		$("#el_7").css('display', 'flex');
		$('.mod_6').hide();
		$('.mod_7').css("display", "flex");
		$("#el_6").css("background-color", "#039841");
		$("#el_6").css("border-color", "#039841");
		$("#el_6").removeClass("title_selected");
		$("#el_7").addClass("title_selected");
		$('.btn-next-inactive').css("display", "flex");
	}
	else
	{
		$('.mod_6').hide();
		$('.mod_5').css("display", "flex");
		$('#el_5').show();
		$("#el_6").css("background-color", "#039841");
		$("#el_6").css("border-color", "#039841");
		$("#el_6").removeClass("title_selected");
		$("#el_5").addClass("title_selected");
		$('.btn-next-inactive').css("display", "flex");
	}
});

$('.btn-next-step-7').on('click', function() {
	$('.mod_7').hide();
	$('.mod_5').css("display", "flex");
	$('#el_5').show();
	$("#el_7").css("background-color", "#039841");
	$("#el_7").css("border-color", "#039841");
	$("#el_7").removeClass("title_selected");
	$("#el_5").addClass("title_selected");
	$('.btn-next-inactive').css("display", "flex");
/*
	$('.mod_7').hide();
	$('.mod_9').css("display", "flex");
	$("#el_7").css("background-color", "#039841");
	$("#el_7").css("border-color", "#039841");
	$("#el_7").removeClass("title_selected");
	$("#el_9").addClass("title_selected");
	$('.btn-next-inactive').css("display", "flex");
	*/
});

<?php
/*
$('.btn-next-step-8').on('click', function() {
	$('.mod_8').hide();
	$('.mod_9').css("display", "flex");
	$("#el_8").css("background-color", "#039841");
	$("#el_8").css("border-color", "#039841");
	$("#el_8").removeClass("title_selected");
	$("#el_9").addClass("title_selected");
	$('.btn-next-inactive').css("display", "flex");
});

$('.btn-next-step-6').on('click', function() {
	$("#el_6").removeClass("title_selected");
	//$("#el_6").addClass("title_selected");
	$('.btn-next-inactive').css("display", "flex");
});
*/?>

$('.inputFirstBlock').on("change", function() {
	$(".btn-next-step-1").css("display", "flex");
	$(".btn-next-inactive").css("display", "none");
})

$('.inputFirst2Block').on("change", function() {
	if (
		($("#immoyes").prop("checked") || $('#immono').prop('checked')) &&
		($("#finanyes").prop("checked") || $('#finanno').prop('checked'))
	)
	{
		$(".btn-next-step-2").css("display", "flex");
		$(".btn-next-inactive").css("display", "none");
	}
})

$('.inputSecondBlock').on("change", function() {
	$(".btn-next-step-3").css("display", "flex");
	$(".btn-next-inactive").css("display", "none");
})

$('.inputThirdBlock').on("change", function() {
	$(".btn-next-step-4").css("display", "flex");
	$(".btn-next-inactive").css("display", "none");
})

$('.inputFourthBlock').on("change", function() {
	$(".btn-next-step-5").css("display", "flex");
	$(".btn-next-inactive").css("display", "none");
})

$('.inputFifthBlock').on("change", function() {
	$(".btn-next-step-6").css("display", "flex");
	$(".btn-next-inactive").css("display", "none");
})

$('.inputSixthBlock').on("change", function() {
	$(".btn-next-step-7").css("display", "flex");
	$(".btn-next-inactive").css("display", "none");
})

$('.inputSeventhBlock').on("change", function() {
	$(".btn-next-step-8").css("display", "flex");
	$(".btn-next-inactive").css("display", "none");
})

$('.inputEightBlock').on("change", function() {
	var rt = true;
	if (
		!$("#si_jinvesti-0").prop("checked") &&
		!$("#si_jinvesti-1").prop("checked") &&
		!$("#si_jinvesti-2").prop("checked")
	)
		rt = false;
	for (var i = 0; i < <?=count(ProfilInvestisseur::$_listQuestions)?>; i++)
	{
		if (
			!$("#Quiz-" + i + "-Oui").prop("checked") &&
			!$("#Quiz-" + i + "-Ne_sais_pas").prop("checked") &&
			!$("#Quiz-" + i + "-Non").prop("checked")
		)
		rt = false;
	}
	if (rt)
	{
		$('#sendBtn').css("display", "block");
		$("#el_6").css("background-color", "#039841");
		$("#el_6").css("border-color", "#039841");
		$('body').scrollTop(1E10);
	}
})

$('#sendBtn').on('click', function( event ) {
	$('#setProjectForm').submit();
});

<?php
if ($this->isAdd)
{
	?>
var animationTime = null;
var animationState = 0;


function setDisplayRotationPourcentSearching(angle, callBack) {
	animationState = 0.05;
	clearInterval(animationTime);
	animationTime = setInterval(function() {
		if (animationState > 1)
		{
			clearInterval(animationTime);
			setDisplayRotationPourcent(
				angle
			);
			callBack(angle);
		}
		else
		{
			setDisplayRotationPourcent(
			(((Math.random() * 60) - 30) * (1 - animationState)) + angle
			);
		}
		animationState *= 1.3;
	}, 200);
}

setDisplayRotationPourcentSearching(<?=$this->profilInstance->getScore() * 5?>,function(data) {
});


function calcCursorColor(angle) {
	// up		#025487			2		84			135
	// down		#96bacd			150		186			205
	var red = Math.floor(angle * ((2 - 150) / 100) + 150);
	var green = Math.floor(angle * ((84 - 186) / 100) + 186);
	var blue = Math.floor(angle * ((135 - 205) / 100) + 205);
	return ("rgb(" + red + ", " + green + ", " + blue + ")");
}

function setDisplayRotationPourcent(angle) {
	$('#cursorAnim').css("fill", calcCursorColor(angle));
	$('.animProfilCursor .circle').css("border-color", calcCursorColor(angle));
	if (angle > 100)
		angle = 100;
	else if (angle < 0)
		angle = 0;
	angle = (angle * 1.3) - 65;
	setDisplayRotation(angle);
}

function setDisplayRotation(angle) {
	$('.animProfilCursor svg').css({
		"-ms-transform": "rotate(" + angle + "deg)",
		"-webkit-transform": "rotate(" + angle + "deg)",
		"transform": "rotate(" + angle + "deg)"
		}
	);
}
<?php
}
if ($this->isAdd)
{
	if ($this->profilInstance->getScore() < 10)
	{
		?>
		$('.profilBtn button').on("click", function () {
			if (
				$('#estimation').prop("checked") &&
				$('#note').prop("checked")
			)
				;
			else
				$('#msgAlertSending').css("display","inline-block");
		});
		<?php
	}
}
?>

