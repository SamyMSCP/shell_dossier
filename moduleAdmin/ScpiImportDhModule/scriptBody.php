</script>
<script type="text/javascript" charset="utf-8">

function haveChange() {
	$('#btn_valider').hide();
	$('#btn_actualiser').show();
}

$('input, select').on("change", function() {
	haveChange();
});

window.addEventListener("load", function() {
	$('#btn_actualiser').hide();
});

$('form').bind("keypress", function(e) {
		if (e.keyCode == 13) {
			e.preventDefault();
			return false;
		}
	}
);
