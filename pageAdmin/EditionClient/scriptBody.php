</script>
<script type="text/javascript" charset="utf-8">
	<?php
	if ($this->collaborateur->getType() != "prospecteur")
	{
		?>
		var vueInstance = new Vue({
			el: "#appEditionClient",
			store: store
		});
		var Viii = new Vue({ el: "#transac", store: store})
		<?php
	}
	if (isset($GLOBALS['GET']['transac']) && intval($GLOBALS['GET']['transac'])){
		?>
	$(document).ready(function (){
		// console.log("It's OK");
		Viii.$store.commit('changeSelect', "<?=intval($GLOBALS['GET']['transac'])?>");
	});
		<?php
	}
	?>

	var vueInstance = new Vue({
		el: ".forVueApp",
		store: store
	});
