</script>
<script type="text/javascript" charset="utf-8">
	store.registerModule('conseillerstore', {
		state: {
			conseiller: JSON.parse(`<?= json_encode($this->consel)?>`)
		},
		getters: {
			getConseiller: function(state, getters) {
				return (state.conseiller);
			}
		}
	});