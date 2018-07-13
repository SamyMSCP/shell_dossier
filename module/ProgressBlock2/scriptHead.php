</script>
<script>
var ProgressBlockNbrElem = <?=$this->nbrElm?>;
var ProgressBlockNewPosition = <?=$this->prc?>;

var realPosition = 0;
var wantChangeStatus = 0;

var ProgressBlockChangeValue = function (new_position) {
	new_position *= ProgressBlockNbrElem;
	var blocks = $(".block");
	for (var i = 0; i < ProgressBlockNbrElem; i++) {
		if (new_position > i + 1) {
			ProgressBlockSetDone(i);
		}
		else if (new_position > i) {
			ProgressBlockSetCurrent(i);
		}
		else {
			ProgressBlockSetUndone(i);
		}
	}
}

var ProgressBlockMove = function (new_position) {
	//realPosition = new_position;
	ProgressBlockNewPosition = new_position;
	var $bar = $('.progress-bar');
	$bar.addClass('active');
	//$bar.addClass('progress-bar-striped');
	var new_value = (100 * (ProgressBlockNewPosition / (ProgressBlockNbrElem - 1)));
	var actual_value = 100 * (  $bar.width() / $bar.parent().width());

	$bar.css("width" , new_value + "%");
	ProgressBlockChangeValue(new_value / 100);
}

var ProgressBlockSetDone = function (position) {
	$(".block" + position).attr("src", "<?= $this->getPath() ?>img/MS-Numbers-Done_Nbr" + (position + 1) + ".png");
	return "coucou";
}
var ProgressBlockSetUndone = function (position) {
	$(".block" + position).attr("src", "<?= $this->getPath() ?>img/MS-Numbers-Undone_Nbr" + (position + 1) + ".png");
	return "coucou";
}

var ProgressBlockSetCurrent = function (position) {
	$(".block" + position).attr("src", "<?= $this->getPath() ?>img/MS-Numbers_Nbr" + (position + 1) + ".png");
	return "coucou";
}

function setProgressTmp(pos) {
	if (wantChangeStatus == 0)
	{
		$('.progress_real').hide();
		$('.progress_tmp').show();
		ProgressBlockMove(pos);
	}
}

function setProgressReal() {
	if (wantChangeStatus == 0)
	{
		$('.progress_real').show();
		$('.progress_tmp').hide();
		ProgressBlockMove(realPosition);
	}
}

$('.progImg img').mouseenter(setProgressTmp);

$('.progImg p').mouseenter(setProgressTmp);

$('.progImg img').mouseout(setProgressReal);
$('.progImg p').mouseout(setProgressReal);

function changeTransactionStatus(nStatus) {
	$('.progress_real').hide();
	$('.progress_tmp').show();
	ProgressBlockMove(nStatus);
	$('.realyChangeStatus').css("display", "flex");
	$('#nStatus').val(nStatus);
	wantChangeStatus = 1;
}

function changeTransactionStatusNo() {
	$('.realyChangeStatus').hide();
	wantChangeStatus = 0;
	setProgressReal();
}
