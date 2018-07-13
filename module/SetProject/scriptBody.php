</script>
<script type="text/javascript" charset="utf-8">

var dataNeed = <?=json_encode($this->dataNeed)?>;

var haveAutre = false;

function ft_rewrite_v(){
}

$( function() {
	$( "#sortable" ).sortable({
		revert: true
	});
});

function checkDataNewConjoin() {
	if (
		$('#conjoinName').val().length >= 2 &&
		$('#conjoinFirstName').val().length >= 2
	)
	{
		$(".btn-next-step-1").css("display", "flex");
		$(".btn-next-inactive").css("display", "none");
	}
	else
	{
		$(".btn-next-step-1").css("display", "none");
		$(".btn-next-inactive").css("display", "flex");
	}
}

function checkDataNewConjoinSeul() {
	if (
		$('#conjoinSeulName').val().length >= 2 &&
		$('#conjoinSeulFirstName').val().length >= 2
	)
	{
		$(".btn-next-step-1").css("display", "flex");
		$(".btn-next-inactive").css("display", "none");
	}
	else
	{
		$(".btn-next-step-1").css("display", "none");
		$(".btn-next-inactive").css("display", "flex");
	}
}

function checkDataNewPp() {
	if (
		$('#parentName').val().length >= 2 &&
		$('#parentFirstName').val().length >= 2
	)
	{
		$(".btn-next-step-1").css("display", "flex");
		$(".btn-next-inactive").css("display", "none");
	}
	else
	{
		$(".btn-next-step-1").css("display", "none");
		$(".btn-next-inactive").css("display", "flex");
	}
}

function checkDataNewEnfantPp() {
	if (
		$('#enfantName').val().length >= 2 &&
		$('#enfantFirstName').val().length >= 2
	)
	{
		$(".btn-next-step-1").css("display", "flex");
		$(".btn-next-inactive").css("display", "none");
	}
	else
	{
		$(".btn-next-step-1").css("display", "none");
		$(".btn-next-inactive").css("display", "flex");
	}
}

function checkDataNewEntreprise() {
	if ($('#entrepriseName').val().length >= 2)
	{
		$(".btn-next-step-1").css("display", "flex");
		$(".btn-next-inactive").css("display", "none");
	}
	else
	{
		$(".btn-next-step-1").css("display", "none");
		$(".btn-next-inactive").css("display", "flex");
	}
}

$('.quiConjoin input').on("keyup", checkDataNewConjoin);
$('.quiConjoinSeul input').on("keyup", checkDataNewConjoinSeul);
$('.quiParent input').on("keyup", checkDataNewPp);
$('.quiEnfant input').on("keyup", checkDataNewEnfantPp);
$('.quiEntreprise input').on("keyup", checkDataNewEntreprise);

$('.btn-next-step-1 > div').on('click', function() {
	$('.alone').hide();
	$('.quiConjoin').hide();
	$('.quiParent').hide();
	$('.quiEnfant').hide();
	$('.quiEntreprise').hide();
	$('.mod_1').hide();
	$('.mod_2').css("display", "flex");
	$("#el_1").css("background-color", "#039841");
	$("#el_1").css("border-color", "#039841");
	$("#el_1").removeClass("title_selected");
	$("#el_2").addClass("title_selected");
	$('.btn-next-inactive').css("display", "flex");
});

$('.btn-next-step-2 > div').on('click', function() {

	if (
		dragModule.data[0] == 5 ||
		dragModule.data[1] == 5 ||
		dragModule.data[2] == 5
	)
	{
		$('#modalPrevention').modal('show');
	}
	else
	{
		$('.mod_2').hide();
		$('.mod_3').css("display", "flex");
		$("#el_2").css("background-color", "#039841");
		$("#el_2").css("border-color", "#039841");
		$('#step2Validation').hide();
		$("#el_2").removeClass("title_selected");
		$("#el_3").addClass("title_selected");
		$('.btn-next-inactive').css("display", "flex");
	}
});

$("#btnContinue").on("click", function() {
	$('.mod_2').hide();
	$('.mod_3').css("display", "flex");
	$("#el_2").css("background-color", "#039841");
	$("#el_2").css("border-color", "#039841");
	$("#el_2").removeClass("title_selected");
	$("#el_3").addClass("title_selected");
	$('#modalPrevention').modal('hide');
	$('#step2Validation').hide();
	$('.btn-next-inactive').css("display", "flex");
});

$('.btn-next-step-3 > div').on('click', function() {
	$('.mod_3').hide();
	$('.mod_4').show();
	$("#el_3").css("background-color", "#039841");
	$("#el_3").css("border-color", "#039841");
	$('#step3Validation').hide();
	$("#el_3").removeClass("title_selected");
	$("#el_4").addClass("title_selected");
	$('.btn-next-inactive').css("display", "flex");
});

