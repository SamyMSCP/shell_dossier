</script>
<script type="text/javascript" charset="utf-8">
	store.registerModule('centreinteret', {
		state: {
			lst: <?= json_encode(CentreInteret::getFromKeyValue("visible", 1)) ?>,
		},
		mutations: {
			SET_MODIF_CI: function (state, data) {
				state.modif = data;
			}
		},
		getters: {
			getLstCentreInteret: function(state, getters)
			{
				return state.lst;
			}
		}
	});
