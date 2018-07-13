</script>
<script type="text/x-template" id="opportuniteListComponent">
		<?php require_once ('template/opportunity.php'); ?>
</script>
<script>
	Vue.component(
		'opportuniteListComponent', {
			data: function() { return {} },
			computed: { },
			template: "#opportuniteListComponent",
			methods: {
				setNueFilter: function() {
					if (this.$store.state.opportunite.typeFilter != 1)
						this.$store.state.opportunite.typeFilter = 1;
					else
						this.$store.state.opportunite.typeFilter = 0;
				},
				setUsuFilter: function() {
					if (this.$store.state.opportunite.typeFilter != 2)
						this.$store.state.opportunite.typeFilter = 2;
					else
						this.$store.state.opportunite.typeFilter = 0;
				}
			}
		}
	);