$('.btn-next-step-4 > div').on('click', function() {
	$('.mod_4').hide();
	if (
		$('#yes').prop("checked") ||
		$('#yes2').prop("checked")
		)
	{
		$('.mod_5').show();
		$('#el_5').show();
		$("#el_5").addClass("title_selected");
	}
	else
	{
		$('.mod_6').show();
		$('#el_6').show();
		$("#el_6").addClass("title_selected");
	}
	$("#el_4").css("background-color", "#039841");
	$("#el_4").css("border-color", "#039841");
	$('#step4Validation').hide();
	$("#el_4").removeClass("title_selected");
	$('.btn-next-inactive').css("display", "flex");
});

$('.btn-next-step-5 > div').on('click', function() {
	$('.mod_6').show();
	$('#el_6').show();
	$('.mod_5').hide();
	$("#el_5").css("background-color", "#039841");
	$("#el_5").css("border-color", "#039841");
	$('#step5Validation').hide();
	$("#el_5").removeClass("title_selected");
	$("#el_6").addClass("title_selected");
	$('.btn-next-inactive').css("display", "flex");
});

$('.btn-next-step-6 > div').on('click', function() {
	$('.mod_6').hide();
		sendFormulaire();
		//$('#sendBtn').css("display", "block");
	$("#el_6").css("background-color", "#039841");
	$("#el_6").css("border-color", "#039841");
	$('#step6Validation').hide();
	$("#el_6").removeClass("title_selected");
	$('.btn-next-inactive').css("display", "flex");
});

function checkShowConjoinInfo() {
	// On affiche la select box uniquement 
	if (dataNeed['haveCouple'] || !dataNeed['otherPp'])
	{
		$('#selectConjoin').hide();
	}
	if ($('#compteConjoin').val() == "0")
	{
		$('.conjoinNewInfo').css("display", "flex");
		checkDataNewConjoin();
	}
	else
	{
		$('.conjoinNewInfo').hide();
		//$('#quiConjoin .btn-next-step-1').show();
		$(".btn-next-step-1").css("display", "flex");
		$(".btn-next-inactive").css("display", "none");
	}
}

function checkShowConjoinSeulInfo() {
	// On affiche la select box uniquement 
	if (dataNeed['haveCouple'] || !dataNeed['otherPp'])
	{
		$('#selectConjoinSeul').hide();
	}
	if ($('#compteConjoinSeul').val() == "0")
	{
		$('.conjoinSeulNewInfo').css("display", "flex");
		//checkDataNewConjoin();
		checkDataNewConjoinSeul();
	}
	else
	{
		$('.conjoinSeulNewInfo').hide();
		$(".btn-next-step-1").css("display", "flex");
		$(".btn-next-inactive").css("display", "none");
	}
}

function checkShowParentInfo() {
	if (!dataNeed['otherPp'])
	{
		$('#selectOther').hide();
	}
	if ($('#compteParent').val() == "0")
	{
		$('.parentNewInfo').css("display", "flex");
		checkDataNewPp();
	}
	else
	{
		$('.parentNewInfo').hide();
		$(".btn-next-step-1").css("display", "flex");
		$(".btn-next-inactive").css("display", "none");
	}
}

function checkShowEnfantInfo() {
	if (!dataNeed['otherEnfantPp'])
	{
		$('#selectOtherEnfant').hide();
	}
	if ($('#compteEnfant').val() == "0")
	{
		$('.enfantNewInfo').css("display", "flex");
		checkDataNewEnfantPp();
	}
	else
	{
		$('.childNewInfo').hide();
		$(".btn-next-step-1").css("display", "flex");
		$(".btn-next-inactive").css("display", "none");
	}
}

function checkShowEntrepriseInfo() {
	if (!dataNeed['nbrPm'])
	{
		$('#selectEntreprise').hide();
	}
	if ($('#compteEntreprise').val() == "0")
	{
		$('.entrepriseNewInfo').show();
		checkDataNewEntreprise();
	}
	else
	{
		$('.entrepriseNewInfo').hide();
		$(".btn-next-step-1").css("display", "flex");
		$(".btn-next-inactive").css("display", "none");
	}
}

$('#compteConjoin').on("change", checkShowConjoinInfo);
$('#compteConjoinSeul').on("change", checkShowConjoinSeulInfo);
$('#compteParent').on("change", checkShowParentInfo);
$('#compteEnfant').on("change", checkShowEnfantInfo);
$('#compteEntreprise').on("change", checkShowEntrepriseInfo);


