</script>
<script type="text/javascript" charset="utf-8">

function showOnglet(idOnglet) {
	$('.onglets').hide();
	$('.onglet_' + idOnglet).show();
	$('.onglet_btn').removeClass("selected");
	$('.onglet_btn_' + idOnglet).addClass("selected");
}

<?php
if (isset($GLOBALS['GET']['onglet'])) {
	?>
	window.addEventListener("load", function() {
		showOnglet('<?=$GLOBALS['GET']['onglet']?>');
	});
	<?php
}
