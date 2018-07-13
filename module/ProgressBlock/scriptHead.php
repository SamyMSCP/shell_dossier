</script>
<script>
var ProgressBlockNbrElem = <?=$this->nbrElm?>;
var ProgressBlockNewPosition = <?=$this->prc?>;

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
	ProgressBlockNewPosition = new_position;
	var $bar = $('.progress-bar');
	$bar.addClass('active');
	$bar.addClass('progress-bar-striped');
	var new_value = (100 * (ProgressBlockNewPosition / (ProgressBlockNbrElem - 1)));
	var actual_value = 100 * (  $bar.width() / $bar.parent().width());

	if (actual_value < new_value) {
		var progress = setInterval(function() {
			actual_value = 100 * (  $bar.width() / $bar.parent().width());
			ProgressBlockChangeValue(actual_value / 100);
			if (actual_value >= new_value) {
				clearInterval(progress);
				$('.progress-bar').removeClass('active');
				$('.progress-bar').removeClass('progress-bar-striped');
			} else {
					$bar.css("width" , ((actual_value + 5) + "%"));
			}
		}, 400);
	}
	else if (actual_value > new_value) {
		var progress = setInterval(function() {
			actual_value = 100 * (  $bar.width() / $bar.parent().width());
			ProgressBlockChangeValue(actual_value / 100);
			if (actual_value <= new_value) {
				clearInterval(progress);
				$('.progress-bar').removeClass('active');
				$('.progress-bar').removeClass('progress-bar-striped');
			} else {
				$bar.css("width" , ((actual_value - 5) + "%"));
			}
		}, 100);
	}
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
