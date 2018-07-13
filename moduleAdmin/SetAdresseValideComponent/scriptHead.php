</script>
<script type="text/x-template" id="setAdresseValideTemplate">
	<?php
	/*
	<div class="<?=($this->dh->adresseOk()) ? "validateTrue" : "" ?>">
	*/
	?>
	<div :class="{validateTrue: $store.getters.getDh.adresse_valide}" style="cursor:pointer;" @click="toggleAdresseValide()">
		Adresse postale
		<img src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" />
	</div>
</script>
<script type="text/javascript" charset="utf-8">

	Vue.component(
		'setAdresseValideComponent',
		{
			computed: {
				getDh: function() {
					return (this.$store.getters.getDh);
				}
			},
			data: function() {
				return ({ });
			},
			methods: {
				toggleAdresseValide: function() {
					this.$store.dispatch("DH_TOOGLE_ADRESSE_VALIDE", this.$store.getters.getDh).then(
						function() {
							msgBox.show("Le changement d'état de la validation de l'adresse à bien été changé !");

						},
						function() {}
					);;
				}
			},
			template: "#setAdresseValideTemplate"
		}
	);
