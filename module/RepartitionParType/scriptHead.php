</script>
<script type="text/javascript" charset="utf-8">
$(document).ready(
	function (){
		setTimeout(
			function(){
				$(".progress-bar-info2").css("width", "<?= $this->variable?>%");
			},
			600
		);
	}
);
function display_val(x, e){
	var event = window.event || e;
//	var title = document.getElementById("name_scpi").children;
	document.getElementById("msg_help").setAttribute("style", "background: rgba(255,255,255,1); position: absolute; left: " + event.pageX + "px; top: " + (event.pageY + 20) +"px; display: initial;");
	document.getElementById("msg_help").children[0].innerHTML = "Capital variable / Capital fixe";
	document.getElementById("m_more").innerHTML = (<?= $this->variable?>).toFixed(2) + " % / " + (<?= $this->fixe?>).toFixed(2) + " %";
}

function disable_val(e){
	var event = window.event || e;
	document.getElementById("msg_help").setAttribute("style", "position: absolute; left: " + (event.pageX + 20) + "px; top: " + event.pageY +"px; display: none;");
}
