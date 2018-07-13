</script>
<script type="text/javascript">
var vueAdressePostale = new Vue({
	el: "#VueAdressePostale",
	<?php
	if ($this->dh->needAdressValidation())
	{
		?>
		mounted: function() {
			$('#modal_adresse_postale').modal('show');
		},
		<?php
	}
	?>
	store: store
})
