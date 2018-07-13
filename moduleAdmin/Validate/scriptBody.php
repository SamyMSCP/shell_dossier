$('#isf').change(function() {
	setTimeout(function () { $('#form-isf').submit() }, 400);
})
</script>
<script type="text/javascript" charset="utf-8">

<?php
if ($this->collaborateur->getType() != "prospecteur")
{
	?>
	var vueInstance = new Vue({
		el: "#vuCentreInteretApp",
		store: store
	});

	var vueInstance = new Vue({
		el: "#vueSetParrain",
		store: store
	});

	var vueInstanceAdresse = new Vue({
		el: "#SetAdresseValideComponent",
		store: store
	});
	<?php
}
?>
