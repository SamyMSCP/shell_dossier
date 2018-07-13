</script>
<script type="text/javascript" charset="utf-8">
	function init_OpportuniteClient() { }
</script>
<script type="text/x-template" id="opportuniteClientEditor">
		<?php include('opportuniteClientEditorTemplate.php') ?>
</script>
<script type="text/x-template" id="opportuniteClientList">
		<?php include('opportuniteClientListTemplate.php') ?>
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
<script type="text/javascript" charset="utf-8">
	Vue.component(
		'opportuniteClientList',
		{
			methods: {
				setNewOpportunite: function() {
					this.$store.commit('NEW_OPPORTUNITE', this.$store.getters.getDh.id);
					$('#modalOpportunite').modal('show');
				},
				setSelectedOpportunite: function(data) {
					this.$store.commit('SET_OPPORTUNITE', data);
					$('#modalOpportunite').modal('show');
				},
			},
			template: '#opportuniteClientList'
		}
	);
