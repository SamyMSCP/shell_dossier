</script>
<script type="text/javascript" charset="utf-8">
	store.registerModule('societeGestion', {
		state: {
			lst: <?=json_encode(SocieteDeGestion::getForStore())?>,
		},
		getters: {
			getAllSocieteGestion: function(state, getters) {
				return (state.lst);
			},
			getSocieteGestion: function(state, getters) {
				return (function (id) {
					return (state.lst.find(function(elm) {
						return (elm.id == id)
					}));
				})
			}
		}
	})