$('.inputFirstBlock').on("change", function() {
	if ($('#forwhom-1').prop("checked"))
	{
		$(".btn-next-step-1").css("display", "flex");
		$(".btn-next-inactive").css("display", "none");
	}
	else
	{
		$(".btn-next-step-1").css("display", "none");
		$(".btn-next-inactive").css("display", "flex");
	}
	if ($('#forwhom-2').prop("checked"))
	{
		$('.quiConjoin').css("display", "flex");
		if (dataNeed['haveCouple'] || !dataNeed['otherPp'])
			$('label > .quiConjoin').hide();
		else
			$('label > .quiConjoin').css("display", "flex");
		checkShowConjoinInfo();
	}
	else
		$('.quiConjoin').hide();
	if ($('#forwhom-3').prop("checked"))
	{
		$('.quiParent').css("display", "flex");
		if (!dataNeed['otherPp'])
			$('label > .quiParent').hide();
		else
			$('label > .quiParent').css("display", "flex");
		checkShowParentInfo();
	}
	else
		$('.quiParent').hide();
	if ($('#forwhom-6').prop("checked"))
	{
		$('.quiEnfant').css("display", "flex");
		if (!dataNeed['otherEnfantPp'])
			$('label > .quiEnfant').hide();
		else
			$('label > .quiEnfant').css("display", "flex");
		checkShowEnfantInfo();
	}
	else
		$('.quiEnfant').hide();
	if ($('#forwhom-4').prop("checked"))
	{
		$('.quiEntreprise').css("display", "flex");

		if (!dataNeed['nbrPm'])
			$('label > .quiEntreprise').hide();
		else
			$('label > .quiEntreprise').css("display", "flex");
		checkShowEntrepriseInfo();
	}
	else
		$('.quiEntreprise').hide();
	if ($('#forwhom-5').prop("checked"))
	{
		$('.quiConjoinSeul').css("display", "flex");
		if (dataNeed['haveCouple'] || !dataNeed['otherPp'])
			$('label > .quiConjoinSeul').hide();
		else
			$('label > .quiConjoinSeul').css("display", "flex");
		checkShowConjoinSeulInfo();
	}
	else
		$('.quiConjoinSeul').hide();
})

$('.inputSecondBlock').on("change", function() {
	$('.btn-next-step-3').css("display", "flex");
	$('.btn-next-inactive').css("display", "none");
})

$('.inputThirdBlock').on("change", function() {
	$('.btn-next-step-4').css("display", "flex");
	$('.btn-next-inactive').css("display", "none");
})

$('.inputFourthBlock').on("change", function() {
	$('.btn-next-step-5').css("display", "flex");
	$('.btn-next-inactive').css("display", "none");
})

$('.inputSixthBlock').on("change", function() {
	$('.btn-next-step-6').css("display", "flex");
	$('.btn-next-inactive').css("display", "none");
})

$('#sendBtn').on('click', function( event ) {
	var list = $("#sortable" ).children()
	var dataList = [];
	for (var i = 0; i < list.length; i++)
		dataList.push($(list[i]).val());
	$('#listObjectif').val((JSON.stringify(dataList)));
	$('#setProjectForm').submit();
	event.preventDefault();
});

