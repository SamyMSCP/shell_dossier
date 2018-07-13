</script>
<script>

var vm = new Vue({
	el: ".vueApp",
	store: store,
	data: {
		token: "<?=$_SESSION['csrf'][0]?>",
	},
	methods: {
		setSelectedOpportunite: function(data) {
			this.$store.commit('SET_OPPORTUNITE', data);
			$('#modalOpportunite').modal('show');
		}
	}
});
