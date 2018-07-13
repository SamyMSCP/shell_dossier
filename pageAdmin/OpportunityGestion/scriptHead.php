<script type="text/x-template" id="opportuniteClientEditor">
	<?php include('opportuniteClientEditorTemplate.php') ?>
</script>

<script type="text/javascript" charset="utf-8">
	Vue.component(
		'opportuniteClientEditor',
		{
			computed: {
				selected: function() {
					return (this.$store.state.opportunite.selected);
				}
			},
			methods: {
				saveSelected: function() {
					this.$store.dispatch("OPPORTUNITY_SAVE", this.selected).then(
						function() {
							$('#modalOpportunite').modal('hide');
						},
						function() {
							console.log("pas pu enregistrer !");
						}
					);
				}
			},
			template: '#opportuniteClientEditor'
		}
	);
</script>