function dragControle() {
	var that = this;
	that.isDragging = false;
	that.block = null;
	that.removeBlock = null;
	that.receiver = null;
	that.data = {
		0:null,
		1:null,
		2:null
	};
	that.tmpData = {
		"val":null,
		"txt":"",
		"haveData":0
	};
	that.setIsDragging = function (elm) {
		that.block = $(elm.currentTarget);
	}

	that.moveElement = function (elm) {
		if (that.block == null && that.removeBlock == null)
			return ;
		$(elm.currentTarget).addClass("inDrag");
		that.tmpData.txt = $(elm.currentTarget).text();
		$(elm.currentTarget).text(that.block.text());
		event.preventDefault();
	}
	that.moveElementOver  = function (elm) {
		if (that.block == null && that.removeBlock == null)
			return ;
		event.preventDefault();
	}
	that.moveElementExit = function (elm) {
		if (that.block == null && that.removeBlock == null)
			return ;
		var position = $(elm.currentTarget).parent()[0].attributes[0].value;
		if (that.data[position] == null)
			$(elm.currentTarget).removeClass("inDrag");
		$(elm.currentTarget).text(that.tmpData.txt);
	}
	that.moveElementEnd = function (elm) {
		if (that.block == null)
			return ;
		$(elm.currentTarget).prop("draggable", "true")
		var position = $(elm.currentTarget).parent()[0].attributes[0].value;
		var val = that.block.parent()[0].attributes[0].value;
		if (that.data[position] != null)
			$('#blockDragable' + that.data[position]).removeClass("isGrey");
		that.data[position] = val;
		that.block.addClass("isGrey");
		that.block = null;
		if (
			that.removeBlock == null ||
			that.removeBlock.parent()[0].attributes[0].value == position
		)
		{
			checkListBlock();
			that.removeBlock = null;
			return ;
		}
        that.removeBlock.text("Glissez l'objectif " + (Number(position) + 1));
		that.removeBlock.removeClass("inDrag");
		that.removeBlock.removeAttr("draggable", "false");
		that.data[that.removeBlock.parent()[0].attributes[0].value] = null;
		that.removeBlock = null;
		checkListBlock();
	}
	$(".blockDragReceiver").on("dragenter", that.moveElement);
	$(".blockDragReceiver").on("dragover", that.moveElementOver);
	$(".blockDragReceiver").on("dragleave", that.moveElementExit);
	$(".blockDragReceiver").on("drop", that.moveElementEnd);

	$(".blockDraggable").on("dragstart", function (elm) {
		dragModule.setIsDragging(elm);
		that.removeBlock = null;
		//console.log("coucou");
	});

	$(".blockDraggable").on("dragend", function (elm) {
		that.block = null;
		that.removeBlock = null;
	});

	that.setIsRemoving = function (elm) {
		that.removeBlock = $(elm.currentTarget);
	}

	that.removeElementOver = function (elm) {
		if (that.removeBlock == null)
			return ;
		event.preventDefault();
	};
	that.removeElement = function (elm) {
		if (that.removeBlock == null)
			return ;
		event.preventDefault();
	};
	that.removeElementEnd = function (elm) {
		if (that.removeBlock == null)
			return ;
		var position = that.removeBlock.parent()[0].attributes[0].value;
		$('#blockDragable' + that.data[position]).removeClass("isGrey");
		that.data[position] = null;
        that.removeBlock.text("Glissez l'objectif " + (Number(position) + 1));
		that.removeBlock.removeClass("inDrag");
		that.removeBlock.removeAttr("draggable", "false");

		that.removeBlock = null;
		checkListBlock();
	};
	$(".blockRight").on("dragover", that.removeElementOver);
	$(".blockRight").on("dragenter", that.removeElement);
	$(".blockRight").on("drop", that.removeElementEnd);

	$(".blockDragReceiver").on("dragstart", function (elm) {
		var value = that.data[$(elm.currentTarget).parent()[0].attributes[0].value];
		that.block = $("#blockDragable" + value);
		dragModule.setIsRemoving(elm);
	});

	$(".blockDragReceiver").on("dragend", function (elm) {
		that.removeBlock = null;
		that.block = null;
	});
	that.reinitialize = function () {
		$(".blockRight .blockDraggable").removeClass("isGrey");
		that.data[0] = null;
		that.data[1] = null;
		that.data[2] = null;
		$('.blockDragReceiver').removeClass('inDrag');

		checkListBlock();
		//Glissez l'objectif 3
	}
	return (this);
}

var dragModule = new dragControle();

$('#autreText').on('keyup', checkListBlock);

function checkListBlock() {
	if (
		dragModule.data[0] == 8 ||
		dragModule.data[1] == 8 ||
		dragModule.data[2] == 8
	)
	{
		$('.Precision').addClass('PrecisionShowed');
		haveAutre = true;
	}
	else
	{
		$('.Precision').removeClass('PrecisionShowed');
		haveAutre = false;
	}
	if (
		dragModule.data[0] != null &&
		dragModule.data[1] != null &&
		dragModule.data[2] != null &&
		(!haveAutre || $('#autreText').val().length > 2)
	)
	{
			$('.btn-next-step-2').css("display", "flex");
			$('.btn-next-inactive').css("display", "none");
	}
	else
	{
		$('.btn-next-step-2').css("display", "none");
		$('.btn-next-inactive').css("display", "flex");
	}
    if (dragModule.data[0] == null)
        $('.blockLeft div[position=0] span').text("Glissez l'objectif 1");
    if (dragModule.data[1] == null)
        $('.blockLeft div[position=1] span').text("Glissez l'objectif 2");
    if (dragModule.data[2] == null)
        $('.blockLeft div[position=2] span').text("Glissez l'objectif 3");
}

function sendFormulaire() {
	var dataList = [];
	if (
		dragModule.data[0] == null &&
		dragModule.data[1] == null &&
		dragModule.data[2] == null
	)
		return ;
	dataList.push(Number(dragModule.data[0]));
	dataList.push(Number(dragModule.data[1]));
	dataList.push(Number(dragModule.data[2]));
	$('#listObjectif').val((JSON.stringify(dataList)));
	$('#setProjectForm').submit();
}
